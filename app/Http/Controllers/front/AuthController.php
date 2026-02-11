<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\LoginRequest;
use App\Http\Requests\front\ForgotPasswordRequest;
use App\Http\Requests\front\RegisterRequest;
use App\Http\Requests\front\ResetPasswordRequest;
use App\Mail\UserRegistered;
use App\Models\User;
use App\Services\front\AuthService;
use App\Services\front\CartService;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function showLogin()
    {
        return view('front.auth.login');
    }

    public function showRegister()
    {
        return view('front.auth.register');
    }

    public function handleLogin(LoginRequest $request)
{
    $data = $request->validated();
    //Capture guest session id before auth::attempt regenerates the session id
    $guestSessionId = Session::get('session_id') ?: $request->session()->getId();

    $credentials = ['email' => $data['email'], 'password' => $data['password']];

    // Pre-check if inactive return friendly error
    $user = User::where('email', $data['email'])->first();
    if ($user && (int)$user->status === 0) {
        return response()->json([
            'success' => false,
            'errors' => ['email' => ['Your account is inactive. Please contact support']]
        ], 422);
    }

    if ($this->authService->attemptLogin($credentials, $request->boolean('remember'))) {
        //merge guest cart ->user cart
        app(CartService::class)->migrateGuestCartToUser($guestSessionId, auth()->id());

        return response()->json([
            'success' => true,
            'message' => 'Login successful.',
            'redirect' => url('/')
        ]);
    }

    return response()->json([
        'success' => false,
        'errors' => ['email' => ['Invalid credentials']]
    ], 422);
}

public function register(RegisterRequest $request)
{
    $data = $request->validated();

    //Capture guest session id before auth::attempt regenerates the session id
    $guestSessionId = Session::get('session_id') ?: $request->session()->getId();

    $user = $this->authService->registerUser($data);

    // Send email with logging
    try {
        \Log::info('Attempting to send email to: ' . $user->email);
        Mail::to($user->email)->send(new UserRegistered($user));
        \Log::info('Email sent successfully!');
    } catch (\Exception $e) {
        \Log::error('Email failed: ' . $e->getMessage());
    }

    // Auto Login
    auth()->login($user);

    //merge guest cart ->user cart
        app(CartService::class)->migrateGuestCartToUser($guestSessionId, auth()->id());

    return response()->json([
        'success' => true,
        'message' => 'Registration successful.',
        'redirect' => url('/')
    ]);
}

public function showForgotForm()
{
    return view('front.auth.forgot_password');
}

public function sendResetLink(ForgotPasswordRequest $request){
    $validated = $request->validated();
    $status = Password::sendResetLink(
        ['email'=>$validated['email']]
    );

    if($status === Password::RESET_LINK_SENT){
        return response()->json([
            'status' => 'success', // ✅ Changed from 'success'
            'message' => __($status)
        ]);
    }

    return response()->json([
        'status' => 'error', // ✅ Added
        'errors' =>['email' => [__($status)]]
    ], 422);
}

public function showResetForm($token)
{
    return view('front.auth.reset_password',['token'=>$token]);
}


public function resetPassword(ResetPasswordRequest $request)
{
    $validated = $request->validated();

    $status = Password::reset(
        [
            'email'=>$validated['email'],
            'password' =>$validated['password'],
            'password_confirmation' => $validated['password_confirmation'],
            'token' => $validated['token'],
        ],
        function($user,$password){
            $user->password = Hash::make($password);
            $user->setRememberToken(Str::random(60));
            $user->save();

            event(new PasswordReset($user));
            //auto login after reset (optional)
            auth()->login($user);
        }
    );

    if($status === Password::PASSWORD_RESET){
        return response()->json([
            'status' => 'success', // ✅ Changed from 'success'
            'message' => __($status),
            'redirect' => url('/')
        ]);
    }

    return response()->json([
        'status' => 'error', // ✅ Added
        'errors' => ['email' => [__($status)]]
    ], 422);
}
    public function handleLogout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}

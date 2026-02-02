<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\LoginRequest;
use App\Http\Requests\front\RegisterRequest;
use App\Mail\UserRegistered;
use App\Models\User;
use App\Services\front\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

    return response()->json([
        'success' => true,
        'message' => 'Registration successful.',
        'redirect' => url('/')
    ]);
}
    public function handleLogout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}

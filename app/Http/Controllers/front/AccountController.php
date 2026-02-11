<?php
namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Http\Requests\front\UpdateAccountRequest;
use App\Http\Requests\front\UpdatePasswordRequest;
use App\Models\Country;
use App\Services\front\AuthService;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->middleware('auth');
        $this->authService = $authService;
    }

    public function showAccount()
    {
        $user = Auth::user();
        $countries = Country::where('is_active', true)->orderBy('name')->get();
        $uk = Country::where('name', 'United Kingdom')->first();
        $ukStates = $uk ? $uk->states()->orderBy('name')->get() : collect();

        return view('front.auth.account', compact('user', 'countries', 'ukStates'));
    }

    public function updateAccount(UpdateAccountRequest $request)
    {
        $user = Auth::user();
        $data = $request->validated();
        $user = $this->authService->updateAccount($user, $data);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Account updated',
                'user' => $user->only(['name', 'email', 'address_line1', 'address_line2', 'city', 'county', 'postcode', 'country', 'phone', 'company'])
            ]);
        }

        return redirect()->route('user.account')->with('success', 'Account Details Updated Successfully.'); // ✅ Fixed typo: 'acount' -> 'account'
    }

    public function changePassword(UpdatePasswordRequest $request)
    {
       $user = Auth::user();
       $this->authService->changePassword($user, $request->validated()['password']);
       if($request->wantsJson() || $request->ajax()){
        return response()->json([
            'success' => true,
            'message' => 'Password changed successfully.'
        ]);
       }
       return redirect()->route('user.account')->with('success','Password Changed Successfully.');
    }
}

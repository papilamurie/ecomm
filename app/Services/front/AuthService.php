<?php
namespace App\Services\front;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function registerUser(array $data): User
    {
        $user = User::create([
            'name' => $data['name'] ?? null,
            'email' => $data['email'],
            'password' => Hash::make($data['password']), // Hash the password
            'user_type' => $data['user_type'] ?? 'Customer',
            'status' => 1
        ]);

        return $user; // Return the created user
    }

    public function attemptLogin(array $credentials, bool $remember = false): bool
    {
        $user = User::where('email', $credentials['email'])->first();

        if($user && (int)$user->status === 0){
            return false;
        }

        if(Auth::attempt($credentials, $remember)){ // Simplified
            session()->regenerate();
            return true;
        }

        return false;
    }

    /**
 *
 * @param \App\Models\User $user
 * @param array $data
 * @return \App\Models\User
 */

public function updateAccount(\App\Models\User $user, array $data): \App\Models\User
{
    // Ensure email cannot be changed here even when provided
    if (isset($data['email'])) {
        unset($data['email']);
    }

    // If country isn't base UK use county_text if provided
    if (isset($data['country']) && $data['country'] !== 'United Kingdom') {
        if (!empty($data['county_text'])) {
            $data['county'] = $data['county_text']; // FIXED: Was == (comparison), should be = (assignment)
        }
    }

    // Remove transient county_text
    if (isset($data['county_text'])) {
        unset($data['county_text']);
    }

    // Fill allowed attributes (User::$fillable controls which fields can be mass assigned)
    $user->fill($data);
    $user->save();
    return $user;
}

public function changePassword(\App\Models\User $user, string $newPassword): \App\Models\User
{
    $user->password = \Illuminate\Support\Facades\Hash::make($newPassword);
    $user->setRememberToken(\Illuminate\Support\Str::random(60));
    $user->save();
    //Optional log out other devices after password change
    \Illuminate\Support\Facades\Auth::logoutOtherDevices($newPassword);
    return $user;
}


}

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
}

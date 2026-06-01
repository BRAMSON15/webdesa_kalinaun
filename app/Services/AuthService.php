<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AuthService
{
    /**
     * Attempt user login
     */
    public function login($email, $password)
    {
        $credentials = [
            'email' => $email,
            'password' => $password,
        ];

        if (Auth::attempt($credentials)) {
            return Auth::user();
        }

        return null;
    }

    /**
     * Register new user
     */
    public function register($data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'masyarakat',
            'nik' => $data['nik'],
            'alamat' => $data['alamat'],
            'no_hp' => $data['no_hp'],
            'tanggal_lahir' => $data['tanggal_lahir'],
            'jenis_kelamin' => $data['jenis_kelamin'],
        ]);

        return $user;
    }

    /**
     * Logout user
     */
    public function logout()
    {
        Auth::logout();
    }

    /**
     * Send reset token
     */
    public function sendResetToken($email)
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return null;
        }

        $resetToken = Str::random(32);
        $expiresAt = Carbon::now()->addHours(24);

        $user->update([
            'reset_token' => $resetToken,
            'reset_token_expires_at' => $expiresAt,
        ]);

        return [
            'token' => $resetToken,
            'email' => $user->email,
        ];
    }

    /**
     * Validate reset token
     */
    public function validateResetToken($token, $email)
    {
        $user = User::where('email', $email)
            ->where('reset_token', $token)
            ->first();

        if (!$user) {
            return null;
        }

        if ($user->reset_token_expires_at && Carbon::now()->isAfter($user->reset_token_expires_at)) {
            return null;
        }

        return $user;
    }

    /**
     * Update password
     */
    public function updatePassword($token, $email, $password)
    {
        $user = User::where('email', $email)
            ->where('reset_token', $token)
            ->first();

        if (!$user) {
            return false;
        }

        if ($user->reset_token_expires_at && Carbon::now()->isAfter($user->reset_token_expires_at)) {
            return false;
        }

        $user->update([
            'password' => Hash::make($password),
            'reset_token' => null,
            'reset_token_expires_at' => null,
        ]);

        return true;
    }

    /**
     * Get redirect route based on user role
     */
    public function getRedirectRoute($user)
    {
        switch ($user->role) {
            case 'admin':
                return 'admin.dashboard';
            case 'kades':
                return 'kades.dashboard';
            case 'masyarakat':
                return 'masyarakat.dashboard';
            default:
                return 'home';
        }
    }
}

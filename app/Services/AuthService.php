<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AuthService
{
    protected $auditService;

    public function __construct(LoginAuditService $auditService)
    {
        $this->auditService = $auditService;
    }

    /**
     * Login masyarakat dengan nama lengkap dan NIK
     */
    public function loginMasyarakat($name, $nik)
    {
        // Check if login is blocked
        if ($this->auditService->isLoginBlocked($name, 'masyarakat')) {
            throw new \Exception('Terlalu banyak percobaan login gagal. Silakan coba lagi dalam 15 menit.');
        }

        $user = User::where('name', $name)
            ->where('nik', $nik)
            ->where('role', 'masyarakat')
            ->first();

        if (!$user) {
            $this->auditService->recordLoginAttempt($name, 'masyarakat', false, 'Invalid credentials');
            return null;
        }

        if (!$user->is_active) {
            $this->auditService->recordLoginAttempt($name, 'masyarakat', false, 'Account inactive');
            throw new \Exception('Akun Anda tidak aktif. Hubungi admin untuk informasi lebih lanjut.');
        }

        // Manual login
        Auth::login($user);
        $this->auditService->recordSuccessfulLogin($user);
        $this->auditService->clearFailedAttempts($name, 'masyarakat');
        
        return $user;
    }

    /**
     * Login admin/kades dengan email dan password
     */
    public function loginAdmin($email, $password)
    {
        // Check if login is blocked
        if ($this->auditService->isLoginBlocked($email, 'admin')) {
            throw new \Exception('Terlalu banyak percobaan login gagal. Silakan coba lagi dalam 15 menit.');
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->auditService->recordLoginAttempt($email, 'admin', false, 'User not found');
            return null;
        }

        if (!Hash::check($password, $user->password)) {
            $this->auditService->recordLoginAttempt($email, 'admin', false, 'Invalid password');
            return null;
        }

        if (!in_array($user->role, ['admin', 'kades'])) {
            $this->auditService->recordLoginAttempt($email, 'admin', false, 'Invalid role');
            throw new \Exception('Akses ditolak. Hanya admin dan kades yang dapat login di portal ini.');
        }

        if (!$user->is_active) {
            $this->auditService->recordLoginAttempt($email, 'admin', false, 'Account inactive');
            throw new \Exception('Akun Anda tidak aktif. Hubungi admin untuk informasi lebih lanjut.');
        }

        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $this->auditService->recordSuccessfulLogin($user);
            $this->auditService->clearFailedAttempts($email, 'admin');
            return Auth::user();
        }

        return null;
    }

    /**
     * Generic login (backward compatibility)
     */
    public function login($email, $password, $role = null)
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->auditService->recordLoginAttempt($email, 'generic', false, 'User not found');
            return null;
        }

        if (!Hash::check($password, $user->password)) {
            $this->auditService->recordLoginAttempt($email, 'generic', false, 'Invalid password');
            return null;
        }

        if ($role && $user->role !== $role) {
            $this->auditService->recordLoginAttempt($email, 'generic', false, 'Invalid role');
            throw new \Exception("User tidak memiliki akses ke portal {$role}. Silakan login dengan akun yang sesuai.");
        }

        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $this->auditService->recordSuccessfulLogin($user);
            return Auth::user();
        }

        return null;
    }

    /**
     * Register new user (masyarakat only)
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
            'is_active' => true,
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
            'role' => $user->role,
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

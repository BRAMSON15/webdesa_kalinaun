<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LoginAuditService
{
    /**
     * Record login attempt
     */
    public function recordLoginAttempt($identifier, $type, $success = false, $reason = null)
    {
        DB::table('login_attempts')->insert([
            'identifier' => $identifier,
            'type' => $type, // 'masyarakat', 'admin', 'kades'
            'success' => $success,
            'reason' => $reason,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'created_at' => now(),
        ]);
    }

    /**
     * Check if login is blocked due to too many attempts
     */
    public function isLoginBlocked($identifier, $type, $maxAttempts = 5, $lockoutMinutes = 15)
    {
        $failedAttempts = DB::table('login_attempts')
            ->where('identifier', $identifier)
            ->where('type', $type)
            ->where('success', false)
            ->where('created_at', '>=', now()->subMinutes($lockoutMinutes))
            ->count();

        return $failedAttempts >= $maxAttempts;
    }

    /**
     * Get remaining attempts
     */
    public function getRemainingAttempts($identifier, $type, $maxAttempts = 5, $lockoutMinutes = 15)
    {
        $failedAttempts = DB::table('login_attempts')
            ->where('identifier', $identifier)
            ->where('type', $type)
            ->where('success', false)
            ->where('created_at', '>=', now()->subMinutes($lockoutMinutes))
            ->count();

        return max(0, $maxAttempts - $failedAttempts);
    }

    /**
     * Record successful login
     */
    public function recordSuccessfulLogin($user)
    {
        $user->update([
            'last_login_at' => now(),
            'last_login_ip' => request()->ip(),
        ]);

        $this->recordLoginAttempt($user->email, $user->role, true);
    }

    /**
     * Clear failed attempts
     */
    public function clearFailedAttempts($identifier, $type)
    {
        DB::table('login_attempts')
            ->where('identifier', $identifier)
            ->where('type', $type)
            ->where('success', false)
            ->delete();
    }

    /**
     * Get login history for user
     */
    public function getLoginHistory($userId, $limit = 10)
    {
        $user = User::find($userId);
        
        if (!$user) {
            return [];
        }

        return DB::table('login_attempts')
            ->where('identifier', $user->email)
            ->where('success', true)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}

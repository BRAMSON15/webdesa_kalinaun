<?php

namespace App\Services;

use App\Models\Bansos;
use App\Models\PenerimaBansos;

class BansosApplicationService
{
    /**
     * Get active bansos programs with quota
     */
    public function getActiveBansos($page = 10)
    {
        return Bansos::aktif()->withQuota()->paginate($page);
    }

    /**
     * Get bansos detail
     */
    public function getBansosDetail(Bansos $bansos)
    {
        return $bansos;
    }

    /**
     * Check if user already applied
     */
    public function hasUserApplied($userId, $bansosId)
    {
        return PenerimaBansos::where('bansos_id', $bansosId)
            ->where('user_id', $userId)
            ->exists();
    }

    /**
     * Apply for bansos
     */
    public function applyBansos($user, Bansos $bansos)
    {
        if (!$bansos->hasQuota()) {
            throw new \Exception('Kuota program bansos sudah habis');
        }

        if ($this->hasUserApplied($user->id, $bansos->id)) {
            throw new \Exception('Anda sudah mendaftar untuk program ini');
        }

        return PenerimaBansos::create([
            'bansos_id' => $bansos->id,
            'user_id' => $user->id,
            'nik' => $user->nik,
            'nama_penerima' => $user->name,
            'alamat' => $user->alamat,
            'no_hp' => $user->no_hp,
            'status' => 'menunggu',
        ]);
    }

    /**
     * Get user's applications
     */
    public function getUserApplications($userId, $page = 10)
    {
        return PenerimaBansos::where('user_id', $userId)
            ->with('bansos')
            ->orderBy('created_at', 'desc')
            ->paginate($page);
    }

    /**
     * Get application detail
     */
    public function getApplicationDetail($userId, PenerimaBansos $penerima)
    {
        if ($penerima->user_id !== $userId) {
            throw new \Exception('Unauthorized');
        }

        return $penerima->load('bansos');
    }

    /**
     * Cancel application
     */
    public function cancelApplication($userId, PenerimaBansos $penerima)
    {
        if ($penerima->user_id !== $userId || $penerima->status !== 'menunggu') {
            throw new \Exception('Unauthorized');
        }

        return $penerima->delete();
    }
}

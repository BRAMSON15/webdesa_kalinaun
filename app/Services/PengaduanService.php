<?php

namespace App\Services;

use App\Models\Pengaduan;

class PengaduanService
{
    /**
     * Get user's complaints
     */
    public function getUserComplaints($userId, $filters = [])
    {
        $query = Pengaduan::where('user_id', $userId);

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->orderBy('tanggal_pengaduan', 'desc')->paginate(10);
    }

    /**
     * Create complaint
     */
    public function createComplaint($userId, $data)
    {
        $data['user_id'] = $userId;
        $data['status'] = 'baru';
        $data['tanggal_pengaduan'] = now();

        return Pengaduan::create($data);
    }

    /**
     * Get complaint detail
     */
    public function getComplaintDetail($userId, $id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        if ($pengaduan->user_id !== $userId) {
            throw new \Exception('Unauthorized');
        }

        return $pengaduan;
    }

    /**
     * Update complaint
     */
    public function updateComplaint($userId, Pengaduan $pengaduan, $data)
    {
        if ($pengaduan->user_id !== $userId || $pengaduan->status !== 'baru') {
            throw new \Exception('Unauthorized');
        }

        return $pengaduan->update($data);
    }

    /**
     * Delete complaint
     */
    public function deleteComplaint($userId, Pengaduan $pengaduan)
    {
        if ($pengaduan->user_id !== $userId || $pengaduan->status !== 'baru') {
            throw new \Exception('Unauthorized');
        }

        return $pengaduan->delete();
    }
}

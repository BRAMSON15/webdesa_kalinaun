<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class TblMasyarakat extends Authenticatable
{
    use Notifiable;

    protected $table = 'tbl_masyarakat';
    protected $primaryKey = 'id_masyarakat';

    protected $fillable = [
        'nik',
        'nama', 
        'email',
        'no_hp',
        'password'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    // Relationships
    public function pengajuanSurat()
    {
        return $this->hasMany(TblPengajuanSurat::class, 'id_masyarakat', 'id_masyarakat');
    }

    // Methods sesuai Class Diagram
    public function register($data)
    {
        return self::create([
            'nik' => $data['nik'],
            'nama' => $data['nama'],
            'email' => $data['email'],
            'no_hp' => $data['no_hp'],
            'password' => Hash::make($data['password'])
        ]);
    }

    public function login($email, $password)
    {
        $user = self::where('email', $email)->first();
        
        if ($user && Hash::check($password, $user->password)) {
            return $user;
        }
        
        return false;
    }

    public function buatPengajuan($data)
    {
        return $this->pengajuanSurat()->create([
            'keterangan' => $data['keterangan'],
            'tgl_pengajuan' => now()->toDateString(),
            'jenis_surat' => $data['jenis_surat'],
            'status' => 'proses'
        ]);
    }

    // Kolom email digunakan untuk notifikasi otomatis
    public function getEmailForPasswordReset()
    {
        return $this->email;
    }
}

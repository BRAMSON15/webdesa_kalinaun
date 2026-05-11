<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'nik', 'alamat', 'no_hp', 'tanggal_lahir', 'jenis_kelamin', 'is_active'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'tanggal_lahir' => 'date',
            'is_active' => 'boolean',
        ];
    }

    // Relationships
    public function pengajuanSurats()
    {
        return $this->hasMany(PengajuanSurat::class);
    }

    public function informasiDesas()
    {
        return $this->hasMany(InformasiDesa::class, 'created_by');
    }

    public function arsipDokumens()
    {
        return $this->hasMany(ArsipDokumen::class, 'uploaded_by');
    }

    // Helper methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isKades()
    {
        return $this->role === 'kades';
    }

    public function isMasyarakat()
    {
        return $this->role === 'masyarakat';
    }
}

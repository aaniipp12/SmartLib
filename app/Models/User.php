<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'nama',
        'nis',
        'nisn',
        'kelas_id',
        'alamat',
        'no_hp',
        'email',
        'nama_ibu',
        'nama_ayah',
        'foto',
        'agama',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'tanggal_lahir' => 'date',
        ];
    }

    // Relationships
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function peminjamanSebagaiSiswa()
    {
        return $this->hasMany(Peminjaman::class, 'siswa_id');
    }

    public function peminjamanSebagaiAdmin()
    {
        return $this->hasMany(Peminjaman::class, 'admin_id');
    }

    // Helper methods
    public function isSuperAdmin()
    {
        return $this->hasRole('super_admin');
    }

    public function isAdmin()
    {
        return $this->hasRole(['admin', 'super_admin']);
    }

    public function isSiswa()
    {
        return $this->hasRole('siswa');
    }
}

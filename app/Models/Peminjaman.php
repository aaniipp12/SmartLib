<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    protected $fillable = [
        'siswa_id',
        'admin_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_pinjam' => 'date',
            'tanggal_kembali' => 'date',
        ];
    }

    // Relationships
    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function detailPeminjaman()
    {
        return $this->hasMany(DetailPeminjaman::class);
    }

    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class);
    }

    // Helper methods
    public function isOverdue()
    {
        return $this->status === 'terlambat' || 
               ($this->status === 'dipinjam' && now()->toDateString() > $this->tanggal_kembali);
    }

    public function getDaysOverdue()
    {
        if ($this->status === 'dipinjam' && now()->toDateString() > $this->tanggal_kembali) {
            return now()->diffInDays($this->tanggal_kembali);
        }
        return 0;
    }
}

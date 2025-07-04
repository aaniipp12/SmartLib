<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory;

    protected $table = 'pengembalian';

    protected $fillable = [
        'peminjaman_id',
        'tanggal_dikembalikan',
        'terlambat_hari',
        'total_denda',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_dikembalikan' => 'date',
            'total_denda' => 'decimal:2',
        ];
    }

    // Relationships
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }

    // Helper methods
    public function hasDenda()
    {
        return $this->total_denda > 0;
    }
}

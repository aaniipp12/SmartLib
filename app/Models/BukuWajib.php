<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuWajib extends Model
{
    use HasFactory;

    protected $table = 'buku_wajib';

    protected $fillable = [
        'judul',
        'mata_pelajaran',
        'kelas_id',
        'penerbit',
        'isbn',
        'tahun_terbit',
        'stok',
    ];

    protected function casts(): array
    {
        return [
            'tahun_terbit' => 'integer',
        ];
    }

    // Relationships
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function detailPeminjaman()
    {
        return $this->morphMany(DetailPeminjaman::class, 'buku');
    }

    // Helper methods
    public function isAvailable()
    {
        return $this->stok > 0;
    }
}

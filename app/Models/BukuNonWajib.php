<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuNonWajib extends Model
{
    use HasFactory;

    protected $table = 'buku_non_wajib';

    protected $fillable = [
        'judul',
        'kategori_id',
        'penulis',
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
    public function kategori()
    {
        return $this->belongsTo(KategoriBuku::class, 'kategori_id');
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

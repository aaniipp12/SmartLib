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
        'tingkat',
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
    public function kelasYangMenggunakan()
    {
        return $this->hasMany(Kelas::class, 'tingkat', 'tingkat');
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

    public function getTingkatNamaAttribute()
    {
        return "Kelas {$this->tingkat}";
    }
}
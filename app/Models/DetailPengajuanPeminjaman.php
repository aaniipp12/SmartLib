<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPengajuanPeminjaman extends Model
{
    use HasFactory;

    protected $table = 'detail_pengajuan_peminjaman';

    protected $fillable = [
        'pengajuan_peminjaman_id',
        'buku_wajib_id',
        'buku_non_wajib_id',
        'jumlah'
    ];

    // Relationships
    public function pengajuanPeminjaman()
    {
        return $this->belongsTo(PengajuanPeminjaman::class);
    }

    public function bukuWajib()
    {
        return $this->belongsTo(BukuWajib::class);
    }

    public function bukuNonWajib()
    {
        return $this->belongsTo(BukuNonWajib::class);
    }

    // Accessors
    public function getBukuAttribute()
    {
        return $this->bukuWajib ?? $this->bukuNonWajib;
    }

    public function getJudulBukuAttribute()
    {
        if ($this->bukuWajib) {
            return $this->bukuWajib->judul;
        }
        
        if ($this->bukuNonWajib) {
            return $this->bukuNonWajib->judul;
        }

        return 'Buku tidak ditemukan';
    }

    public function getPenulisAttribute()
    {
        if ($this->bukuWajib) {
            return $this->bukuWajib->penulis;
        }
        
        if ($this->bukuNonWajib) {
            return $this->bukuNonWajib->penulis;
        }

        return '-';
    }
}
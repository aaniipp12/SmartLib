<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPeminjaman extends Model
{
    use HasFactory;

    protected $table = 'detail_peminjaman';

    protected $fillable = [
        'peminjaman_id',
        'buku_id',
        'jenis_buku',
        'jumlah',
    ];

    // Relationships
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }

    public function bukuWajib()
    {
        return $this->belongsTo(BukuWajib::class, 'buku_id')
            ->where('jenis_buku', 'wajib');
    }

    public function bukuNonWajib()
    {
        return $this->belongsTo(BukuNonWajib::class, 'buku_id')
            ->where('jenis_buku', 'non_wajib');
    }

    // Accessors
    public function getBukuAttribute()
    {
        if ($this->jenis_buku === 'wajib') {
            return BukuWajib::find($this->buku_id);
        } else {
            return BukuNonWajib::find($this->buku_id);
        }
    }
}
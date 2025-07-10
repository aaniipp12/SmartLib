<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PengajuanPeminjaman extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_peminjaman';

    protected $fillable = [
        'kode_pengajuan',
        'user_id',
        'jenis_peminjaman',
        'status',
        'catatan_admin',
        'tanggal_pengajuan',
        'tanggal_diproses',
        'diproses_oleh',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_pengajuan' => 'datetime',
            'tanggal_diproses' => 'datetime',
        ];
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function diprosesOleh()
    {
        return $this->belongsTo(User::class, 'diproses_oleh');
    }

    public function detailPengajuan()
    {
        return $this->hasMany(DetailPengajuanPeminjaman::class);
    }

    public function peminjaman()
    {
        return $this->hasOne(Peminjaman::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeDisetujui($query)
    {
        return $query->where('status', 'disetujui');
    }

    public function scopeDitolak($query)
    {
        return $query->where('status', 'ditolak');
    }

    // Accessors
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'bg-warning',
            'disetujui' => 'bg-success',
            'ditolak' => 'bg-danger',
            'dipinjam' => 'bg-info',
            'dibatalkan' => 'bg-secondary',
        ];

        return $badges[$this->status] ?? 'bg-secondary';
    }

    public function getStatusTextAttribute()
    {
        $texts = [
            'pending' => 'Menunggu Persetujuan',
            'disetujui' => 'Disetujui',
            'ditolak' => 'Ditolak',
            'dipinjam' => 'Sedang Dipinjam',
            'dibatalkan' => 'Dibatalkan',
        ];

        return $texts[$this->status] ?? 'Unknown';
    }

    public function getTotalBuku()
    {
        return $this->detailPengajuan->sum('jumlah');
    }

    // Static methods
    public static function generateKodePengajuan()
    {
        $prefix = 'PJ';
        $date = Carbon::now()->format('Ymd');
        $lastNumber = static::whereDate('created_at', Carbon::today())
            ->count() + 1;
        
        return $prefix . $date . str_pad($lastNumber, 4, '0', STR_PAD_LEFT);
    }
}
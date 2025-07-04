<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';

    protected $fillable = [
        'tingkat',
        'nama_kelas',
        'tahun_ajaran',
    ];

    // Relationships
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function bukuWajib()
    {
        return $this->hasMany(BukuWajib::class);
    }

    // Helper methods
    public function getNamaLengkapAttribute()
    {
        return "Kelas {$this->tingkat}{$this->nama_kelas}";
    }
}

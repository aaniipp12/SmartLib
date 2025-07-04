<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            'Novel',
            'Sejarah',
            'Biografi',
            'Sains',
            'Agama',
            'Komik',
            'Ensiklopedia',
            'Referensi'
        ];

        foreach ($kategoris as $kategori) {
            DB::table('kategori_buku')->insert([
                'nama' => $kategori,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

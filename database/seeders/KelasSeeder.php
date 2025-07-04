<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        $tahunAjaran = '2024/2025';
        $tingkats = ['7', '8', '9'];
        $namaKelas = ['A', 'B', 'C', 'D'];

        foreach ($tingkats as $tingkat) {
            foreach ($namaKelas as $nama) {
                DB::table('kelas')->insert([
                    'tingkat' => $tingkat,
                    'nama_kelas' => $nama,
                    'tahun_ajaran' => $tahunAjaran,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}

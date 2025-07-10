<?php

namespace Database\Seeders;

use App\Models\BukuWajib;
use App\Models\BukuNonWajib;
use App\Models\KategoriBuku;
use Illuminate\Database\Seeder;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        // Sample Buku Wajib dengan tingkat
        $bukuWajib = [
            [
                'judul' => 'Matematika Diskrit',
                'mata_pelajaran' => 'Matematika',
                'tingkat' => '7',
                'penerbit' => 'Erlangga',
                'isbn' => '9781234567890',
                'tahun_terbit' => 2023,
                'stok' => 50,
            ],
            [
                'judul' => 'Bahasa Indonesia untuk SMP',
                'mata_pelajaran' => 'Bahasa Indonesia',
                'tingkat' => '7',
                'penerbit' => 'Gramedia',
                'isbn' => '9781234567891',
                'tahun_terbit' => 2023,
                'stok' => 45,
            ],
            [
                'judul' => 'IPA Terpadu Kelas 8',
                'mata_pelajaran' => 'IPA',
                'tingkat' => '8',
                'penerbit' => 'Yudhistira',
                'isbn' => '9781234567892',
                'tahun_terbit' => 2023,
                'stok' => 40,
            ],
            [
                'judul' => 'IPS untuk SMP Kelas 8',
                'mata_pelajaran' => 'IPS',
                'tingkat' => '8',
                'penerbit' => 'Erlangga',
                'isbn' => '9781234567893',
                'tahun_terbit' => 2023,
                'stok' => 35,
            ],
            [
                'judul' => 'Bahasa Inggris Kelas 9',
                'mata_pelajaran' => 'Bahasa Inggris',
                'tingkat' => '9',
                'penerbit' => 'Oxford',
                'isbn' => '9781234567894',
                'tahun_terbit' => 2023,
                'stok' => 30,
            ],
        ];

        foreach ($bukuWajib as $buku) {
            BukuWajib::create($buku);
        }

        // Sample Buku Non-Wajib
        $kategoris = KategoriBuku::all();
        
        if ($kategoris->count() > 0) {
            $bukuNonWajib = [
                [
                    'judul' => 'Laskar Pelangi',
                    'kategori_id' => $kategoris->where('nama', 'Novel')->first()->id ?? $kategoris->first()->id,
                    'penulis' => 'Andrea Hirata',
                    'penerbit' => 'Bentang Pustaka',
                    'isbn' => '9786020331447',
                    'tahun_terbit' => 2005,
                    'stok' => 25,
                ],
                [
                    'judul' => 'Sejarah Indonesia Modern',
                    'kategori_id' => $kategoris->where('nama', 'Sejarah')->first()->id ?? $kategoris->first()->id,
                    'penulis' => 'M.C. Ricklefs',
                    'penerbit' => 'Gadjah Mada University Press',
                    'isbn' => '9789794202456',
                    'tahun_terbit' => 2008,
                    'stok' => 20,
                ],
                [
                    'judul' => 'Biografi Soekarno',
                    'kategori_id' => $kategoris->where('nama', 'Biografi')->first()->id ?? $kategoris->first()->id,
                    'penulis' => 'Cindy Adams',
                    'penerbit' => 'Yayasan Bung Karno',
                    'isbn' => '9789799589041',
                    'tahun_terbit' => 2014,
                    'stok' => 15,
                ],
                [
                    'judul' => 'Fisika untuk Pemula',
                    'kategori_id' => $kategoris->where('nama', 'Sains')->first()->id ?? $kategoris->first()->id,
                    'penulis' => 'Stephen Hawking',
                    'penerbit' => 'Mizan',
                    'isbn' => '9786022914051',
                    'tahun_terbit' => 2020,
                    'stok' => 18,
                ],
                [
                    'judul' => 'Naruto Volume 1',
                    'kategori_id' => $kategoris->where('nama', 'Komik')->first()->id ?? $kategoris->first()->id,
                    'penulis' => 'Masashi Kishimoto',
                    'penerbit' => 'Elex Media',
                    'isbn' => '9789792248234',
                    'tahun_terbit' => 2019,
                    'stok' => 30,
                ],
            ];

            foreach ($bukuNonWajib as $buku) {
                BukuNonWajib::create($buku);
            }
        }
    }
}
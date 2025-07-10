<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Super Admin
        $superAdmin = User::create([
            'name' => 'Super Administrator',
            'email' => 'superadmin@smartlib.com',
            'password' => Hash::make('password'),
            'agama' => 'Islam',
            'jenis_kelamin' => 'L',
            'email_verified_at' => now(),
        ]);
        $superAdmin->assignRole('super_admin');

        // Create Admin
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@smartlib.com',
            'password' => Hash::make('password'),
            'agama' => 'Islam',
            'jenis_kelamin' => 'P',
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('admin');

        // Create Sample Student
        $siswa = User::create([
            'name' => 'Ahmad Siswa',
            'nis' => '2024001',
            'nisn' => '1234567890',
            'kelas_id' => 1, // Assuming first kelas exists
            'email' => 'siswa@smartlib.com',
            'password' => Hash::make('password'),
            'agama' => 'Islam',
            'jenis_kelamin' => 'L',
            'alamat' => 'Jl. Contoh No. 123',
            'no_hp' => '081234567890',
            'nama_ibu' => 'Siti Ibu',
            'nama_ayah' => 'Budi Ayah',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '2010-01-01',
            'email_verified_at' => now(),
        ]);
        $siswa->assignRole('siswa');

        $siswa = User::create([
            'name' => 'anip',
            'nis' => '20240011',
            'nisn' => '12345678901',
            'kelas_id' => 11, // Assuming first kelas exists
            'email' => 'siswa2@smartlib.com',
            'password' => Hash::make('password'),
            'agama' => 'Islam',
            'jenis_kelamin' => 'L',
            'alamat' => 'Jl. Contoh No. 123',
            'no_hp' => '081234567890',
            'nama_ibu' => 'Siti Ibu',
            'nama_ayah' => 'Budi Ayah',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '2010-01-01',
            'email_verified_at' => now(),
        ]);
        $siswa->assignRole('siswa');
    }
}
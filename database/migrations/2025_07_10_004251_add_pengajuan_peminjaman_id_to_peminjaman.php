<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            // Tambah relasi ke pengajuan_peminjaman
            $table->foreignId('pengajuan_peminjaman_id')->nullable()
                  ->constrained('pengajuan_peminjaman')->onDelete('set null')
                  ->after('admin_id');
        });
    }

    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropForeign(['pengajuan_peminjaman_id']);
            $table->dropColumn('pengajuan_peminjaman_id');
        });
    }
};
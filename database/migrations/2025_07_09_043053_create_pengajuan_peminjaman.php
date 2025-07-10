<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuan_peminjaman', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pengajuan')->unique();
            $table->unsignedBigInteger('user_id');
            $table->enum('jenis_peminjaman', ['wajib', 'non_wajib']);
            $table->enum('status', ['pending', 'disetujui', 'ditolak', 'dipinjam'])->default('pending');
            $table->text('catatan_admin')->nullable();
            $table->timestamp('tanggal_pengajuan');
            $table->timestamp('tanggal_diproses')->nullable();
            $table->unsignedBigInteger('diproses_oleh')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('diproses_oleh')->references('id')->on('users')->onDelete('set null');
            
            $table->index(['status', 'tanggal_pengajuan']);
            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_peminjaman');
    }
};
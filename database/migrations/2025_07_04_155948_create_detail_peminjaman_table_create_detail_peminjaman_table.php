<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_peminjaman', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('peminjaman_id');
            $table->unsignedBigInteger('buku_id');
            $table->enum('jenis_buku', ['wajib', 'non_wajib']);
            $table->integer('jumlah')->default(1);
            $table->timestamps();
            
            // Indexes
            $table->index('peminjaman_id', 'idx_peminjaman');
            $table->index(['buku_id', 'jenis_buku'], 'idx_buku');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_peminjaman');
    }
};

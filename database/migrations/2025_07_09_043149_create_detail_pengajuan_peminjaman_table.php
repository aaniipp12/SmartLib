<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_pengajuan_peminjaman', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pengajuan_peminjaman_id');
            $table->unsignedBigInteger('buku_wajib_id')->nullable();
            $table->unsignedBigInteger('buku_non_wajib_id')->nullable();
            $table->integer('jumlah')->default(1);
            $table->timestamps();

            $table->foreign('pengajuan_peminjaman_id', 'fk_detail_pengajuan_peminjaman')
                  ->references('id')->on('pengajuan_peminjaman')->onDelete('cascade');
            $table->foreign('buku_wajib_id')->references('id')->on('buku_wajib')->onDelete('cascade');
            $table->foreign('buku_non_wajib_id')->references('id')->on('buku_non_wajib')->onDelete('cascade');
            
            $table->index('pengajuan_peminjaman_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_pengajuan_peminjaman');
    }
};
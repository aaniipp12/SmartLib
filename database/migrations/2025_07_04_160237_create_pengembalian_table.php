<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengembalian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peminjaman_id')->constrained('peminjaman')->onDelete('cascade');
            $table->date('tanggal_dikembalikan');
            $table->integer('terlambat_hari')->default(0);
            $table->decimal('total_denda', 10, 2)->default(0.00);
            $table->timestamps();
            
            // Indexes
            $table->index('peminjaman_id', 'idx_peminjaman');
            $table->index('tanggal_dikembalikan', 'idx_tanggal_dikembalikan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengembalian');
    }
};

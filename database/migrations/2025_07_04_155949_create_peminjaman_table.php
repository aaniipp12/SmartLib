<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop table if exists to ensure clean state
        Schema::dropIfExists('peminjaman');
        
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('siswa_id');
            $table->unsignedBigInteger('admin_id');
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali');
            $table->enum('status', ['dipinjam', 'dikembalikan', 'terlambat'])->default('dipinjam');
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('siswa_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('cascade');
            
            // Indexes
            $table->index('siswa_id', 'idx_siswa');
            $table->index('admin_id', 'idx_admin');
            $table->index('status', 'idx_status');
            $table->index('tanggal_kembali', 'idx_tanggal_kembali');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
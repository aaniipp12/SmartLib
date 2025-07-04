<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->enum('tingkat', ['7', '8', '9']);
            $table->string('nama_kelas', 10); // 1, 2, 3, dst
            $table->string('tahun_ajaran', 10); // 2024/2025
            $table->timestamps();
            
            // Indexes
            $table->unique(['tingkat', 'nama_kelas', 'tahun_ajaran'], 'unique_kelas');
            $table->index('tingkat', 'idx_tingkat');
            $table->index('tahun_ajaran', 'idx_tahun_ajaran');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};

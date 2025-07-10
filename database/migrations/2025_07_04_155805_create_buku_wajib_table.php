<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buku_wajib', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('mata_pelajaran', 100);
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->string('penerbit', 100)->nullable();
            $table->string('isbn', 20)->nullable()->unique();
            $table->year('tahun_terbit')->nullable();
            $table->integer('stok')->default(0);
            $table->timestamps();
            
            // Indexes
            $table->index('kelas_id', 'idx_kelas');
            $table->index('mata_pelajaran', 'idx_mata_pelajaran');
            $table->index('isbn', 'idx_isbn');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buku_wajib');
    }
};
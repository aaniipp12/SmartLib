<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buku_non_wajib', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->foreignId('kategori_id')->constrained('kategori_buku')->onDelete('cascade');
            $table->string('penulis')->nullable();
            $table->string('penerbit', 100)->nullable();
            $table->string('isbn', 20)->nullable()->unique();
            $table->year('tahun_terbit')->nullable();
            $table->integer('stok')->default(0);
            $table->timestamps();
            
            // Indexes
            $table->index('kategori_id', 'idx_kategori');
            $table->index('isbn', 'idx_isbn');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buku_non_wajib');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('buku_wajib', function (Blueprint $table) {
            // Drop foreign key constraint first
            $table->dropForeign('buku_wajib_kelas_id_foreign');
            
            // Drop the kelas_id column
            $table->dropColumn('kelas_id');
            
            // Add tingkat column
            $table->enum('tingkat', ['7', '8', '9'])->after('mata_pelajaran');
            
            // Add index for tingkat
            $table->index('tingkat', 'idx_tingkat_buku_wajib');
        });
    }

    public function down(): void
    {
        Schema::table('buku_wajib', function (Blueprint $table) {
            // Drop tingkat column
            $table->dropIndex('idx_tingkat_buku_wajib');
            $table->dropColumn('tingkat');
            
            // Add back kelas_id column
            $table->unsignedBigInteger('kelas_id')->after('mata_pelajaran');
            
            // Add back foreign key
            $table->foreign('kelas_id', 'buku_wajib_kelas_id_foreign')
                  ->references('id')->on('kelas')
                  ->onDelete('cascade');
        });
    }
};
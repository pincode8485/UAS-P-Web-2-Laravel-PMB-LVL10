<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pendaftars', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel Users (One-to-One)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Relasi ke tabel Prodis (Many-to-One)
            $table->foreignId('prodi_id')->constrained('prodis');
            
            $table->string('nomor_pendaftaran')->unique(); // e.g., PMB2025001
            $table->string('asal_sekolah');
            $table->string('status_seleksi')->default('pending'); // pending, lolos, tidak_lolos
            $table->float('nilai_ujian')->nullable(); // For Excel Import feature
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftars');
    }
};
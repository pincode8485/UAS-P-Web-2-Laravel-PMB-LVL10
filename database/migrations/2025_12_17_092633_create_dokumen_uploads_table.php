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
        Schema::create('dokumen_uploads', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel Pendaftars
            $table->foreignId('pendaftar_id')->constrained('pendaftars')->onDelete('cascade');
            
            $table->string('jenis_dokumen'); // e.g., 'Ijazah', 'Foto'
            $table->string('path_file');     // Path location in storage
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_uploads');
    }
};
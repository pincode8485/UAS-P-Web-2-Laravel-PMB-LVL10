<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dokumen_uploads', function (Blueprint $table) {
            // Add file_path if it's missing
            if (!Schema::hasColumn('dokumen_uploads', 'file_path')) {
                $table->string('file_path')->after('jenis_dokumen');
            }
            
            // Add nama_dokumen (original filename) if missing
            if (!Schema::hasColumn('dokumen_uploads', 'nama_dokumen')) {
                $table->string('nama_dokumen')->nullable()->after('file_path');
            }
        });
    }

    public function down(): void
    {
        Schema::table('dokumen_uploads', function (Blueprint $table) {
            $table->dropColumn(['file_path', 'nama_dokumen']);
        });
    }
};
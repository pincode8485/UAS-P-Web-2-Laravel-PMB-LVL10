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
    // 1. Update Pendaftars Table (Safe Mode)
    Schema::table('pendaftars', function (Blueprint $table) {
        
        // FIX: Create 'nama', 'alamat', 'telepon' if they are missing
        if (!Schema::hasColumn('pendaftars', 'nama')) {
            $table->string('nama')->after('user_id'); 
        }
        if (!Schema::hasColumn('pendaftars', 'alamat')) {
            $table->text('alamat')->nullable()->after('nama');
        }
        if (!Schema::hasColumn('pendaftars', 'telepon')) {
            $table->string('telepon')->nullable()->after('alamat');
        }

        // Now add the new detailed columns (Check first to avoid duplicates)
        if (!Schema::hasColumn('pendaftars', 'tempat_lahir')) {
            $table->string('tempat_lahir')->nullable()->after('nama');
        }
        if (!Schema::hasColumn('pendaftars', 'tanggal_lahir')) {
            $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
        }
        if (!Schema::hasColumn('pendaftars', 'nama_ayah')) {
            $table->string('nama_ayah')->nullable()->after('telepon');
        }
        if (!Schema::hasColumn('pendaftars', 'nama_ibu')) {
            $table->string('nama_ibu')->nullable()->after('nama_ayah');
        }

        // Remove score column if it exists
        if (Schema::hasColumn('pendaftars', 'nilai_ujian')) {
            $table->dropColumn('nilai_ujian');
        }

        // Add Logic Flags
        if (!Schema::hasColumn('pendaftars', 'step_1_completed')) {
            $table->boolean('step_1_completed')->default(false)->after('status_seleksi');
        }
        if (!Schema::hasColumn('pendaftars', 'step_2_submitted')) {
            $table->boolean('step_2_submitted')->default(false)->after('step_1_completed');
        }
    });

    // 2. Update Dokumens Table (Fixing the error)
    Schema::table('dokumen_uploads', function (Blueprint $table) {
        
        // FIX: Add user_id if it is missing!
        if (!Schema::hasColumn('dokumen_uploads', 'user_id')) {
            $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->onDelete('cascade');
        }

        // Add Document Type
        if (!Schema::hasColumn('dokumen_uploads', 'jenis_dokumen')) {
            $table->string('jenis_dokumen')->nullable()->after('user_id'); 
        }
    });
}
public function down(): void
{
    // Rollback logic (omitted for brevity)
}
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('pendaftars', function (Blueprint $table) {
        // Stores the score (0-100)
        $table->integer('nilai_ujian')->nullable()->after('status_seleksi'); 
    });
}

public function down()
{
    Schema::table('pendaftars', function (Blueprint $table) {
        $table->dropColumn('nilai_ujian');
    });
}
};

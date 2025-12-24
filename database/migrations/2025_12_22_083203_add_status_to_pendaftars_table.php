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
    Schema::table('pendaftars', function (Blueprint $table) {
        // This adds a 'status' column that defaults to 'pending'
        $table->string('status')->default('pending')->after('user_id'); 
    });
}

public function down(): void
{
    Schema::table('pendaftars', function (Blueprint $table) {
        $table->dropColumn('status');
    });
}
};

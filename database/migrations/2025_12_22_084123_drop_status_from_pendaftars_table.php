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
        // Drop the unused column
        $table->dropColumn('status');
    });
}

public function down(): void
{
    Schema::table('pendaftars', function (Blueprint $table) {
        // If we rollback, put it back
        $table->string('status')->nullable()->after('user_id');
    });
}
};

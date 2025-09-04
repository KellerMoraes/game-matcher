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
        Schema::table('users', function (Blueprint $table) {
        $table->string('primary_position')->nullable();
        $table->string('secondary_position')->nullable();
    });
}

/**
 * Reverse the migrations.
*/
public function down(): void
{
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['primary_position', 'secondary_position']);
        //
        });
    }
};

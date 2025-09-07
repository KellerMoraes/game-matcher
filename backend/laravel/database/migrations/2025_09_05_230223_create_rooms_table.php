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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('title',40);
            $table->foreignId('variant_id')->constrained('sport_variants');
            $table->foreignId('place_id')->constrained('places');
            $table->foreignId('creator_id')->constrained('users');
            $table->dateTime('starts_at');
            $table->dateTime('ends_at')->nullable();
            $table->enum('visibility', ['open','closed','hidden']);
            $table->string('notes')->nullable();
            $table->enum('status', ['draft','open', 'finished', 'cancelled']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};

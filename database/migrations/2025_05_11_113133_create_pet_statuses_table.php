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
        Schema::create('pet_statuses', function (Blueprint $table) {
            $table->id();
            $table->integer('hunger')->default(100);
            $table->integer('thirst')->default(100);
            $table->integer('cleanliness')->default(100);
            $table->integer('sleepiness')->default(100);
            $table->foreignId('pet_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pet_statuses');
    }
};

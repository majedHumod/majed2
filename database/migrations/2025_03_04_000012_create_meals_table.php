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
        Schema::create('meals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nutrition_plan_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->enum('meal_type', ['breakfast', 'lunch', 'dinner', 'snack', 'pre_workout', 'post_workout'])->default('breakfast');
            $table->text('description')->nullable();
            $table->text('ingredients')->nullable();
            $table->text('preparation_instructions')->nullable();
            $table->integer('calories')->nullable();
            $table->integer('protein_grams')->nullable();
            $table->integer('carbs_grams')->nullable();
            $table->integer('fat_grams')->nullable();
            $table->string('image_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meals');
    }
};
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
        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('instructions')->nullable();
            $table->string('video_url')->nullable();
            $table->string('image_url')->nullable();
            $table->enum('category', ['strength', 'cardio', 'flexibility', 'balance', 'other'])->default('other');
            $table->enum('equipment', ['none', 'dumbbells', 'barbell', 'kettlebell', 'resistance bands', 'machine', 'other'])->default('none');
            $table->enum('muscle_group', ['chest', 'back', 'shoulders', 'arms', 'legs', 'core', 'full body'])->default('full body');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercises');
    }
};
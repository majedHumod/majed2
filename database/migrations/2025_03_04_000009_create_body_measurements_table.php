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
        Schema::create('body_measurements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subscriber_id')->constrained('users')->onDelete('cascade');
            $table->date('date_recorded');
            $table->decimal('weight', 8, 2)->nullable()->comment('in kg');
            $table->decimal('height', 8, 2)->nullable()->comment('in cm');
            $table->decimal('body_fat_percentage', 5, 2)->nullable();
            $table->decimal('chest', 8, 2)->nullable()->comment('in cm');
            $table->decimal('waist', 8, 2)->nullable()->comment('in cm');
            $table->decimal('hips', 8, 2)->nullable()->comment('in cm');
            $table->decimal('arms', 8, 2)->nullable()->comment('in cm');
            $table->decimal('thighs', 8, 2)->nullable()->comment('in cm');
            $table->decimal('calves', 8, 2)->nullable()->comment('in cm');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('body_measurements');
    }
};
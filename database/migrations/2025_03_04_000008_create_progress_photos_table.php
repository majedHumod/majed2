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
        Schema::create('progress_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subscriber_id')->constrained('users')->onDelete('cascade');
            $table->string('photo_path');
            $table->enum('photo_type', ['front', 'back', 'side', 'other'])->default('front');
            $table->date('date_taken');
            $table->text('notes')->nullable();
            $table->boolean('is_private')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progress_photos');
    }
};
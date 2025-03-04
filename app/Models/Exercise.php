<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exercise extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'instructions',
        'video_url',
        'image_url',
        'category',
        'equipment',
        'muscle_group',
    ];

    /**
     * Get the workouts that include this exercise.
     */
    public function workouts(): BelongsToMany
    {
        return $this->belongsToMany(Workout::class, 'workout_exercises')
            ->withPivot('sets', 'reps', 'duration_seconds', 'rest_between_sets', 'order', 'notes')
            ->withTimestamps();
    }

    /**
     * Get the exercise logs for this exercise.
     */
    public function exerciseLogs(): HasMany
    {
        return $this->hasMany(ExerciseLog::class);
    }
}
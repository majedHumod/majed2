<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Workout extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'workout_plan_id',
        'name',
        'description',
        'day_number',
        'week_number',
        'estimated_duration_minutes',
    ];

    /**
     * Get the workout plan that owns the workout.
     */
    public function workoutPlan(): BelongsTo
    {
        return $this->belongsTo(WorkoutPlan::class);
    }

    /**
     * Get the exercises for the workout.
     */
    public function exercises(): BelongsToMany
    {
        return $this->belongsToMany(Exercise::class, 'workout_exercises')
            ->withPivot('sets', 'reps', 'duration_seconds', 'rest_between_sets', 'order', 'notes')
            ->withTimestamps();
    }

    /**
     * Get the workout logs for this workout.
     */
    public function workoutLogs(): HasMany
    {
        return $this->hasMany(WorkoutLog::class);
    }
}
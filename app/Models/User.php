<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Check if the user is an admin.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if the user is a trainer.
     *
     * @return bool
     */
    public function isTrainer(): bool
    {
        return $this->role === 'trainer';
    }

    /**
     * Check if the user is a subscriber.
     *
     * @return bool
     */
    public function isSubscriber(): bool
    {
        return $this->role === 'subscriber';
    }

    /**
     * Get the workout plans created by the trainer.
     */
    public function createdWorkoutPlans(): HasMany
    {
        return $this->hasMany(WorkoutPlan::class, 'trainer_id');
    }

    /**
     * Get the nutrition plans created by the trainer.
     */
    public function createdNutritionPlans(): HasMany
    {
        return $this->hasMany(NutritionPlan::class, 'trainer_id');
    }

    /**
     * Get the workout plans assigned to the subscriber.
     */
    public function assignedWorkoutPlans(): BelongsToMany
    {
        return $this->belongsToMany(WorkoutPlan::class, 'subscriber_workout_plans', 'subscriber_id', 'workout_plan_id')
            ->withPivot('status', 'start_date', 'end_date', 'notes')
            ->withTimestamps();
    }

    /**
     * Get the nutrition plans assigned to the subscriber.
     */
    public function assignedNutritionPlans(): BelongsToMany
    {
        return $this->belongsToMany(NutritionPlan::class, 'subscriber_nutrition_plans', 'subscriber_id', 'nutrition_plan_id')
            ->withPivot('status', 'start_date', 'end_date', 'notes')
            ->withTimestamps();
    }

    /**
     * Get the workout logs for the subscriber.
     */
    public function workoutLogs(): HasMany
    {
        return $this->hasMany(WorkoutLog::class, 'subscriber_id');
    }

    /**
     * Get the progress photos for the subscriber.
     */
    public function progressPhotos(): HasMany
    {
        return $this->hasMany(ProgressPhoto::class, 'subscriber_id');
    }

    /**
     * Get the body measurements for the subscriber.
     */
    public function bodyMeasurements(): HasMany
    {
        return $this->hasMany(BodyMeasurement::class, 'subscriber_id');
    }

    /**
     * Get the trainers for the subscriber.
     */
    public function trainers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'trainer_subscriber', 'subscriber_id', 'trainer_id')
            ->withPivot('status', 'accepted_at', 'completed_at', 'notes')
            ->withTimestamps();
    }

    /**
     * Get the subscribers for the trainer.
     */
    public function subscribers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'trainer_subscriber', 'trainer_id', 'subscriber_id')
            ->withPivot('status', 'accepted_at', 'completed_at', 'notes')
            ->withTimestamps();
    }

    /**
     * Get the sent messages for the user.
     */
    public function sentMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    /**
     * Get the received messages for the user.
     */
    public function receivedMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'recipient_id');
    }

    /**
     * Get the notifications for the user.
     */
    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }
}
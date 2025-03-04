<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NutritionPlan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'trainer_id',
        'name',
        'description',
        'daily_calories',
        'protein_grams',
        'carbs_grams',
        'fat_grams',
        'meals_per_day',
        'is_public',
    ];

    /**
     * Get the trainer that owns the nutrition plan.
     */
    public function trainer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    /**
     * Get the meals for the nutrition plan.
     */
    public function meals(): HasMany
    {
        return $this->hasMany(Meal::class);
    }

    /**
     * Get the subscribers assigned to this nutrition plan.
     */
    public function subscribers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'subscriber_nutrition_plans', 'nutrition_plan_id', 'subscriber_id')
            ->withPivot('status', 'start_date', 'end_date', 'notes')
            ->withTimestamps();
    }
}
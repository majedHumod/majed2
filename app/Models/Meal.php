<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Meal extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nutrition_plan_id',
        'name',
        'meal_type',
        'description',
        'ingredients',
        'preparation_instructions',
        'calories',
        'protein_grams',
        'carbs_grams',
        'fat_grams',
        'image_url',
    ];

    /**
     * Get the nutrition plan that owns the meal.
     */
    public function nutritionPlan(): BelongsTo
    {
        return $this->belongsTo(NutritionPlan::class);
    }
}
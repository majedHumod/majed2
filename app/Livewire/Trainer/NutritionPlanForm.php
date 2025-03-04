<?php

namespace App\Livewire\Trainer;

use App\Models\NutritionPlan;
use App\Models\Meal;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NutritionPlanForm extends Component
{
    public $nutritionPlanId;
    public $name;
    public $description;
    public $daily_calories;
    public $protein_grams;
    public $carbs_grams;
    public $fat_grams;
    public $meals_per_day = 3;
    public $is_public = false;
    
    public $meals = [];
    
    public $isEditing = false;
    
    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'daily_calories' => 'required|integer|min:500|max:10000',
        'protein_grams' => 'required|integer|min:0',
        'carbs_grams' => 'required|integer|min:0',
        'fat_grams' => 'required|integer|min:0',
        'meals_per_day' => 'required|integer|min:1|max:10',
        'is_public' => 'boolean',
        'meals' => 'array',
        'meals.*.name' => 'required|string|max:255',
        'meals.*.meal_type' => 'required|in:breakfast,lunch,dinner,snack,pre_workout,post_workout',
        'meals.*.description' => 'nullable|string',
        'meals.*.ingredients' => 'nullable|string',
        'meals.*.preparation_instructions' => 'nullable|string',
        'meals.*.calories' => 'required|integer|min:0',
        'meals.*.protein_grams' => 'required|integer|min:0',
        'meals.*.carbs_grams' => 'required|integer|min:0',
        'meals.*.fat_grams' => 'required|integer|min:0',
    ];
    
    public function mount($nutritionPlanId = null)
    {
        if ($nutritionPlanId) {
            $this->nutritionPlanId = $nutritionPlanId;
            $this->isEditing = true;
            
            $nutritionPlan = NutritionPlan::with('meals')->findOrFail($nutritionPlanId);
            
            $this->name = $nutritionPlan->name;
            $this->description = $nutritionPlan->description;
            $this->daily_calories = $nutritionPlan->daily_calories;
            $this->protein_grams = $nutritionPlan->protein_grams;
            $this->carbs_grams = $nutritionPlan->carbs_grams;
            $this->fat_grams = $nutritionPlan->fat_grams;
            $this->meals_per_day = $nutritionPlan->meals_per_day;
            $this->is_public = $nutritionPlan->is_public;
            
            foreach ($nutritionPlan->meals as $meal) {
                $this->meals[] = [
                    'id' => $meal->id,
                    'name' => $meal->name,
                    'meal_type' => $meal->meal_type,
                    'description' => $meal->description,
                    'ingredients' => $meal->ingredients,
                    'preparation_instructions' => $meal->preparation_instructions,
                    'calories' => $meal->calories,
                    'protein_grams' => $meal->protein_grams,
                    'carbs_grams' => $meal->carbs_grams,
                    'fat_grams' => $meal->fat_grams,
                ];
            }
        } else {
            // Initialize with one empty meal for a new plan
            $this->addMeal();
        }
    }
    
    public function addMeal()
    {
        $this->meals[] = [
            'name' => '',
            'meal_type' => 'breakfast',
            'description' => '',
            'ingredients' => '',
            'preparation_instructions' => '',
            'calories' => 0,
            'protein_grams' => 0,
            'carbs_grams' => 0,
            'fat_grams' => 0,
        ];
    }
    
    public function removeMeal($index)
    {
        unset($this->meals[$index]);
        $this->meals = array_values($this->meals);
    }
    
    public function save()
    {
        $this->validate();
        
        if ($this->isEditing) {
            $nutritionPlan = NutritionPlan::findOrFail($this->nutritionPlanId);
        } else {
            $nutritionPlan = new NutritionPlan();
            $nutritionPlan->trainer_id = Auth::id();
        }
        
        $nutritionPlan->name = $this->name;
        $nutritionPlan->description = $this->description;
        $nutritionPlan->daily_calories = $this->daily_calories;
        $nutritionPlan->protein_grams = $this->protein_grams;
        $nutritionPlan->carbs_grams = $this->carbs_grams;
        $nutritionPlan->fat_grams = $this->fat_grams;
        $nutritionPlan->meals_per_day = $this->meals_per_day;
        $nutritionPlan->is_public = $this->is_public;
        $nutritionPlan->save();
        
        // Handle meals
        $existingMealIds = $nutritionPlan->meals()->pluck('id')->toArray();
        $updatedMealIds = [];
        
        foreach ($this->meals as $mealData) {
            if (isset($mealData['id'])) {
                // Update existing meal
                $meal = Meal::findOrFail($mealData['id']);
                $updatedMealIds[] = $meal->id;
            } else {
                // Create new meal
                $meal = new Meal();
                $meal->nutrition_plan_id = $nutritionPlan->id;
            }
            
            $meal->name = $mealData['name'];
            $meal->meal_type = $mealData['meal_type'];
            $meal->description = $mealData['description'];
            $meal->ingredients = $mealData['ingredients'];
            $meal->preparation_instructions = $mealData['preparation_instructions'];
            $meal->calories = $mealData['calories'];
            $meal->protein_grams = $mealData['protein_grams'];
            $meal->carbs_grams = $mealData['carbs_grams'];
            $meal->fat_grams = $mealData['fat_grams'];
            $meal->save();
        }
        
        // Delete meals that were removed
        $mealsToDelete = array_diff($existingMealIds, $updatedMealIds);
        if (!empty($mealsToDelete)) {
            Meal::whereIn('id', $mealsToDelete)->delete();
        }
        
        session()->flash('message', $this->isEditing ? 'Nutrition plan updated successfully.' : 'Nutrition plan created successfully.');
        
        return redirect()->route('trainer.nutrition-plans.show', $nutritionPlan);
    }
    
    public function render()
    {
        return view('livewire.trainer.nutrition-plan-form')
            ->layout('components.layouts.app');
    }
}
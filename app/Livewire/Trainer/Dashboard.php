<?php

namespace App\Livewire\Trainer;

use App\Models\NutritionPlan;
use App\Models\User;
use App\Models\WorkoutPlan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public $subscriberCount = 0;
    public $workoutPlanCount = 0;
    public $nutritionPlanCount = 0;
    public $subscribers = [];
    public $workoutPlans = [];
    public $nutritionPlans = [];

    public function mount()
    {
        $trainer = Auth::user();
        
        // Get counts
        $this->subscriberCount = $trainer->subscribers()->count();
        $this->workoutPlanCount = $trainer->createdWorkoutPlans()->count();
        $this->nutritionPlanCount = $trainer->createdNutritionPlans()->count();
        
        // Get recent subscribers
        $this->subscribers = $trainer->subscribers()
            ->orderBy('trainer_subscriber.created_at', 'desc')
            ->take(5)
            ->get();
        
        // Get recent workout plans
        $this->workoutPlans = $trainer->createdWorkoutPlans()
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
        
        // Get recent nutrition plans
        $this->nutritionPlans = $trainer->createdNutritionPlans()
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
    }

    public function render()
    {
        return view('livewire.trainer.dashboard')
            ->layout('components.layouts.app');
    }
}
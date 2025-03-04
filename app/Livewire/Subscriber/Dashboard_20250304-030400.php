<?php

namespace App\Livewire\Subscriber;

use App\Models\BodyMeasurement;
use App\Models\Meal;
use App\Models\NutritionPlan;
use App\Models\Workout;
use App\Models\WorkoutLog;
use App\Models\WorkoutPlan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public $currentWeight;
    public $bodyFatPercentage;
    public $workoutsCompleted = 0;
    public $streak = 0;
    public $currentWorkoutPlan;
    public $workoutPlanProgress = 0;
    public $todaysWorkout;
    public $currentNutritionPlan;
    public $todaysMeals;
    public $weightData = [];
    public $recentMeasurements;

    public function mount()
    {
        $subscriber = Auth::user();
        
        // Get latest body measurements
        $latestMeasurement = BodyMeasurement::where('subscriber_id', $subscriber->id)
            ->orderBy('date_recorded', 'desc')
            ->first();
        
        if ($latestMeasurement) {
            $this->currentWeight = $latestMeasurement->weight;
            $this->bodyFatPercentage = $latestMeasurement->body_fat_percentage;
            $this->recentMeasurements = $latestMeasurement;
        }
        
        // Get workouts completed count
        $this->workoutsCompleted = WorkoutLog::where('subscriber_id', $subscriber->id)
            ->where('completion_status', 'completed')
            ->count();
        
        // Calculate streak
        $this->calculateStreak($subscriber->id);
        
        // Get current workout plan
        $this->getCurrentWorkoutPlan($subscriber->id);
        
        // Get current nutrition plan
        $this->getCurrentNutritionPlan($subscriber->id);
        
        // Get weight data for chart
        $this->getWeightData($subscriber->id);
    }

    private function calculateStreak($subscriberId)
    {
        $streak = 0;
        $today = Carbon::today();
        $checkDate = $today->copy();
        
        while (true) {
            $hasWorkout = WorkoutLog::where('subscriber_id', $subscriberId)
                ->whereDate('date', $checkDate)
                ->where('completion_status', 'completed')
                ->exists();
            
            if ($hasWorkout) {
                $streak++;
                $checkDate->subDay();
            } else {
                break;
            }
        }
        
        $this->streak = $streak;
    }

    private function getCurrentWorkoutPlan($subscriberId)
    {
        $workoutPlan = WorkoutPlan::whereHas('subscribers', function ($query) use ($subscriberId) {
            $query->where('users.id', $subscriberId)
                ->where('status', 'in_progress');
        })->first();
        
        if ($workoutPlan) {
            $this->currentWorkoutPlan = $workoutPlan;
            
            // Calculate progress
            $totalWorkouts = $workoutPlan->workouts()->count();
            $completedWorkouts = WorkoutLog::where('subscriber_id', $subscriberId)
                ->whereIn('workout_id', $workoutPlan->workouts()->pluck('id'))
                ->where('completion_status', 'completed')
                ->count();
            
            $this->workoutPlanProgress = $totalWorkouts > 0 ? round(($completedWorkouts / $totalWorkouts) * 100) : 0;
            
            // Get today's workout
            $today = Carbon::today();
            $dayOfWeek = $today->dayOfWeek;
            $weekNumber = ceil($today->diffInDays($workoutPlan->subscribers()->where('users.id', $subscriberId)->first()->pivot->start_date) / 7) + 1;
            
            $this->todaysWorkout = $workoutPlan->workouts()
                ->where('day_number', $dayOfWeek)
                ->where('week_number', $weekNumber)
                ->first();
        }
    }

    private function getCurrentNutritionPlan($subscriberId)
    {
        $nutritionPlan = NutritionPlan::whereHas('subscribers', function ($query) use ($subscriberId) {
            $query->where('users.id', $subscriberId)
                ->where('status', 'in_progress');
        })->first();
        
        if ($nutritionPlan) {
            $this->currentNutritionPlan = $nutritionPlan;
            
            // Get today's meals
            $this->todaysMeals = $nutritionPlan->meals()->get();
        }
    }

    private function getWeightData($subscriberId)
    {
        $measurements = BodyMeasurement::where('subscriber_id', $subscriberId)
            ->orderBy('date_recorded')
            ->get();
        
        $this->weightData = $measurements->map(function ($measurement) {
            return [
                'date' => $measurement->date_recorded->format('M d'),
                'weight' => $measurement->weight
            ];
        })->toArray();
    }

    public function render()
    {
        return view('livewire.subscriber.dashboard')
            ->layout('components.layouts.app');
    }
}
<?php

namespace App\Livewire\Trainer;

use App\Models\WorkoutPlan;
use App\Models\Workout;
use App\Models\Exercise;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class WorkoutPlanForm extends Component
{
    public $workoutPlanId;
    public $name;
    public $description;
    public $difficulty = 'beginner';
    public $duration_weeks = 4;
    public $is_public = false;
    
    public $workouts = [];
    public $availableExercises = [];
    
    public $isEditing = false;
    
    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'difficulty' => 'required|in:beginner,intermediate,advanced',
        'duration_weeks' => 'required|integer|min:1|max:52',
        'is_public' => 'boolean',
        'workouts' => 'array',
        'workouts.*.name' => 'required|string|max:255',
        'workouts.*.description' => 'nullable|string',
        'workouts.*.day_number' => 'required|integer|min:0|max:6',
        'workouts.*.week_number' => 'required|integer|min:1',
        'workouts.*.estimated_duration_minutes' => 'required|integer|min:5',
        'workouts.*.exercises' => 'array',
        'workouts.*.exercises.*.exercise_id' => 'required|exists:exercises,id',
        'workouts.*.exercises.*.sets' => 'required|integer|min:1',
        'workouts.*.exercises.*.reps' => 'nullable|integer|min:1',
        'workouts.*.exercises.*.duration_seconds' => 'nullable|integer|min:1',
        'workouts.*.exercises.*.rest_between_sets' => 'nullable|string',
        'workouts.*.exercises.*.order' => 'required|integer|min:0',
    ];
    
    public function mount($workoutPlanId = null)
    {
        $this->availableExercises = Exercise::orderBy('name')->get();
        
        if ($workoutPlanId) {
            $this->workoutPlanId = $workoutPlanId;
            $this->isEditing = true;
            
            $workoutPlan = WorkoutPlan::with(['workouts.exercises'])->findOrFail($workoutPlanId);
            
            $this->name = $workoutPlan->name;
            $this->description = $workoutPlan->description;
            $this->difficulty = $workoutPlan->difficulty;
            $this->duration_weeks = $workoutPlan->duration_weeks;
            $this->is_public = $workoutPlan->is_public;
            
            foreach ($workoutPlan->workouts as $workout) {
                $workoutData = [
                    'id' => $workout->id,
                    'name' => $workout->name,
                    'description' => $workout->description,
                    'day_number' => $workout->day_number,
                    'week_number' => $workout->week_number,
                    'estimated_duration_minutes' => $workout->estimated_duration_minutes,
                    'exercises' => []
                ];
                
                foreach ($workout->exercises as $exercise) {
                    $workoutData['exercises'][] = [
                        'exercise_id' => $exercise->id,
                        'sets' => $exercise->pivot->sets,
                        'reps' => $exercise->pivot->reps,
                        'duration_seconds' => $exercise->pivot->duration_seconds,
                        'rest_between_sets' => $exercise->pivot->rest_between_sets,
                        'order' => $exercise->pivot->order,
                    ];
                }
                
                $this->workouts[] = $workoutData;
            }
        } else {
            // Initialize with one empty workout for a new plan
            $this->addWorkout();
        }
    }
    
    public function addWorkout()
    {
        $this->workouts[] = [
            'name' => '',
            'description' => '',
            'day_number' => 0, // Monday
            'week_number' => 1,
            'estimated_duration_minutes' => 45,
            'exercises' => []
        ];
    }
    
    public function removeWorkout($index)
    {
        unset($this->workouts[$index]);
        $this->workouts = array_values($this->workouts);
    }
    
    public function addExercise($workoutIndex)
    {
        $this->workouts[$workoutIndex]['exercises'][] = [
            'exercise_id' => '',
            'sets' => 3,
            'reps' => 10,
            'duration_seconds' => null,
            'rest_between_sets' => '60 seconds',
            'order' => count($this->workouts[$workoutIndex]['exercises']),
        ];
    }
    
    public function removeExercise($workoutIndex, $exerciseIndex)
    {
        unset($this->workouts[$workoutIndex]['exercises'][$exerciseIndex]);
        $this->workouts[$workoutIndex]['exercises'] = array_values($this->workouts[$workoutIndex]['exercises']);
    }
    
    public function save()
    {
        $this->validate();
        
        if ($this->isEditing) {
            $workoutPlan = WorkoutPlan::findOrFail($this->workoutPlanId);
        } else {
            $workoutPlan = new WorkoutPlan();
            $workoutPlan->trainer_id = Auth::id();
        }
        
        $workoutPlan->name = $this->name;
        $workoutPlan->description = $this->description;
        $workoutPlan->difficulty = $this->difficulty;
        $workoutPlan->duration_weeks = $this->duration_weeks;
        $workoutPlan->is_public = $this->is_public;
        $workoutPlan->save();
        
        // Handle workouts
        $existingWorkoutIds = $workoutPlan->workouts()->pluck('id')->toArray();
        $updatedWorkoutIds = [];
        
        foreach ($this->workouts as $workoutData) {
            if (isset($workoutData['id'])) {
                // Update existing workout
                $workout = Workout::findOrFail($workoutData['id']);
                $updatedWorkoutIds[] = $workout->id;
            } else {
                // Create new workout
                $workout = new Workout();
                $workout->workout_plan_id = $workoutPlan->id;
            }
            
            $workout->name = $workoutData['name'];
            $workout->description = $workoutData['description'];
            $workout->day_number = $workoutData['day_number'];
            $workout->week_number = $workoutData['week_number'];
            $workout->estimated_duration_minutes = $workoutData['estimated_duration_minutes'];
            $workout->save();
            
            // Handle exercises
            $exercisesData = [];
            foreach ($workoutData['exercises'] as $exerciseData) {
                $exercisesData[$exerciseData['exercise_id']] = [
                    'sets' => $exerciseData['sets'],
                    'reps' => $exerciseData['reps'],
                    'duration_seconds' => $exerciseData['duration_seconds'],
                    'rest_between_sets' => $exerciseData['rest_between_sets'],
                    'order' => $exerciseData['order'],
                ];
            }
            
            $workout->exercises()->sync($exercisesData);
        }
        
        // Delete workouts that were removed
        $workoutsToDelete = array_diff($existingWorkoutIds, $updatedWorkoutIds);
        if (!empty($workoutsToDelete)) {
            Workout::whereIn('id', $workoutsToDelete)->delete();
        }
        
        session()->flash('message', $this->isEditing ? 'Workout plan updated successfully.' : 'Workout plan created successfully.');
        
        return redirect()->route('trainer.workout-plans.show', $workoutPlan);
    }
    
    public function render()
    {
        return view('livewire.trainer.workout-plan-form')
            ->layout('components.layouts.app');
    }
}
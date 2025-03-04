<?php

namespace App\Livewire\Subscriber;

use App\Models\Workout;
use App\Models\WorkoutLog;
use App\Models\ExerciseLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class WorkoutLogForm extends Component
{
    public $workoutId;
    public $workout;
    public $date;
    public $start_time;
    public $end_time;
    public $completion_status = 'completed';
    public $perceived_effort = 5;
    public $notes;
    
    public $exerciseLogs = [];
    
    protected $rules = [
        'date' => 'required|date|before_or_equal:today',
        'start_time' => 'required',
        'end_time' => 'required|after:start_time',
        'completion_status' => 'required|in:completed,partial,skipped',
        'perceived_effort' => 'required|integer|min:1|max:10',
        'notes' => 'nullable|string|max:500',
        'exerciseLogs.*.sets_completed' => 'required|integer|min:0',
        'exerciseLogs.*.reps_completed' => 'nullable|integer|min:0',
        'exerciseLogs.*.weight' => 'nullable|numeric|min:0',
        'exerciseLogs.*.duration_seconds' => 'nullable|integer|min:0',
        'exerciseLogs.*.notes' => 'nullable|string|max:255',
    ];
    
    public function mount($workoutId)
    {
        $this->workoutId = $workoutId;
        $this->workout = Workout::with('exercises')->findOrFail($workoutId);
        
        $this->date = date('Y-m-d');
        $this->start_time = date('H:i');
        $this->end_time = date('H:i', strtotime('+' . $this->workout->estimated_duration_minutes . ' minutes'));
        
        // Initialize exercise logs
        foreach ($this->workout->exercises as $exercise) {
            $this->exerciseLogs[] = [
                'exercise_id' => $exercise->id,
                'exercise_name' => $exercise->name,
                'sets_completed' => $exercise->pivot->sets,
                'reps_completed' => $exercise->pivot->reps,
                'weight' => null,
                'duration_seconds' => $exercise->pivot->duration_seconds,
                'notes' => '',
            ];
        }
    }
    
    public function save()
    {
        $this->validate();
        
        // Calculate duration in minutes
        $startTime = Carbon::parse($this->date . ' ' . $this->start_time);
        $endTime = Carbon::parse($this->date . ' ' . $this->end_time);
        $durationMinutes = $endTime->diffInMinutes($startTime);
        
        // Create workout log
        $workoutLog = new WorkoutLog();
        $workoutLog->subscriber_id = Auth::id();
        $workoutLog->workout_id = $this->workoutId;
        $workoutLog->date = $this->date;
        $workoutLog->start_time = $startTime;
        $workoutLog->end_time = $endTime;
        $workoutLog->duration_minutes = $durationMinutes;
        $workoutLog->completion_status = $this->completion_status;
        $workoutLog->perceived_effort = $this->perceived_effort;
        $workoutLog->notes = $this->notes;
        $workoutLog->save();
        
        // Create exercise logs
        foreach ($this->exerciseLogs as $exerciseLogData) {
            $exerciseLog = new ExerciseLog();
            $exerciseLog->workout_log_id = $workoutLog->id;
            $exerciseLog->exercise_id = $exerciseLogData['exercise_id'];
            $exerciseLog->sets_completed = $exerciseLogData['sets_completed'];
            $exerciseLog->reps_completed = $exerciseLogData['reps_completed'];
            $exerciseLog->weight = $exerciseLogData['weight'];
            $exerciseLog->duration_seconds = $exerciseLogData['duration_seconds'];
            $exerciseLog->notes = $exerciseLogData['notes'];
            $exerciseLog->save();
        }
        
        session()->flash('message', 'Workout logged successfully.');
        
        return redirect()->route('subscriber.dashboard');
    }
    
    public function render()
    {
        return view('livewire.subscriber.workout-log-form')
            ->layout('components.layouts.app');
    }
}
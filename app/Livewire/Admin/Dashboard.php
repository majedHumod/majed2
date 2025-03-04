<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\WorkoutPlan;
use App\Models\NutritionPlan;
use Livewire\Component;
use Livewire\WithPagination;

class Dashboard extends Component
{
    use WithPagination;
    
    public $userCount = 0;
    public $trainerCount = 0;
    public $subscriberCount = 0;
    public $workoutPlanCount = 0;
    public $nutritionPlanCount = 0;
    
    public $searchTerm = '';
    public $roleFilter = '';
    
    public function mount()
    {
        $this->userCount = User::count();
        $this->trainerCount = User::where('role', 'trainer')->count();
        $this->subscriberCount = User::where('role', 'subscriber')->count();
        $this->workoutPlanCount = WorkoutPlan::count();
        $this->nutritionPlanCount = NutritionPlan::count();
    }
    
    public function updatingSearchTerm()
    {
        $this->resetPage();
    }
    
    public function updatingRoleFilter()
    {
        $this->resetPage();
    }
    
    public function render()
    {
        $query = User::query();
        
        if ($this->searchTerm) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('email', 'like', '%' . $this->searchTerm . '%');
            });
        }
        
        if ($this->roleFilter) {
            $query->where('role', $this->roleFilter);
        }
        
        $users = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('livewire.admin.dashboard', [
            'users' => $users
        ])->layout('components.layouts.app');
    }
}
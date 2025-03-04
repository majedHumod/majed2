<?php

use App\Livewire\Dashboard;
use App\Livewire\Profile;
use App\Livewire\Welcome;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Admin\UserManagement;
use App\Livewire\Admin\Advertisements;
use App\Livewire\Trainer\Dashboard as TrainerDashboard;
use App\Livewire\Trainer\WorkoutPlanForm;
use App\Livewire\Trainer\NutritionPlanForm;
use App\Livewire\Trainer\Notes;
use App\Livewire\Subscriber\Dashboard as SubscriberDashboard;
use App\Livewire\Subscriber\BodyMeasurementForm;
use App\Livewire\Subscriber\WorkoutLogForm;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', Welcome::class);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/profile', Profile::class)->name('profile');
    
    // Admin routes
    Route::middleware(['auth', 'checkRole:admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', AdminDashboard::class)->name('admin.dashboard');
        Route::get('/users', UserManagement::class)->name('admin.users');
        Route::get('/users/{user}/edit', UserManagement::class)->name('admin.users.edit');
        
        Route::get('/advertisements', Advertisements::class)->name('admin.advertisements');
        
        Route::get('/workout-plans', function() {
            return 'Admin Workout Plans Management';
        })->name('admin.workout-plans');
        
        Route::get('/nutrition-plans', function() {
            return 'Admin Nutrition Plans Management';
        })->name('admin.nutrition-plans');
        
        Route::get('/exercises', function() {
            return 'Admin Exercises Management';
        })->name('admin.exercises');
    });
    
    // Trainer routes
    Route::middleware(['auth', 'checkRole:trainer'])->prefix('trainer')->group(function () {
        Route::get('/dashboard', TrainerDashboard::class)->name('trainer.dashboard');
        
        // Notes management
        Route::get('/notes', Notes::class)->name('trainer.notes');
        
        // Subscriber management
        Route::get('/subscribers/{subscriber}', function() {
            return 'Subscriber Details';
        })->name('trainer.subscribers.show');
        
        Route::get('/clients', function() {
            return 'Trainer Clients Management';
        })->name('trainer.clients');
        
        // Workout plans
        Route::get('/workout-plans/create', WorkoutPlanForm::class)->name('trainer.workout-plans.create');
        Route::get('/workout-plans/{workoutPlan}/edit', WorkoutPlanForm::class)->name('trainer.workout-plans.edit');
        Route::get('/workout-plans/{workoutPlan}', function() {
            return 'Workout Plan Details';
        })->name('trainer.workout-plans.show');
        
        // Nutrition plans
        Route::get('/nutrition-plans/create', NutritionPlanForm::class)->name('trainer.nutrition-plans.create');
        Route::get('/nutrition-plans/{nutritionPlan}/edit', NutritionPlanForm::class)->name('trainer.nutrition-plans.edit');
        Route::get('/nutrition-plans/{nutritionPlan}', function() {
            return 'Nutrition Plan Details';
        })->name('trainer.nutrition-plans.show');
    });
    
    // Subscriber routes
    Route::middleware(['auth', 'checkRole:subscriber'])->prefix('subscriber')->group(function () {
        Route::get('/dashboard', SubscriberDashboard::class)->name('subscriber.dashboard');
        
        // Workouts
        Route::get('/workouts', function() {
            return 'Subscriber Workouts';
        })->name('subscriber.workouts');
        
        Route::get('/workouts/{workout}', function() {
            return 'Workout Details';
        })->name('subscriber.workouts.show');
        
        Route::get('/workouts/{workout}/log', WorkoutLogForm::class)->name('subscriber.workouts.log');
        
        // Workout plans
        Route::get('/workout-plans/browse', function() {
            return 'Browse Workout Plans';
        })->name('subscriber.workout-plans.browse');
        
        Route::get('/workout-plans/{workoutPlan}', function() {
            return 'Workout Plan Details';
        })->name('subscriber.workout-plans.show');
        
        // Nutrition plans
        Route::get('/nutrition-plans/browse', function() {
            return 'Browse Nutrition Plans';
        })->name('subscriber.nutrition-plans.browse');
        
        Route::get('/nutrition-plans/{nutritionPlan}', function() {
            return 'Nutrition Plan Details';
        })->name('subscriber.nutrition-plans.show');
        
        // Progress tracking
        Route::get('/progress', function() {
            return 'Progress Tracking';
        })->name('subscriber.progress');
        
        Route::get('/measurements/create', BodyMeasurementForm::class)->name('subscriber.measurements.create');
        Route::get('/measurements/{measurement}/edit', BodyMeasurementForm::class)->name('subscriber.measurements.edit');
    });
});

require __DIR__.'/auth.php';
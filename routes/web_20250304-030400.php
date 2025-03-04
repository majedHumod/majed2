<?php

use App\Livewire\Dashboard;
use App\Livewire\Profile;
use App\Livewire\Welcome;
use App\Livewire\Trainer\Dashboard as TrainerDashboard;
use App\Livewire\Subscriber\Dashboard as SubscriberDashboard;
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
        // Add admin-specific routes here
        Route::get('/dashboard', function() {
            return 'Admin Dashboard';
        })->name('admin.dashboard');
        
        Route::get('/users', function() {
            return 'Admin Users Management';
        })->name('admin.users');
    });
    
    // Trainer routes
    Route::middleware(['auth', 'checkRole:trainer'])->prefix('trainer')->group(function () {
        Route::get('/dashboard', TrainerDashboard::class)->name('trainer.dashboard');
        
        // Subscriber management
        Route::get('/subscribers/{subscriber}', function() {
            return 'Subscriber Details';
        })->name('trainer.subscribers.show');
        
        Route::get('/clients', function() {
            return 'Trainer Clients Management';
        })->name('trainer.clients');
        
        // Workout plans
        Route::get('/workout-plans/create', function() {
            return 'Create Workout Plan';
        })->name('trainer.workout-plans.create');
        
        Route::get('/workout-plans/{workoutPlan}', function() {
            return 'Workout Plan Details';
        })->name('trainer.workout-plans.show');
        
        // Nutrition plans
        Route::get('/nutrition-plans/create', function() {
            return 'Create Nutrition Plan';
        })->name('trainer.nutrition-plans.create');
        
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
        
        Route::get('/measurements/create', function() {
            return 'Record Measurements';
        })->name('subscriber.measurements.create');
    });
});

require __DIR__.'/auth.php';
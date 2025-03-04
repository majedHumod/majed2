<?php

use App\Livewire\Dashboard;
use App\Livewire\Profile;
use App\Livewire\Welcome;
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

Route::view('/', 'welcome');

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
        // Add trainer-specific routes here
        Route::get('/dashboard', function() {
            return 'Trainer Dashboard';
        })->name('trainer.dashboard');
        
        Route::get('/clients', function() {
            return 'Trainer Clients Management';
        })->name('trainer.clients');
    });
    
    // Subscriber routes
    Route::middleware(['auth', 'checkRole:subscriber'])->prefix('subscriber')->group(function () {
        // Add subscriber-specific routes here
        Route::get('/dashboard', function() {
            return 'Subscriber Dashboard';
        })->name('subscriber.dashboard');
        
        Route::get('/workouts', function() {
            return 'Subscriber Workouts';
        })->name('subscriber.workouts');
    });
});

require __DIR__.'/auth.php';
<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $isEditing ? 'Edit Workout Plan' : 'Create Workout Plan' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session()->has('message'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('message') }}</span>
                </div>
            @endif
            
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form wire:submit.prevent="save">
                        <!-- Workout Plan Details -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium mb-4">Plan Details</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Plan Name</label>
                                    <input wire:model="name" type="text" id="name" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                
                                <div>
                                    <label for="difficulty" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Difficulty</label>
                                    <select wire:model="difficulty" id="difficulty" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                                        <option value="beginner">Beginner</option>
                                        <option value="intermediate">Intermediate</option>
                                        <option value="advanced">Advanced</option>
                                    </select>
                                    @error('difficulty') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                
                                <div>
                                    <label for="duration_weeks" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Duration (weeks)</label>
                                    <input wire:model="duration_weeks" type="number" min="1" max="52" id="duration_weeks" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                                    @error('duration_weeks') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                
                                <div>
                                    <label for="is_public" class="flex items-center">
                                        <input wire:model="is_public" type="checkbox" id="is_public" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Make this plan public</span>
                                    </label>
                                    @error('is_public') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                <textarea wire:model="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm"></textarea>
                                @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        
                        <!-- Workouts -->
                        <div class="mb-8">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-medium">Workouts</h3>
                                <button type="button" wire:click="addWorkout" class="inline-flex items-center px-3 py-1 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    Add Workout
                                </button>
                            </div>
                            
                            @foreach($workouts as $workoutIndex => $workout)
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-4">
                                    <div class="flex justify-between items-center mb-4">
                                        <h4 class="font-medium">Workout {{ $workoutIndex + 1 }}</h4>
                                        <button type="button" wire:click="removeWorkout({{ $workoutIndex }})" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                            Remove
                                        </button>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <label for="workouts.{{ $workoutIndex }}.name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Workout Name</label>
                                            <input wire:model="workouts.{{ $workoutIndex }}.name" type="text" id="workouts.{{ $workoutIndex }}.name" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                                            @error('workouts.'.$workoutIndex.'.name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                        
                                        <div>
                                            <label for="workouts.{{ $workoutIndex }}.estimated_duration_minutes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Duration (minutes)</label>
                                            <input wire:model="workouts.{{ $workoutIndex }}.estimated_duration_minutes" type="number" min="5" id="workouts.{{ $workoutIndex }}.estimated_duration_minutes" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                                            @error('workouts.'.$workoutIndex.'.estimated_duration_minutes') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                        
                                        <div>
                                            <label for="workouts.{{ $workoutIndex }}.day_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Day of Week</label>
                                            <select wire:model="workouts.{{ $workoutIndex }}.day_number" id="workouts.{{ $workoutIndex }}.day_number" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                                                <option value="0">Monday</option>
                                                <option value="1">Tuesday</option>
                                                <option value="2">Wednesday</option>
                                                <option value="3">Thursday</option>
                                                <option value="4">Friday</option>
                                                <option value="5">Saturday</option>
                                                <option value="6">Sunday</option>
                                            </select>
                                            @error('workouts.'.$workoutIndex.'.day_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                        
                                        <div>
                                            <label for="workouts.{{ $workoutIndex }}.week_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Week Number</label>
                                            <input wire:model="workouts.{{ $workoutIndex }}.week_number" type="number" min="1" max="{{ $duration_weeks }}" id="workouts.{{ $workoutIndex }}.week_number" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                                            @error('workouts.'.$workoutIndex.'.week_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="workouts.{{ $workoutIndex }}.description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                        <textarea wire:model="workouts.{{ $workoutIndex }}.description" id="workouts.{{ $workoutIndex }}.description" rows="2" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm"></textarea>
                                        @error('workouts.'.$workoutIndex.'.description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    
                                    <!-- Exercises -->
                                    <div>
                                        <div class="flex justify-between items-center mb-2">
                                            <h5 class="font-medium text-sm">Exercises</h5>
                                            <button type="button" wire:click="addExercise({{ $workoutIndex }})" class="inline-flex items-center px-2 py-1 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                                                Add Exercise
                                            </button>
                                        </div>
                                        
                                        @if(empty($workout['exercises']))
                                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">No exercises added yet.</p>
                                        @else
                                            @foreach($workout['exercises'] as $exerciseIndex => $exercise)
                                                <div class="bg-white dark:bg-gray-800 p-3 rounded-lg mb-2">
                                                    <div class="flex justify-between items-center mb-2">
                                                        <h6 class="font-medium text-sm">Exercise {{ $exerciseIndex + 1 }}</h6>
                                                        <button type="button" wire:click="removeExercise({{ $workoutIndex }}, {{ $exerciseIndex }})" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 text-xs">
                                                            Remove
                                                        </button>
                                                    </div>
                                                    
                                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-2">
                                                        <div>
                                                            <label for="workouts.{{ $workoutIndex }}.exercises.{{ $exerciseIndex }}.exercise_id" class="block text-xs font-medium text-gray-700 dark:text-gray-300">Exercise</label>
                                                            <select wire:model="workouts.{{ $workoutIndex }}.exercises.{{ $exerciseIndex }}.exercise_id" id="workouts.{{ $workoutIndex }}.exercises.{{ $exerciseIndex }}.exercise_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm text-sm">
                                                                <option value="">Select Exercise</option>
                                                                @foreach($availableExercises as $availableExercise)
                                                                    <option value="{{ $availableExercise->id }}">{{ $availableExercise->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('workouts.'.$workoutIndex.'.exercises.'.$exerciseIndex.'.exercise_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                                        </div>
                                                        
                                                        <div>
                                                            <label for="workouts.{{ $workoutIndex }}.exercises.{{ $exerciseIndex }}.sets" class="block text-xs font-medium text-gray-700 dark:text-gray-300">Sets</label>
                                                            <input wire:model="workouts.{{ $workoutIndex }}.exercises.{{ $exerciseIndex }}.sets" type="number" min="1" id="workouts.{{ $workoutIndex }}.exercises.{{ $exerciseIndex }}.sets" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm text-sm">
                                                            @error('workouts.'.$workoutIndex.'.exercises.'.$exerciseIndex.'.sets') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                                        </div>
                                                        
                                                        <div>
                                                            <label for="workouts.{{ $workoutIndex }}.exercises.{{ $exerciseIndex }}.reps" class="block text-xs font-medium text-gray-700 dark:text-gray-300">Reps</label>
                                                            <input wire:model="workouts.{{ $workoutIndex }}.exercises.{{ $exerciseIndex }}.reps" type="number" min="0" id="workouts.{{ $workoutIndex }}.exercises.{{ $exerciseIndex }}.reps" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm text-sm">
                                                            @error('workouts.'.$workoutIndex.'.exercises.'.$exerciseIndex.'.reps') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                                        </div>
                                                        
                                                        <div>
                                                            <label for="workouts.{{ $workoutIndex }}.exercises.{{ $exerciseIndex }}.duration_seconds" class="block text-xs font-medium text-gray-700 dark:text-gray-300">Duration (seconds)</label>
                                                            <input wire:model="workouts.{{ $workoutIndex }}.exercises.{{ $exerciseIndex }}.duration_seconds" type="number" min="0" id="workouts.{{ $workoutIndex }}.exercises.{{ $exerciseIndex }}.duration_seconds" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm text-sm">
                                                            @error('workouts.'.$workoutIndex.'.exercises.'.$exerciseIndex.'.duration_seconds') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                                        </div>
                                                        
                                                        <div>
                                                            <label for="workouts.{{ $workoutIndex }}.exercises.{{ $exerciseIndex }}.rest_between_sets" class="block text-xs font-medium text-gray-700 dark:text-gray-300">Rest Between Sets</label>
                                                            <input wire:model="workouts.{{ $workoutIndex }}.exercises.{{ $exerciseIndex }}.rest_between_sets" type="text" id="workouts.{{ $workoutIndex }}.exercises.{{ $exerciseIndex }}.rest_between_sets" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm text-sm">
                                                            @error('workouts.'.$workoutIndex.'.exercises.'.$exerciseIndex.'.rest_between_sets') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                                        </div>
                                                        
                                                        <div>
                                                            <label for="workouts.{{ $workoutIndex }}.exercises.{{ $exerciseIndex }}.order" class="block text-xs font-medium text-gray-700 dark:text-gray-300">Order</label>
                                                            <input wire:model="workouts.{{ $workoutIndex }}.exercises.{{ $exerciseIndex }}.order" type="number" min="0" id="workouts.{{ $workoutIndex }}.exercises.{{ $exerciseIndex }}.order" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm text-sm">
                                                            @error('workouts.'.$workoutIndex.'.exercises.'.$exerciseIndex.'.order') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ $isEditing ? 'Update Workout Plan' : 'Create Workout Plan' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Log Workout') }}: {{ $workout->name }}
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
                        <div class="mb-6">
                            <h3 class="text-lg font-medium mb-4">Workout Details</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                                <div>
                                    <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date</label>
                                    <input wire:model="date" type="date" id="date" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                                    @error('date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                
                                <div>
                                    <label for="completion_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Completion Status</label>
                                    <select wire:model="completion_status" id="completion_status" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                                        <option value="completed">Completed</option>
                                        <option value="partial">Partially Completed</option>
                                        <option value="skipped">Skipped</option>
                                    </select>
                                    @error('completion_status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                
                                <div>
                                    <label for="start_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start Time</label>
                                    <input wire:model="start_time" type="time" id="start_time" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                                    @error('start_time') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                
                                <div>
                                    <label for="end_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">End Time</label>
                                    <input wire:model="end_time" type="time" id="end_time" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                                    @error('end_time') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label for="perceived_effort" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Perceived Effort (1-10)</label>
                                <input wire:model="perceived_effort" type="range" min="1" max="10" id="perceived_effort" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                                <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400">
                                    <span>Easy (1)</span>
                                    <span>Moderate (5)</span>
                                    <span>Very Hard (10)</span>
                                </div>
                                <div class="text-center mt-1 font-medium">{{ $perceived_effort }}</div>
                                @error('perceived_effort') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Notes</label>
                                <textarea wire:model="notes" id="notes" rows="2" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm"></textarea>
                                @error('notes') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        
                        <div class="mb-6">
                            <h3 class="text-lg font-medium mb-4">Exercise Logs</h3>
                            
                            @foreach($exerciseLogs as $index => $exerciseLog)
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-4">
                                    <h4 class="font-medium mb-3">{{ $exerciseLog['exercise_name'] }}</h4>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-2">
                                        <div>
                                            <label for="exerciseLogs.{{ $index }}.sets_completed" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sets Completed</label>
                                            <input wire:model="exerciseLogs.{{ $index }}.sets_completed" type="number" min="0" id="exerciseLogs.{{ $index }}.sets_completed" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                                            @error('exerciseLogs.'.$index.'.sets_completed') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                        
                                        <div>
                                            <label for="exerciseLogs.{{ $index }}.reps_completed" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Reps Completed</label>
                                            <input wire:model="exerciseLogs.{{ $index }}.reps_completed" type="number" min="0" id="exerciseLogs.{{ $index }}.reps_completed" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                                            @error('exerciseLogs.'.$index.'.reps_completed') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                        
                                        <div>
                                            <label for="exerciseLogs.{{ $index }}.weight" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Weight (kg)</label>
                                            <input wire:model="exerciseLogs.{{ $index }}.weight" type="number" step="0.5" min="0" id="exerciseLogs.{{ $index }}.weight" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                                            @error('exerciseLogs.'.$index.'.weight') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                        
                                        <div>
                                            <label for="exerciseLogs.{{ $index }}.duration_seconds" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Duration (seconds)</label>
                                            <input wire:model="exerciseLogs.{{ $index }}.duration_seconds" type="number" min="0" id="exerciseLogs.{{ $index }}.duration_seconds" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                                            @error('exerciseLogs.'.$index.'.duration_seconds') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <label for="exerciseLogs.{{ $index }}.notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Notes</label>
                                        <textarea wire:model="exerciseLogs.{{ $index }}.notes" id="exerciseLogs.{{ $index }}.notes" rows="1" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm"></textarea>
                                        @error('exerciseLogs.'.$index.'.notes') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="flex justify-end">
                            <a href="{{ route('subscriber.workouts.show', $workout) }}" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-600 active:bg-gray-500 dark:active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 dark:ring-gray-600 disabled:opacity-25 transition ease-in-out duration-150 mr-3">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Log Workout
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
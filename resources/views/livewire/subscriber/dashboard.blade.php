<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Subscriber Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4">Welcome to your Fitness Dashboard!</h3>
                    
                    <!-- Current Stats -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                        <div class="bg-blue-50 dark:bg-blue-900 p-4 rounded-lg">
                            <h4 class="font-semibold text-blue-800 dark:text-blue-200">Current Weight</h4>
                            <p class="text-2xl font-bold">{{ $currentWeight ?? 'Not set' }}</p>
                        </div>
                        <div class="bg-green-50 dark:bg-green-900 p-4 rounded-lg">
                            <h4 class="font-semibold text-green-800 dark:text-green-200">Body Fat %</h4>
                            <p class="text-2xl font-bold">{{ $bodyFatPercentage ?? 'Not set' }}</p>
                        </div>
                        <div class="bg-purple-50 dark:bg-purple-900 p-4 rounded-lg">
                            <h4 class="font-semibold text-purple-800 dark:text-purple-200">Workouts Completed</h4>
                            <p class="text-2xl font-bold">{{ $workoutsCompleted }}</p>
                        </div>
                        <div class="bg-yellow-50 dark:bg-yellow-900 p-4 rounded-lg">
                            <h4 class="font-semibold text-yellow-800 dark:text-yellow-200">Streak</h4>
                            <p class="text-2xl font-bold">{{ $streak }} days</p>
                        </div>
                    </div>
                    
                    <!-- Current Workout Plan -->
                    <div class="mb-8">
                        <h4 class="text-lg font-medium mb-2">Current Workout Plan</h4>
                        @if($currentWorkoutPlan)
                            <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg p-6">
                                <h5 class="font-semibold text-xl mb-2">{{ $currentWorkoutPlan->name }}</h5>
                                <p class="text-gray-600 dark:text-gray-300 mb-4">{{ $currentWorkoutPlan->description }}</p>
                                
                                <div class="flex justify-between items-center mb-4">
                                    <div>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Difficulty: </span>
                                        <span class="text-sm font-medium">{{ ucfirst($currentWorkoutPlan->difficulty) }}</span>
                                    </div>
                                    <div>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Duration: </span>
                                        <span class="text-sm font-medium">{{ $currentWorkoutPlan->duration_weeks }} weeks</span>
                                    </div>
                                    <div>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Progress: </span>
                                        <span class="text-sm font-medium">{{ $workoutPlanProgress }}%</span>
                                    </div>
                                </div>
                                
                                <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-600 mb-4">
                                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $workoutPlanProgress }}%"></div>
                                </div>
                                
                                <h6 class="font-medium text-lg mb-2">Today's Workout</h6>
                                @if($todaysWorkout)
                                    <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg mb-4">
                                        <div class="flex justify-between items-center mb-2">
                                            <h6 class="font-medium">{{ $todaysWorkout->name }}</h6>
                                            <span class="text-sm text-gray-500 dark:text-gray-400">{{ $todaysWorkout->estimated_duration_minutes }} min</span>
                                        </div>
                                        <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">{{ $todaysWorkout->description }}</p>
                                        <a href="{{ route('subscriber.workouts.show', $todaysWorkout) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                            Start Workout
                                        </a>
                                    </div>
                                @else
                                    <p class="text-gray-500 dark:text-gray-400 mb-4">No workout scheduled for today.</p>
                                @endif
                                
                                <a href="{{ route('subscriber.workout-plans.show', $currentWorkoutPlan) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">View Full Plan</a>
                            </div>
                        @else
                            <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg p-6">
                                <p class="text-gray-500 dark:text-gray-400 mb-4">You don't have an active workout plan.</p>
                                <a href="{{ route('subscriber.workout-plans.browse') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    Browse Workout Plans
                                </a>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Current Nutrition Plan -->
                    <div class="mb-8">
                        <h4 class="text-lg font-medium mb-2">Current Nutrition Plan</h4>
                        @if($currentNutritionPlan)
                            <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg p-6">
                                <h5 class="font-semibold text-xl mb-2">{{ $currentNutritionPlan->name }}</h5>
                                <p class="text-gray-600 dark:text-gray-300 mb-4">{{ $currentNutritionPlan->description }}</p>
                                
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                                    <div class="bg-gray-50 dark:bg-gray-800 p-3 rounded-lg text-center">
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Calories</p>
                                        <p class="font-bold">{{ $currentNutritionPlan->daily_calories }}</p>
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-800 p-3 rounded-lg text-center">
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Protein</p>
                                        <p class="font-bold">{{ $currentNutritionPlan->protein_grams }}g</p>
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-800 p-3 rounded-lg text-center">
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Carbs</p>
                                        <p class="font-bold">{{ $currentNutritionPlan->carbs_grams }}g</p>
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-800 p-3 rounded-lg text-center">
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Fat</p>
                                        <p class="font-bold">{{ $currentNutritionPlan->fat_grams }}g</p>
                                    </div>
                                </div>
                                
                                <h6 class="font-medium text-lg mb-2">Today's Meals</h6>
                                @if($todaysMeals && $todaysMeals->count() > 0)
                                    <div class="space-y-3 mb-4">
                                        @foreach($todaysMeals as $meal)
                                            <div class="bg-gray-50 dark:bg-gray-800 p-3 rounded-lg">
                                                <div class="flex justify-between items-center">
                                                    <h6 class="font-medium">{{ $meal->name }}</h6>
                                                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ ucfirst(str_replace('_', ' ', $meal->meal_type)) }}</span>
                                                </div>
                                                <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">{{ Str::limit($meal->description, 100) }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-gray-500 dark:text-gray-400 mb-4">No meals found for today.</p>
                                @endif
                                
                                <a href="{{ route('subscriber.nutrition-plans.show', $currentNutritionPlan) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">View Full Plan</a>
                            </div>
                        @else
                            <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg p-6">
                                <p class="text-gray-500 dark:text-gray-400 mb-4">You don't have an active nutrition plan.</p>
                                <a href="{{ route('subscriber.nutrition-plans.browse') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    Browse Nutrition Plans
                                </a>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Progress Tracking -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <h4 class="text-lg font-medium">Progress Tracking</h4>
                            <a href="{{ route('subscriber.progress') }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">View All</a>
                        </div>
                        <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Weight Progress -->
                                <div>
                                    <h6 class="font-medium mb-2">Weight Progress</h6>
                                    @if($weightData && count($weightData) > 0)
                                        <div class="h-64 bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
                                            <!-- Weight chart would go here -->
                                            <p class="text-center text-gray-500 dark:text-gray-400">Weight chart visualization</p>
                                        </div>
                                    @else
                                        <div class="h-64 bg-gray-50 dark:bg-gray-800 rounded-lg p-4 flex items-center justify-center">
                                            <p class="text-gray-500 dark:text-gray-400">No weight data available yet.</p>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Body Measurements -->
                                <div>
                                    <h6 class="font-medium mb-2">Recent Measurements</h6>
                                    @if($recentMeasurements)
                                        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
                                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Recorded on: {{ $recentMeasurements->date_recorded->format('M d, Y') }}</p>
                                            <div class="grid grid-cols-2 gap-2">
                                                <div>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">Weight</p>
                                                    <p class="font-medium">{{ $recentMeasurements->weight }} kg</p>
                                                </div>
                                                <div>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">Body Fat</p>
                                                    <p class="font-medium">{{ $recentMeasurements->body_fat_percentage }}%</p>
                                                </div>
                                                <div>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">Chest</p>
                                                    <p class="font-medium">{{ $recentMeasurements->chest }} cm</p>
                                                </div>
                                                <div>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">Waist</p>
                                                    <p class="font-medium">{{ $recentMeasurements->waist }} cm</p>
                                                </div>
                                            </div>
                                            <div class="mt-4">
                                                <a href="{{ route('subscriber.measurements.create') }}" class="text-sm text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">Add New Measurement</a>
                                            </div>
                                        </div>
                                    @else
                                        <div class="h-64 bg-gray-50 dark:bg-gray-800 rounded-lg p-4 flex flex-col items-center justify-center">
                                            <p class="text-gray-500 dark:text-gray-400 mb-4">No measurements recorded yet.</p>
                                            <a href="{{ route('subscriber.measurements.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                                Record Measurements
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
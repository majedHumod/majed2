<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Trainer Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4">Welcome to your Trainer Dashboard!</h3>
                    
                    <!-- Stats Overview -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="bg-blue-50 dark:bg-blue-900 p-4 rounded-lg">
                            <h4 class="font-semibold text-blue-800 dark:text-blue-200">Subscribers</h4>
                            <p class="text-2xl font-bold">{{ $subscriberCount }}</p>
                        </div>
                        <div class="bg-green-50 dark:bg-green-900 p-4 rounded-lg">
                            <h4 class="font-semibold text-green-800 dark:text-green-200">Workout Plans</h4>
                            <p class="text-2xl font-bold">{{ $workoutPlanCount }}</p>
                        </div>
                        <div class="bg-purple-50 dark:bg-purple-900 p-4 rounded-lg">
                            <h4 class="font-semibold text-purple-800 dark:text-purple-200">Nutrition Plans</h4>
                            <p class="text-2xl font-bold">{{ $nutritionPlanCount }}</p>
                        </div>
                    </div>
                    
                    <!-- Recent Subscribers -->
                    <div class="mb-8">
                        <h4 class="text-lg font-medium mb-2">Recent Subscribers</h4>
                        @if($subscribers->count() > 0)
                            <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                                    <thead class="bg-gray-50 dark:bg-gray-800">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-700 divide-y divide-gray-200 dark:divide-gray-600">
                                        @foreach($subscribers as $subscriber)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $subscriber->name }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-500 dark:text-gray-300">{{ $subscriber->email }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                                        {{ $subscriber->pivot->status }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                                    <a href="{{ route('trainer.subscribers.show', $subscriber) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">View</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-gray-500 dark:text-gray-400">No subscribers yet.</p>
                        @endif
                    </div>
                    
                    <!-- Recent Workout Plans -->
                    <div class="mb-8">
                        <div class="flex justify-between items-center mb-2">
                            <h4 class="text-lg font-medium">Recent Workout Plans</h4>
                            <a href="{{ route('trainer.workout-plans.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Create New
                            </a>
                        </div>
                        @if($workoutPlans->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($workoutPlans as $plan)
                                    <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg p-4">
                                        <h5 class="font-semibold text-lg mb-2">{{ $plan->name }}</h5>
                                        <p class="text-gray-600 dark:text-gray-300 text-sm mb-2">{{ Str::limit($plan->description, 100) }}</p>
                                        <div class="flex justify-between items-center text-sm text-gray-500 dark:text-gray-400">
                                            <span>{{ $plan->difficulty }}</span>
                                            <span>{{ $plan->duration_weeks }} weeks</span>
                                        </div>
                                        <div class="mt-4">
                                            <a href="{{ route('trainer.workout-plans.show', $plan) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 text-sm">View Details</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 dark:text-gray-400">No workout plans yet.</p>
                        @endif
                    </div>
                    
                    <!-- Recent Nutrition Plans -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <h4 class="text-lg font-medium">Recent Nutrition Plans</h4>
                            <a href="{{ route('trainer.nutrition-plans.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Create New
                            </a>
                        </div>
                        @if($nutritionPlans->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($nutritionPlans as $plan)
                                    <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg p-4">
                                        <h5 class="font-semibold text-lg mb-2">{{ $plan->name }}</h5>
                                        <p class="text-gray-600 dark:text-gray-300 text-sm mb-2">{{ Str::limit($plan->description, 100) }}</p>
                                        <div class="flex justify-between items-center text-sm text-gray-500 dark:text-gray-400">
                                            <span>{{ $plan->daily_calories }} calories</span>
                                            <span>{{ $plan->meals_per_day }} meals/day</span>
                                        </div>
                                        <div class="mt-4">
                                            <a href="{{ route('trainer.nutrition-plans.show', $plan) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 text-sm">View Details</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 dark:text-gray-400">No nutrition plans yet.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4">Welcome to the Admin Dashboard!</h3>
                    
                    <!-- Stats Overview -->
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-6">
                        <div class="bg-blue-50 dark:bg-blue-900 p-4 rounded-lg">
                            <h4 class="font-semibold text-blue-800 dark:text-blue-200">Total Users</h4>
                            <p class="text-2xl font-bold">{{ $userCount }}</p>
                        </div>
                        <div class="bg-green-50 dark:bg-green-900 p-4 rounded-lg">
                            <h4 class="font-semibold text-green-800 dark:text-green-200">Trainers</h4>
                            <p class="text-2xl font-bold">{{ $trainerCount }}</p>
                        </div>
                        <div class="bg-purple-50 dark:bg-purple-900 p-4 rounded-lg">
                            <h4 class="font-semibold text-purple-800 dark:text-purple-200">Subscribers</h4>
                            <p class="text-2xl font-bold">{{ $subscriberCount }}</p>
                        </div>
                        <div class="bg-yellow-50 dark:bg-yellow-900 p-4 rounded-lg">
                            <h4 class=" <h4 class="font-semibold text-yellow-800 dark:text-yellow-200">Workout Plans</h4>
                            <p class="text-2xl font-bold">{{ $workoutPlanCount }}</p>
                        </div>
                        <div class="bg-red-50 dark:bg-red-900 p-4 rounded-lg">
                            <h4 class="font-semibold text-red-800 dark:text-red-200">Nutrition Plans</h4>
                            <p class="text-2xl font-bold">{{ $nutritionPlanCount }}</p>
                        </div>
                    </div>
                    
                    <!-- Quick Actions -->
                    <div class="mb-8">
                        <h4 class="text-lg font-medium mb-4">Quick Actions</h4>
                        <div class="flex flex-wrap gap-4">
                            <a href="{{ route('admin.users') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Manage Users
                            </a>
                            <a href="{{ route('admin.advertisements') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Manage Advertisements
                            </a>
                            <a href="{{ route('admin.workout-plans') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Manage Workout Plans
                            </a>
                            <a href="{{ route('admin.nutrition-plans') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Manage Nutrition Plans
                            </a>
                            <a href="{{ route('admin.exercises') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Manage Exercises
                            </a>
                        </div>
                    </div>
                    
                    <!-- Recent Users -->
                    <div>
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="text-lg font-medium">Recent Users</h4>
                            <div class="flex gap-4">
                                <div>
                                    <input wire:model.debounce.300ms="searchTerm" type="text" placeholder="Search users..." class="rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                                </div>
                                <div>
                                    <select wire:model="roleFilter" class="rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                                        <option value="">All Roles</option>
                                        <option value="admin">Admin</option>
                                        <option value="trainer">Trainer</option>
                                        <option value="subscriber">Subscriber</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                                <thead class="bg-gray-50 dark:bg-gray-800">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Role</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Joined</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-700 divide-y divide-gray-200 dark:divide-gray-600">
                                    @foreach($users as $user)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->name }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-500 dark:text-gray-300">{{ $user->email }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    @if($user->role === 'admin') bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100
                                                    @elseif($user->role === 'trainer') bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100
                                                    @else bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100
                                                    @endif">
                                                    {{ ucfirst($user->role) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-500 dark:text-gray-300">{{ $user->created_at->format('M d, Y') }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                                <a href="{{ route('admin.users.edit', $user) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 mr-3">Edit</a>
                                                <button wire:click="confirmDelete({{ $user->id }})" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Delete</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-4">
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
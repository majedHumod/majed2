<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <h3 class="text-lg font-medium mb-4">Welcome to FitCoachLive!</h3>
                    
                    @if (auth()->user()->isAdmin())
                        <div class="mb-4 p-4 bg-blue-50 dark:bg-blue-900 rounded-lg">
                            <h4 class="font-semibold text-blue-800 dark:text-blue-200">Admin Dashboard</h4>
                            <p class="text-gray-600 dark:text-gray-300 mt-2 mb-4">Manage users, trainers, and platform settings.</p>
                            <div class="mt-2">
                                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    Go to Admin Dashboard
                                </a>
                            </div>
                        </div>
                    @endif

                    @if (auth()->user()->isTrainer())
                        <div class="mb-4 p-4 bg-green-50 dark:bg-green-900 rounded-lg">
                            <h4 class="font-semibold text-green-800 dark:text-green-200">Trainer Dashboard</h4>
                            <p class="text-gray-600 dark:text-gray-300 mt-2 mb-4">Manage your clients, create workout plans, and track progress.</p>
                            <div class="mt-2">
                                <a href="{{ route('trainer.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    Go to Trainer Dashboard
                                </a>
                            </div>
                        </div>
                    @endif

                    @if (auth()->user()->isSubscriber())
                        <div class="mb-4 p-4 bg-purple-50 dark:bg-purple-900 rounded-lg">
                            <h4 class="font-semibold text-purple-800 dark:text-purple-200">Subscriber Dashboard</h4>
                            <p class="text-gray-600 dark:text-gray-300 mt-2 mb-4">View your workout plans, track your progress, and connect with trainers.</p>
                            <div class="mt-2">
                                <a href="{{ route('subscriber.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-800 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    Go to Subscriber Dashboard
                                </a>
                            </div>
                        </div>
                    @endif
                    
                    <div class="mt-6">
                        <h4 class="text-lg font-medium mb-4">Platform Features</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg p-6">
                                <h5 class="font-semibold text-lg mb-2">Workout Plans</h5>
                                <p class="text-gray-600 dark:text-gray-300 mb-4">Access professionally designed workout plans tailored to your fitness level.</p>
                                <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="even odd"></path>
                                    </svg>
                                    <span>Beginner to advanced levels</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mt-1">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Detailed exercise instructions</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mt-1">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Progress tracking</span>
                                </div>
                            </div>
                            
                            <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg p-6">
                                <h5 class="font-semibold text-lg mb-2">Nutrition Plans</h5>
                                <p class="text-gray-600 dark:text-gray-300 mb-4">Get personalized nutrition guidance to support your fitness goals.</p>
                                <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Customized meal plans</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mt-1">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Macro and calorie tracking</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mt-1">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Recipe suggestions</span>
                                </div>
                            </div>
                            
                            <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg p-6">
                                <h5 class="font-semibold text-lg mb-2">Progress Tracking</h5>
                                <p class="text-gray-600 dark:text-gray-300 mb-4">Monitor your fitness journey with comprehensive tracking tools.</p>
                                <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Body measurements</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mt-1">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Progress photos</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mt-1">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Workout history</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
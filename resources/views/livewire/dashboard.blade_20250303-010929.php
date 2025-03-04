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

                    <h3 class="text-lg font-medium mb-4">Welcome to your dashboard!</h3>
                    
                    @if (auth()->user()->isAdmin())
                        <div class="mb-4 p-4 bg-blue-50 rounded-lg">
                            <h4 class="font-semibold text-blue-800">Admin Actions</h4>
                            <div class="mt-2">
                                <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline">Admin Dashboard</a> |
                                <a href="{{ route('admin.users') }}" class="text-blue-600 hover:underline">Manage Users</a>
                            </div>
                        </div>
                    @endif

                    @if (auth()->user()->isTrainer())
                        <div class="mb-4 p-4 bg-green-50 rounded-lg">
                            <h4 class="font-semibold text-green-800">Trainer Actions</h4>
                            <div class="mt-2">
                                <a href="{{ route('trainer.dashboard') }}" class="text-green-600 hover:underline">Trainer Dashboard</a> |
                                <a href="{{ route('trainer.clients') }}" class="text-green-600 hover:underline">Manage Clients</a>
                            </div>
                        </div>
                    @endif

                    @if (auth()->user()->isSubscriber())
                        <div class="mb-4 p-4 bg-purple-50 rounded-lg">
                            <h4 class="font-semibold text-purple-800">Subscriber Actions</h4>
                            <div class="mt-2">
                                <a href="{{ route('subscriber.dashboard') }}" class="text-purple-600 hover:underline">Subscriber Dashboard</a> |
                                <a href="{{ route('subscriber.workouts') }}" class="text-purple-600 hover:underline">My Workouts</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
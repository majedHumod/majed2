<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Profile Information') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __("Update your account's profile information and email address.") }}
                            </p>
                        </header>

                        <div class="mt-6 space-y-6">
                            <div>
                                <p class="text-gray-600 dark:text-gray-400">Name: <span class="font-medium text-gray-900 dark:text-gray-100">{{ auth()->user()->name }}</span></p>
                            </div>

                            <div>
                                <p class="text-gray-600 dark:text-gray-400">Email: <span class="font-medium text-gray-900 dark:text-gray-100">{{ auth()->user()->email }}</span></p>
                            </div>

                            <div>
                                <p class="text-gray-600 dark:text-gray-400">Role: <span class="font-medium text-gray-900 dark:text-gray-100">{{ ucfirst(auth()->user()->role) }}</span></p>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
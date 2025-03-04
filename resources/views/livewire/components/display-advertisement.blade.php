<div>
    @if($advertisement)
        <div class="advertisement-container {{ $position }} mb-4">
            <a href="{{ $advertisement->link_url }}" target="_blank" wire:click="trackClick" class="block">
                <div class="bg-white dark:bg-gray-700 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300">
                    @if($advertisement->image_url)
                        <img src="{{ $advertisement->image_url }}" alt="{{ $advertisement->title }}" class="w-full h-auto object-cover">
                    @endif
                    <div class="p-3">
                        <h4 class="font-medium text-gray-900 dark:text-white">{{ $advertisement->title }}</h4>
                        @if($advertisement->description)
                            <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">{{ Str::limit($advertisement->description, 100) }}</p>
                        @endif
                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-2 text-right">Advertisement</div>
                    </div>
                </div>
            </a>
        </div>
    @endif
</div>
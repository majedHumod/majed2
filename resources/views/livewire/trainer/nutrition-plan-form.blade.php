<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $isEditing ? 'Edit Nutrition Plan' : 'Create Nutrition Plan' }}
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
                        <!-- Nutrition Plan Details -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium mb-4">Plan Details</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Plan Name</label>
                                    <input wire:model="name" type="text" id="name" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                
                                <div>
                                    <label for="meals_per_day" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Meals Per Day</label>
                                    <input wire:model="meals_per_day" type="number" min="1" max="10" id="meals_per_day" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                                    @error('meals_per_day') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                
                                <div>
                                    <label for="daily_calories" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Daily Calories</label>
                                    <input wire:model="daily_calories" type="number" min="500" id="daily_calories" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                                    @error('daily_calories') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                
                                <div>
                                    <label for="is_public" class="flex items-center">
                                        <input wire:model="is_public" type="checkbox" id="is_public" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Make this plan public</span>
                                    </label>
                                    @error('is_public') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">
                                <div>
                                    <label for="protein_grams" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Protein (grams)</label>
                                    <input wire:model="protein_grams" type="number" min="0" id="protein_grams" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                                    @error('protein_grams') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                
                                <div>
                                    <label for="carbs_grams" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Carbs (grams)</label>
                                    <input wire:model="carbs_grams" type="number" min="0" id="carbs_grams" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                                    @error('carbs_grams') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                
                                <div>
                                    <label for="fat_grams" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fat (grams)</label>
                                    <input wire:model="fat_grams" type="number" min="0" id="fat_grams" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                                    @error('fat_grams') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                 <textarea wire:model="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm"></textarea>
                                @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        
                        <!-- Meals -->
                        <div class="mb-8">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-medium">Meals</h3>
                                <button type="button" wire:click="addMeal" class="inline-flex items-center px-3 py-1 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    Add Meal
                                </button>
                            </div>
                            
                            @foreach($meals as $mealIndex => $meal)
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-4">
                                    <div class="flex justify-between items-center mb-4">
                                        <h4 class="font-medium">Meal {{ $mealIndex + 1 }}</h4>
                                        <button type="button" wire:click="removeMeal({{ $mealIndex }})" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                            Remove
                                        </button>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <label for="meals.{{ $mealIndex }}.name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Meal Name</label>
                                            <input wire:model="meals.{{ $mealIndex }}.name" type="text" id="meals.{{ $mealIndex }}.name" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                                            @error('meals.'.$mealIndex.'.name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                        
                                        <div>
                                            <label for="meals.{{ $mealIndex }}.meal_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Meal Type</label>
                                            <select wire:model="meals.{{ $mealIndex }}.meal_type" id="meals.{{ $mealIndex }}.meal_type" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                                                <option value="breakfast">Breakfast</option>
                                                <option value="lunch">Lunch</option>
                                                <option value="dinner">Dinner</option>
                                                <option value="snack">Snack</option>
                                                <option value="pre_workout">Pre-Workout</option>
                                                <option value="post_workout">Post-Workout</option>
                                            </select>
                                            @error('meals.'.$mealIndex.'.meal_type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                                        <div>
                                            <label for="meals.{{ $mealIndex }}.calories" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Calories</label>
                                            <input wire:model="meals.{{ $mealIndex }}.calories" type="number" min="0" id="meals.{{ $mealIndex }}.calories" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                                            @error('meals.'.$mealIndex.'.calories') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                        
                                        <div>
                                            <label for="meals.{{ $mealIndex }}.protein_grams" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Protein (g)</label>
                                            <input wire:model="meals.{{ $mealIndex }}.protein_grams" type="number" min="0" id="meals.{{ $mealIndex }}.protein_grams" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                                            @error('meals.'.$mealIndex.'.protein_grams') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                        
                                        <div>
                                            <label for="meals.{{ $mealIndex }}.carbs_grams" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Carbs (g)</label>
                                            <input wire:model="meals.{{ $mealIndex }}.carbs_grams" type="number" min="0" id="meals.{{ $mealIndex }}.carbs_grams" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                                            @error('meals.'.$mealIndex.'.carbs_grams') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                        
                                        <div>
                                            <label for="meals.{{ $mealIndex }}.fat_grams" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fat (g)</label>
                                            <input wire:model="meals.{{ $mealIndex }}.fat_grams" type="number" min="0" id="meals.{{ $mealIndex }}.fat_grams" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                                            @error('meals.'.$mealIndex.'.fat_grams') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="meals.{{ $mealIndex }}.description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                        <textarea wire:model="meals.{{ $mealIndex }}.description" id="meals.{{ $mealIndex }}.description" rows="2" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm"></textarea>
                                        @error('meals.'.$mealIndex.'.description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="meals.{{ $mealIndex }}.ingredients" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ingredients</label>
                                        <textarea wire:model="meals.{{ $mealIndex }}.ingredients" id="meals.{{ $mealIndex }}.ingredients" rows="3" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm"></textarea>
                                        @error('meals.'.$mealIndex.'.ingredients') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="meals.{{ $mealIndex }}.preparation_instructions" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Preparation Instructions</label>
                                        <textarea wire:model="meals.{{ $mealIndex }}.preparation_instructions" id="meals.{{ $mealIndex }}.preparation_instructions" rows="3" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm"></textarea>
                                        @error('meals.'.$mealIndex.'.preparation_instructions') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ $isEditing ? 'Update Nutrition Plan' : 'Create Nutrition Plan' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
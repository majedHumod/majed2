<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Exercise;
use App\Models\WorkoutPlan;
use App\Models\Workout;
use App\Models\NutritionPlan;
use App\Models\Meal;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create an admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin1@example.com',
            'role' => 'admin',
        ]);

        // Create a trainer user
        $trainer = User::factory()->create([
            'name' => 'Trainer User',
            'email' => 'trainer1@example.com',
            'role' => 'trainer',
        ]);

        // Create a subscriber user
        $subscriber = User::factory()->create([
            'name' => 'Subscriber User',
            'email' => 'subscriber1@example.com',
            'role' => 'subscriber',
        ]);

        // Create additional users
        $trainers = User::factory(3)->trainer()->create();
        $subscribers = User::factory(10)->subscriber()->create();

        // Create exercises
        $exercises = [
            [
                'name' => 'Push-up',
                'description' => 'A classic bodyweight exercise for the upper body',
                'instructions' => 'Start in a plank position with hands shoulder-width apart. Lower your body until your chest nearly touches the floor, then push back up.',
                'category' => 'strength',
                'equipment' => 'none',
                'muscle_group' => 'chest',
            ],
            [
                'name' => 'Squat',
                'description' => 'A fundamental lower body exercise',
                'instructions' => 'Stand with feet shoulder-width apart. Lower your body by bending your knees and pushing your hips back, as if sitting in a chair. Return to standing position.',
                'category' => 'strength',
                'equipment' => 'none',
                'muscle_group' => 'legs',
            ],
            [
                'name' => 'Plank',
                'description' => 'A core strengthening isometric exercise',
                'instructions' => 'Start in a push-up position, but with your weight on your forearms. Keep your body in a straight line from head to heels.',
                'category' => 'strength',
                'equipment' => 'none',
                'muscle_group' => 'core',
            ],
            [
                'name' => 'Dumbbell Bench Press',
                'description' => 'A chest strengthening exercise using dumbbells',
                'instructions' => 'Lie on a bench with a dumbbell in each hand. Press the weights upward until your arms are extended, then lower them back down.',
                'category' => 'strength',
                'equipment' => 'dumbbells',
                'muscle_group' => 'chest',
            ],
            [
                'name' => 'Deadlift',
                'description' => 'A compound exercise that works multiple muscle groups',
                'instructions' => 'Stand with feet hip-width apart, barbell over midfoot. Bend at hips and knees to grip the bar. Lift the bar by extending hips and knees, keeping back straight.',
                'category' => 'strength',
                'equipment' => 'barbell',
                'muscle_group' => 'back',
            ],
        ];

        foreach ($exercises as $exercise) {
            Exercise::create($exercise);
        }

        // Create a workout plan
        $workoutPlan = WorkoutPlan::create([
            'trainer_id' => $trainer->id,
            'name' => 'Beginner Strength Training',
            'description' => 'A 4-week program designed for beginners to build strength and endurance',
            'difficulty' => 'beginner',
            'duration_weeks' => 4,
            'is_public' => true,
        ]);

        // Create workouts for the plan
        $workout1 = Workout::create([
            'workout_plan_id' => $workoutPlan->id,
            'name' => 'Full Body Workout A',
            'description' => 'A full body workout focusing on major muscle groups',
            'day_number' => 1,
            'week_number' => 1,
            'estimated_duration_minutes' => 45,
        ]);

        $workout2 = Workout::create([
            'workout_plan_id' => $workoutPlan->id,
            'name' => 'Full Body Workout B',
            'description' => 'A full body workout with different exercises than Workout A',
            'day_number' => 3,
            'week_number' => 1,
            'estimated_duration_minutes' => 45,
        ]);

        // Add exercises to workouts
        $workout1->exercises()->attach([
            1 => ['sets' => 3, 'reps' => 10, 'rest_between_sets' => '60 seconds', 'order' => 1],
            2 => ['sets' => 3, 'reps' => 12, 'rest_between_sets' => '60 seconds', 'order' => 2],
            3 => ['sets' => 3, 'duration_seconds' => 30, 'rest_between_sets' => '30 seconds', 'order' => 3],
        ]);

        $workout2->exercises()->attach([
            4 => ['sets' => 3, 'reps' => 10, 'rest_between_sets' => '60 seconds', 'order' => 1],
            5 => ['sets' => 3, 'reps' => 8, 'rest_between_sets' => '90 seconds', 'order' => 2],
            3 => ['sets' => 3, 'duration_seconds' => 45, 'rest_between_sets' => '30 seconds', 'order' => 3],
        ]);

        // Assign workout plan to subscriber
        $subscriber->assignedWorkoutPlans()->attach($workoutPlan->id, [
            'status' => 'in_progress',
            'start_date' => now(),
            'end_date' => now()->addWeeks(4),
        ]);

        // Create a nutrition plan
        $nutritionPlan = NutritionPlan::create([
            'trainer_id' => $trainer->id,
            'name' => 'Balanced Nutrition Plan',
            'description' => 'A balanced nutrition plan for general health and fitness',
            'daily_calories' => 2000,
            'protein_grams' => 150,
            'carbs_grams' => 200,
            'fat_grams' => 67,
            'meals_per_day' => 4,
            'is_public' => true,
        ]);

        // Create meals for the nutrition plan
        $meals = [
            [
                'nutrition_plan_id' => $nutritionPlan->id,
                'name' => 'Protein Oatmeal',
                'meal_type' => 'breakfast',
                'description' => 'Oatmeal with protein powder and fruits',
                'ingredients' => "1/2 cup oats\n1 scoop protein powder\n1 banana\n1 tbsp honey\n1 cup almond milk",
                'preparation_instructions' => "1. Cook oats with almond milk\n2. Stir in protein powder\n3. Top with sliced banana and honey",
                'calories' => 350,
                'protein_grams' => 25,
                'carbs_grams' => 45,
                'fat_grams' => 8,
            ],
            [
                'nutrition_plan_id' => $nutritionPlan->id,
                'name' => 'Chicken Salad',
                'meal_type' => 'lunch',
                'description' => 'Grilled chicken breast with mixed greens',
                'ingredients' => "4 oz grilled chicken breast\n2 cups mixed greens\n1/4 cup cherry tomatoes\n1/4 cucumber\n2 tbsp olive oil vinaigrette",
                'preparation_instructions' => "1. Grill chicken breast\n2. Combine all vegetables\n3. Add chicken and dress with vinaigrette",
                'calories' => 400,
                'protein_grams' => 35,
                'carbs_grams' => 10,
                'fat_grams' => 25,
            ],
        ];

        foreach ($meals as $meal) {
            Meal::create($meal);
        }

        // Assign nutrition plan to subscriber
        $subscriber->assignedNutritionPlans()->attach($nutritionPlan->id, [
            'status' => 'in_progress',
            'start_date' => now(),
            'end_date' => now()->addWeeks(4),
        ]);

        // Connect trainer and subscriber
        $trainer->subscribers()->attach($subscriber->id, [
            'status' => 'active',
            'accepted_at' => now(),
        ]);
    }
}
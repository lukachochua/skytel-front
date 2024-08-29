<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\Slider;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call(PlanSeeder::class);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        for ($i = 0; $i < 20; $i++) {
            $imagePath = fake()->image(storage_path('app/public/images'), 640, 480, null, false);

            News::create(
                [
                    'user_id' => 1,
                    'title' => fake()->sentence(),
                    'body' => fake()->paragraph(),
                    'image' => 'images/' . $imagePath,
                ]
            );
        }

        for ($i = 1; $i <= 3; $i++) {
            $sliderImagePath = fake()->image(storage_path('app/public/sliders'), 1920, 1080, null, false);

            Slider::create([
                'title' => "Slider Title $i",
                'description' => fake()->paragraph(),
                'image' => 'sliders/' . $sliderImagePath,
                'order' => $i,
            ]);
        }
    }
}

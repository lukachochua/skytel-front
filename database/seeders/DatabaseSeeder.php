<?php

namespace Database\Seeders;

use App\Models\News;
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

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        for ($i = 0; $i < 10; $i++) {
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
    }
}

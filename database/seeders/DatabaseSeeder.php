<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\Slider;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(PlanSeeder::class);

        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        for ($i = 0; $i < 10; $i++) {
            $imageName = $this->generateImage('images', 640, 480);

            News::create([
                'user_id' => $user->id,
                'title' => fake()->sentence(),
                'body' => fake()->paragraph(),
                'image' => $imageName ? 'images/' . $imageName : null,
            ]);
        }

        for ($i = 1; $i <= 3; $i++) {
            $sliderImageName = $this->generateImage('sliders', 1920, 1080);

            Slider::create([
                'title' => "Slider Title $i",
                'description' => fake()->paragraph(),
                'image' => $sliderImageName ? 'sliders/' . $sliderImageName : null,
                'order' => $i,
            ]);
        }
    }

    private function generateImage(string $path, int $width, int $height): ?string
    {
        try {
            $image = imagecreatetruecolor($width, $height);
            $backgroundColor = imagecolorallocate($image, rand(0, 255), rand(0, 255), rand(0, 255));
            imagefill($image, 0, 0, $backgroundColor);

            $filename = uniqid() . '.jpg';

            $fullPath = public_path("storage/$path");

            if (!file_exists($fullPath)) {
                mkdir($fullPath, 0755, true);
            }

            $filePath = $fullPath . '/' . $filename;
            imagejpeg($image, $filePath);
            imagedestroy($image);

            return $filename;
        } catch (\Exception $e) {
            Log::error('Failed to generate image: ' . $e->getMessage());
            return null;
        }
    }
}

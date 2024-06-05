<?php

namespace Database\Factories;

use App\Models\Slider;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Slider>
 */
class SliderFactory extends Factory
{
    protected $model = Slider::class;

    private $imagePaths = [
        'assets/sliders/01.png',
        'assets/sliders/02.png',
        'assets/sliders/03.png',
        'assets/sliders/4.png',
        'assets/sliders/05.png',
    ];

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {

        $filename = null;

        if ($this->imagePaths) {
            // Get a random image path from the array
            $randomImagePath = Arr::random($this->imagePaths);

            // Generate a unique filename
            $filename = uniqid('image_') . '.png';

            $imagePath = public_path($randomImagePath);
            $newImagePath = storage_path('app/public/banners/' . $filename);

            // Ensure the destination directory exists
            if (!File::exists(dirname($newImagePath))) {
                File::makeDirectory(dirname($newImagePath), 0755, true);
            }

            if (File::exists($imagePath)) {
                File::copy($imagePath, $newImagePath);
            } else {
                $filename = null; // Reset filename if the image copy fails
            }
        }

        return [
            'banner' => $filename ? 'banners/' . $filename : null,
            'type' => $this->faker->unique()->word,
            'description' => $this->faker->sentence,
            'starting_price' => $this->faker->randomFloat(2, 10, 1000),
            'btn_url' => $this->faker->url,
            'serial' => $this->faker->unique()->numberBetween(1, 10),
            'is_visible' => $this->faker->boolean(80), // 80% chance of being true
        ];
    }
}

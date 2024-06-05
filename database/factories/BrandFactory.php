<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class BrandFactory extends Factory
{
    protected $model = Brand::class;

    private $imagePaths = [
        'assets/brands/01.png',
        'assets/brands/02.png',
        'assets/brands/03.png',
        'assets/brands/4.png',
        'assets/brands/05.png',
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
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
            $newImagePath = storage_path('app/public/brands/' . $filename);

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

        $name = $this->faker->company;

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->sentence,
            'brand_color' => $this->faker->hexColor,
            'is_visible' => $this->faker->boolean,
            'is_featured' => $this->faker->boolean,
            'logo' => $filename ? 'brands/' . $filename : null,
        ];
    }
}

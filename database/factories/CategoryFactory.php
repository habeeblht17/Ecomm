<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{

    protected $model = Category::class;

    private $imagePaths = [
        'assets/categories/01.png',
        'assets/categories/02.png',
        'assets/categories/03.png',
        'assets/categories/4.png',
        'assets/categories/05.png',
        'assets/categories/06.png',
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
            $newImagePath = storage_path('app/public/categories/' . $filename);

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

        $name = $this->faker->words(2, true);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->sentence,
            'is_visible' => $this->faker->boolean,
            'image' => $filename ? 'categories/' . $filename : null,
        ];
    }
}

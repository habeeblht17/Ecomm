<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{

    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->words(2, true);

        return [
            'parent_id' => null, // Assuming it can be null. Otherwise, you need to assign a valid parent ID.
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->sentence,
            'is_visible' => $this->faker->boolean,
            'image' => $this->faker->imageUrl(640, 480, 'cats') // Example category
        ];
    }
}

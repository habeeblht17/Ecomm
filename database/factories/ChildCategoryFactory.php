<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ChildCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ChildCategory>
 */
class ChildCategoryFactory extends Factory
{
    protected $model = ChildCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(), // Generates a new category if needed
            'sub_category_id' => SubCategory::factory(), // Generates a new sub-category if needed
            'name' => $this->faker->word,
            'slug' => $this->faker->unique()->slug,
            'is_visible' => $this->faker->boolean,
        ];
    }
}

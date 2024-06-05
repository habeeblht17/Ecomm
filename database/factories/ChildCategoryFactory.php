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
            'category_id' => Category::pluck('id')->random(),
            'sub_category_id' => SubCategory::pluck('id')->random(),
            'name' => $this->faker->word,
            'slug' => $this->faker->unique()->slug,
            'is_visible' => $this->faker->boolean,
        ];
    }
}

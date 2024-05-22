<?php

namespace Database\Factories;

use App\Models\Slider;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Slider>
 */
class SliderFactory extends Factory
{
    protected $model = Slider::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'banner' => $this->faker->imageUrl(),
            'type' => $this->faker->unique()->word,
            'description' => $this->faker->sentence,
            'starting_price' => $this->faker->randomFloat(2, 10, 1000),
            'btn_url' => $this->faker->url,
            'serial' => $this->faker->unique()->numberBetween(1, 100),
            'is_visible' => $this->faker->boolean(50), // 50% chance of being true
        ];
    }
}

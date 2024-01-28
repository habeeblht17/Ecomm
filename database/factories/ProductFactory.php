<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{

    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->words(2, true);

        return [
            'brand_id' => Brand::inRandomOrder()->first() ?: Brand::factory()->create()->id,
            'name' => $name,
            'slug' => Str::slug($name),
            'short_description' => $this->faker->text(100),
            'description' => $this->faker->text(200),
            'price' => $this->faker->numberBetween(10, 100),
            'sku' => strtoupper(Str::random(10)),
            'stock' => $this->faker->randomElement(['instock', 'outofstock']),
            'type' => $this->faker->randomElement(['deliverable', 'downloadable']),
            'quantity' => $this->faker->numberBetween(1, 50),
            'is_visible' => $this->faker->boolean,
            'is_featured' => $this->faker->boolean,
            'image' => $this->faker->imageUrl(640, 480, 'products'),
            'published_at' => Carbon::now()
        ];
    }
}

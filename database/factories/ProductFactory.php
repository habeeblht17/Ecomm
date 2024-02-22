<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{

    protected $model = Product::class;

    private $imagePaths = [
        'assets/products/01.png',
        'assets/products/02.png',
        'assets/products/03.png',
        'assets/products/4.png',
        'assets/products/05.png',
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        if($this->imagePaths){
            // Get a random image path from the array
            $randomImagePath = Arr::random($this->imagePaths);

            // Generate a unique filename
            $filename = uniqid('image_') . '.png';

            $imagePath = public_path($randomImagePath);
            $newImagePath = public_path('storage/products/' . $filename);

            if (File::exists($imagePath)) {
                File::copy($imagePath, $newImagePath);
            }
        }
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
            'image' => $filename,
            'published_at' => Carbon::now()
        ];
    }
}

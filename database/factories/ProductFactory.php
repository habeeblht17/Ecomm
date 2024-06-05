<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\Brand;
use App\Models\Vendor;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Models\ChildCategory;
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
        $filename = null;

        if ($this->imagePaths) {
            // Get a random image path from the array
            $randomImagePath = Arr::random($this->imagePaths);

            // Generate a unique filename
            $filename = uniqid('image_') . '.png';

            $imagePath = public_path($randomImagePath);
            $newImagePath = storage_path('app/public/products/' . $filename);

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
            'brand_id' => Brand::pluck('id')->random(),
            'vendor_id' => Vendor::pluck('id')->random(),
            'category_id' => Category::pluck('id')->random(),
            'sub_category_id' => SubCategory::pluck('id')->random(),
            'child_category_id' => ChildCategory::pluck('id')->random(),
            'name' => $name,
            'slug' => Str::slug($name),
            'short_description' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'sale_price' => $this->faker->optional()->randomFloat(2, 5, 500),
            'sku' => $this->faker->unique()->numerify('SKU-####'),
            'quantity' => $this->faker->numberBetween(0, 100),
            'stock' => $this->faker->randomElement(['instock', 'outofstock']),
            'type' => $this->faker->randomElement(['deliverable', 'downloadable']),
            'offer_price' => $this->faker->optional()->randomFloat(2, 5, 500),
            'offer_start_date' => $this->faker->optional()->date,
            'offer_end_date' => $this->faker->optional()->date,
            'image' => $filename ? 'products/' . $filename : null,
            'published_at' => $this->faker->date,
            'is_visible' => $this->faker->boolean,
            'is_featured' => $this->faker->boolean,
            'is_appproved' => $this->faker->boolean,
            'is_top' => $this->faker->boolean,
            'is_best' => $this->faker->boolean,
            'seo_title' => $this->faker->optional()->sentence,
            'seo_description' => $this->faker->optional()->paragraph,
        ];
    }
}

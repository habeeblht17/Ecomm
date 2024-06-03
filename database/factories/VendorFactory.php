<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vendor>
 */
class VendorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::where('email', 'vendor@gmail.com')->first();

        return [
            'name' => $this->faker->company,
            'banner' => $this->faker->optional()->imageUrl(1200, 300, 'business', true, 'Faker'),
            'logo' => $this->faker->optional()->imageUrl(200, 200, 'business', true, 'Faker'),
            'phone' => $this->faker->optional()->phoneNumber,
            'email' => $this->faker->unique()->safeEmail(),
            'address' => $this->faker->optional()->address,
            'description' => $this->faker->optional()->text(200),
            'user_id' => $user->id, //\App\Models\User::factory(), // Assumes you have a User factory
            'is_approved' => $this->faker->boolean,
            'is_visible' => $this->faker->boolean,
            'insta_link' => $this->faker->optional()->url,
            'fb_link' => $this->faker->optional()->url,
            'tw_link' => $this->faker->optional()->url,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

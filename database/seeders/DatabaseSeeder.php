<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        //
        //Seed user, brand, vendor and category model fisrt
        //before seeding product model.
        //


        \App\Models\User::factory()->create([

            'name' => 'Sypha Sypha',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'role' => 'admin',
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'remember_token' => Str::random(10),
            'profile_photo_path' => null,
            'current_team_id' => null,

        ]);

        \App\Models\User::factory()->create([

            'name' => 'Gaton Gaton',
            'email' => 'vendor@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'role' => 'vendor',
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'remember_token' => Str::random(10),
            'profile_photo_path' => null,
            'current_team_id' => null,

        ]);

        \App\Models\User::factory()->create([
            'name' => 'Dal Dal',
            'email' => 'user@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'role' => 'user',
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'remember_token' => Str::random(10),
            'profile_photo_path' => null,
            'current_team_id' => null,

        ]);


        \App\Models\Brand::factory(5)->create();
        \App\Models\Category::factory(5)->create();
        \App\Models\SubCategory::factory(5)->create();
        \App\Models\ChildCategory::factory(5)->create();
        \App\Models\Slider::factory(5)->create();
        \App\Models\Vendor::factory(1)->create();
        \App\Models\Product::factory(5)->create();
        // \App\Models\User::factory(5)->create();


    }
}

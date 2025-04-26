<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category; // Import the Category model
use App\Models\User; // Import the User model

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminUser = User::where('email', 'admin1@gmail.com')->first();

        $adminUserId = $adminUser ? $adminUser->id : 1;

        $categories = [
            ['name' => 'Laptops', 'description' => 'Portable computers for various tasks.'],
            ['name' => 'Monitors', 'description' => 'Displays for computers.'],
            ['name' => 'Keyboards', 'description' => 'Input devices for typing.'],
            ['name' => 'Mice', 'description' => 'Pointing input devices.'],
            ['name' => 'SSD Storage', 'description' => 'Solid State Drives for fast storage.'],
            ['name' => 'RAM', 'description' => 'Random Access Memory modules.'],
            ['name' => 'Graphics Cards (GPU)', 'description' => 'Components for rendering graphics.'],
            ['name' => 'Peripherals', 'description' => 'Other computer accessories.'],
        ];

        foreach ($categories as $categoryData) {
            Category::updateOrCreate(
                ['name' => $categoryData['name']],
                [
                    'description' => $categoryData['description'],
                    'created_by' => $adminUserId,
                ]
            );
        }
    }
}

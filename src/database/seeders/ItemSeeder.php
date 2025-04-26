<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\User;
use App\Models\Category;
use App\Models\Supplier;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminUser = User::where('email', 'admin@example.com')->first();
        $adminUserId = $adminUser ? $adminUser->id : 1;

        $categories = Category::pluck('id', 'name');
        $suppliers = Supplier::pluck('id', 'name');

        $items = [
            ['name' => 'Dell XPS 13 Laptop', 'description' => '13-inch thin and light laptop.', 'price' => 18500000, 'quantity' => 15, 'category' => 'Laptops', 'supplier' => 'Tech Distributors Inc.'],
            ['name' => 'MacBook Air M2', 'description' => 'Apple laptop with M2 chip.', 'price' => 21000000, 'quantity' => 4, 'category' => 'Laptops', 'supplier' => 'Gadget World'],
            ['name' => 'Dell UltraSharp U2723QE', 'description' => '27-inch 4K IPS Monitor.', 'price' => 8500000, 'quantity' => 25, 'category' => 'Monitors', 'supplier' => 'Tech Distributors Inc.'],
            ['name' => 'LG UltraGear 27GP850', 'description' => '27-inch QHD Gaming Monitor 165Hz.', 'price' => 6200000, 'quantity' => 18, 'category' => 'Monitors', 'supplier' => 'Component Suppliers Ltd.'],
            ['name' => 'Logitech MX Keys', 'description' => 'Wireless illuminated keyboard.', 'price' => 1600000, 'quantity' => 40, 'category' => 'Keyboards', 'supplier' => 'Gadget World'],
            ['name' => 'Keychron K2 (Hot-swappable)', 'description' => '75% layout mechanical keyboard.', 'price' => 1350000, 'quantity' => 30, 'category' => 'Keyboards', 'supplier' => 'Component Suppliers Ltd.'],
            ['name' => 'Logitech MX Master 3S', 'description' => 'Advanced wireless mouse.', 'price' => 1550000, 'quantity' => 50, 'category' => 'Mice', 'supplier' => 'Gadget World'],
            ['name' => 'Razer DeathAdder V2', 'description' => 'Ergonomic wired gaming mouse.', 'price' => 850000, 'quantity' => 35, 'category' => 'Mice', 'supplier' => 'PC Parts Co.'],
            ['name' => 'Samsung 980 Pro 1TB NVMe', 'description' => 'Fast PCIe 4.0 NVMe SSD.', 'price' => 2200000, 'quantity' => 22, 'category' => 'SSD Storage', 'supplier' => 'Component Suppliers Ltd.'],
            ['name' => 'Crucial MX500 2TB SATA', 'description' => 'Reliable 2.5-inch SATA SSD.', 'price' => 2500000, 'quantity' => 12, 'category' => 'SSD Storage', 'supplier' => 'Tech Distributors Inc.'],
            ['name' => 'Corsair Vengeance LPX 16GB DDR4 Kit', 'description' => '2x8GB 3200MHz DDR4 RAM.', 'price' => 950000, 'quantity' => 45, 'category' => 'RAM', 'supplier' => 'PC Parts Co.'],
            ['name' => 'G.Skill Ripjaws V 32GB DDR4 Kit', 'description' => '2x16GB 3600MHz DDR4 RAM.', 'price' => 1800000, 'quantity' => 28, 'category' => 'RAM', 'supplier' => 'Component Suppliers Ltd.'],
            ['name' => 'NVIDIA GeForce RTX 4070', 'description' => 'Mid-high range graphics card.', 'price' => 11500000, 'quantity' => 3, 'category' => 'Graphics Cards (GPU)', 'supplier' => 'PC Parts Co.'],
            ['name' => 'AMD Radeon RX 7800 XT', 'description' => 'Competitive high-end graphics card.', 'price' => 9800000, 'quantity' => 3, 'category' => 'Graphics Cards (GPU)', 'supplier' => 'Component Suppliers Ltd.'],
            ['name' => 'Logitech C920 HD Pro Webcam', 'description' => '1080p webcam for streaming/calls.', 'price' => 900000, 'quantity' => 33, 'category' => 'Peripherals', 'supplier' => 'Gadget World'],
        ];

        foreach ($items as $itemData) {
            if (isset($categories[$itemData['category']]) && isset($suppliers[$itemData['supplier']])) {
                Item::updateOrCreate(
                    ['name' => $itemData['name']],
                    [
                        'description' => $itemData['description'],
                        'price' => $itemData['price'],
                        'quantity' => $itemData['quantity'],
                        'category_id' => $categories[$itemData['category']],
                        'supplier_id' => $suppliers[$itemData['supplier']], 
                        'created_by' => $adminUserId,
                    ]
                );
            } else {
                $this->command->warn("Skipping item '{$itemData['name']}' due to missing category or supplier reference.");
            }
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminUser = User::where('email', 'admin1@gmail.com')->first();
        $adminUserId = $adminUser ? $adminUser->id : 1;

        $suppliers = [
            ['name' => 'Tech Distributors Inc.', 'contact_info' => 'sales@techdistro.com'],
            ['name' => 'Component Suppliers Ltd.', 'contact_info' => 'orders@compsupp.com'],
            ['name' => 'Gadget World', 'contact_info' => 'info@gadgetworld.store'],
            ['name' => 'PC Parts Co.', 'contact_info' => 'support@pcparts.co'],
        ];

        foreach ($suppliers as $supplierData) {
            Supplier::updateOrCreate(
                ['name' => $supplierData['name']],
                [
                    'contact_info' => $supplierData['contact_info'],
                    'created_by' => $adminUserId,
                ]
            );
        }
    }
}

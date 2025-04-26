<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!User::where('email', 'admin1@gmail.com')->exists()) {
            User::create([
                'name' => 'Admin1',
                'email' => 'admin1@gmail.com',
                'password' => Hash::make('12345'),
            ]);
        } else {

            $this->command->info('Admin user already exists.');
        }
    }
}

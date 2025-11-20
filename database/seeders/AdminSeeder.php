<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run(): void
    {
        // Check if admin already exists
        $adminExists = User::where('email', 'admin@example.com')->first();

        if (!$adminExists) {
            User::create([
                'name' => 'Super Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('Admin@123'), // change password
                'role' => 'admin', // make sure your users table has "role" column
            ]);

            $this->command->info("✅ Admin user created successfully!");
        } else {
            $this->command->info("⚠ Admin user already exists!");
        }
    }
}

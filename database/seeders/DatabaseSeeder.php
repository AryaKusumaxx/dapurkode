<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call seeders in the correct order based on dependencies
        $this->call([
            // 1. First create users and roles
            RolePermissionSeeder::class,
            
            // 2. Create all master data
            SettingSeeder::class,
            ProductSeeder::class,
            DiscountSeeder::class,
            
            // 3. Create transactions
            OrderSeeder::class,
            InvoicePaymentSeeder::class,
        ]);
    }
}

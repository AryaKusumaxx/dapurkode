<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // User management
            'users.view.any',
            'users.view.self',
            'users.create',
            'users.update.any',
            'users.update.self',
            'users.delete',
            'users.manage',
            
            // Role management
            'roles.view',
            'roles.create',
            'roles.update',
            'roles.delete',
            'roles.assign',
            
            // Product management
            'products.view',
            'products.create',
            'products.update',
            'products.delete',
            'products.manage',
            
            // Order management
            'orders.view.any',
            'orders.view.self',
            'orders.create',
            'orders.update',
            'orders.delete',
            'orders.review',
            
            // Invoice management
            'invoices.view.any',
            'invoices.view.self',
            'invoices.create',
            'invoices.update',
            'invoices.delete',
            
            // Payment management
            'payments.view.any',
            'payments.view.self',
            'payments.create',
            'payments.upload.self',
            'payments.verify',
            
            // Warranty management
            'warranties.view.any',
            'warranties.view.self',
            'warranties.create',
            'warranties.update',
            'warranties.delete',
            'warranties.extend.self',
            'warranties.manage',
            
            // Discount management
            'discounts.view',
            'discounts.create',
            'discounts.update',
            'discounts.delete',
            'discounts.manage',
            
            // Settings management
            'settings.view',
            'settings.update',
            'settings.manage',
            
            // Reports
            'reports.view',
            
            // Audit logs
            'audit.view',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        
        // Role: superadmin (all permissions)
        $roleSuperAdmin = Role::create(['name' => 'superadmin']);
        $roleSuperAdmin->givePermissionTo(Permission::all());
        
        // Role: admin (operational permissions)
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleAdmin->givePermissionTo([
            'products.view',
            'products.create',
            'products.update',
            'products.delete',
            'products.manage',
            'orders.view.any',
            'orders.review',
            'invoices.view.any',
            'invoices.create',
            'invoices.update',
            'payments.view.any',
            'payments.verify',
            'warranties.view.any',
            'warranties.create',
            'warranties.update',
            'warranties.manage',
            'reports.view',
        ]);
        
        // Role: pelanggan (customer permissions)
        $roleCustomer = Role::create(['name' => 'pelanggan']);
        $roleCustomer->givePermissionTo([
            'users.view.self',
            'users.update.self',
            'products.view',
            'orders.view.self',
            'orders.create',
            'invoices.view.self',
            'payments.view.self',
            'payments.create',
            'payments.upload.self',
            'warranties.view.self',
            'warranties.extend.self',
        ]);

        // Create default users
        
        // Superadmin user
        $superadmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@dapurkode.com',
            'password' => Hash::make('superadmin123'),
            'email_verified_at' => now(),
        ]);
        $superadmin->assignRole('superadmin');
        
        // Admin user
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@dapurkode.com',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('admin');
        
        // Customer user
        $customer = User::create([
            'name' => 'Customer',
            'email' => 'customer@example.com',
            'password' => Hash::make('customer123'),
            'email_verified_at' => now(),
        ]);
        $customer->assignRole('pelanggan');
    }
}

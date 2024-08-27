<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // tasks
        Permission::create(['name' => 'create tasks']);
        Permission::create(['name' => 'edit tasks']);
        Permission::create(['name' => 'delete tasks']);

        // assignments
        Permission::create(['name' => 'turn in assignments']);

        // admin permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(['create tasks', 'edit tasks', 'delete tasks']);

        // user permissions
        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo(['turn in assignments']);

        $admin = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => env("ADMIN_PASSWORD"),
        ]);

        $admin->assignRole($adminRole);
    }
}

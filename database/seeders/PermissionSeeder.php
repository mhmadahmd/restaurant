<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'create-category']);
        Permission::create(['name' => 'create-item']);
        Permission::create(['name' => 'create-discount']);

        // create roles and assign existing permissions
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo('create-category');
        $admin->givePermissionTo('create-item');
        $rest_admin = Role::create(['name' => 'restaurant-admin']);
        $rest_admin->givePermissionTo('create-discount');

        $super = Role::create(['name' => 'super-admin']);

        // create demo users
        $user = \App\Models\User::factory()->create([
            'name' => 'Restaurant Admin',
            'email' => 'restaurantadmin@mail.com',
        ]);
        $user->assignRole($rest_admin);

        $user2 = \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@mail.com',
        ]);
        $user2->assignRole($admin);

        $user3 = \App\Models\User::factory()->create([
            'name' => 'Super-Admin User',
            'email' => 'superadmin@mail.com',
        ]);
        $user3->assignRole($super);

    }
}

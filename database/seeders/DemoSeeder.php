<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            [ 'name' => 'Admin User' ],
            [
                'email' => 'admin@mail.com',
                'password' => Hash::make('password')
            ]
        );

        $user2 = User::firstOrCreate(
            [ 'name' => 'Restaurant Admin' ],
            [
                'email' => 'restaurantadmin@mail.com',
                'password' => Hash::make('password')
            ]
        );

        $user->assignRole('admin');

        Menu::create([
            'name' => $user->name . " Menu",
            'user_id' => $user->id,
            'admin_rest_id' => $user2->id
        ]);
    }
}

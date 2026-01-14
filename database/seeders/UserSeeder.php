<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //admin
        $user = User::create([
            'email' => 'amina@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $user->assignRole(['principal']);

        Profile::create([

            'user_id' => $user->id,
            'name' => 'Amina Akhtar',
            'short_name' => 'Amina',
            'salary' => 25000,
            'seniority' => 1,

        ]);

        $user = User::create([
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $user->assignRole(['admin']);

        Profile::create([

            'user_id' => $user->id,
            'name' => 'Mr Admin',
            'short_name' => 'Admin',
            'salary' => 15000,
            'seniority' => 2,
        ]);

        //    teachers
        $user = User::create([
            'email' => 'akhtar@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $user->assignRole(['teacher']);

        Profile::create([

            'user_id' => $user->id,
            'name' => 'Akhtar Ali',
            'short_name' => 'Akhtar',
            'salary' => 10000,
            'seniority' => 3,
        ]);

        $user = User::create([
            'email' => 'umair@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $user->assignRole(['teacher']);

        Profile::create([

            'user_id' => $user->id,
            'name' => 'Umair Abbas',
            'short_name' => 'umair',
            'seniority' => 4,
        ]);
    }
}

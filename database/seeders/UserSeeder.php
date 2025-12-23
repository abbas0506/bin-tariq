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
            'email' => 'abbas.sscs@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $user->assignRole(['principal']);

        Profile::create([

            'user_id' => $user->id,
            'name' => 'Amina Akhtar',
            'short_name' => 'Amina',
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
            'seniority' => 2,
        ]);
    }
}

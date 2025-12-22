<?php

namespace Database\Seeders;

use App\Models\LibraryRule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibraryRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        LibraryRule::create(['user_type' => 'App\Models\Student', 'max_books' => 4, 'max_days' => 15, 'fine_per_day' => 0]);
        LibraryRule::create(['user_type' => 'App\Models\Teacher', 'max_books' => 2, 'max_days' => 7, 'fine_per_day' => 10]);
    }
}

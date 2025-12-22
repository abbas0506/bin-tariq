<?php

namespace Database\Seeders;

use App\Models\BookReturnPolicy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookReturnPolicySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        BookReturnPolicy::create(['max_days' => 7, 'fine_per_day' => 10]);
    }
}

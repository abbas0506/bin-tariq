<?php

namespace Database\Seeders;

use App\Models\Domain;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DomainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Domain::create(['name' => 'Science']);
        Domain::create(['name' => 'Religion']);
        Domain::create(['name' => 'Literature']);
        Domain::create(['name' => 'Kids Corner']);
        Domain::create(['name' => 'History']);
        Domain::create(['name' => 'Encyclopedia']);
    }
}

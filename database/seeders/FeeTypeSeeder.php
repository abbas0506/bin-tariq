<?php

namespace Database\Seeders;

use App\Models\FeeType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        FeeType::create(['name' => 'Tution Fee', 'amount' => 500]);
        FeeType::create(['name' => 'Admission Fee', 'amount' => 200]);
        FeeType::create(['name' => 'Term Charges', 'amount' => 200]);
        FeeType::create(['name' => 'Sports Fee', 'amount' => 100]);
        FeeType::create(['name' => 'Examination Fee ', 'amount' => 100]);
    }
}

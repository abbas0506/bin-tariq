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
        FeeType::create(['name' => 'Tution Fee']);
        FeeType::create(['name' => 'Admission Fee']);
        FeeType::create(['name' => 'Sports Fee']);
        FeeType::create(['name' => 'Term Charges']);
        FeeType::create(['name' => 'Exam Fee ']);
        FeeType::create(['name' => 'Absence Fine']);
    }
}

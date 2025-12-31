<?php

namespace Database\Seeders;

use App\Models\FeeStructure;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeeStructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // tution fee, admission fee, 
        // term charges, sports fee, 
        // examination fee, fine

        FeeStructure::create(['level' => 0, 'fee_type_id' => 1, 'amount' => 500]);
        FeeStructure::create(['level' => 0, 'fee_type_id' => 2, 'amount' => 200]);
        FeeStructure::create(['level' => 0, 'fee_type_id' => 3, 'amount' => 100]);
        FeeStructure::create(['level' => 0, 'fee_type_id' => 4, 'amount' => 100]);
        FeeStructure::create(['level' => 0, 'fee_type_id' => 5, 'amount' => 100]);
        FeeStructure::create(['level' => 0, 'fee_type_id' => 6, 'amount' => 100]);

        FeeStructure::create(['level' => 1, 'fee_type_id' => 1, 'amount' => 500]);
        FeeStructure::create(['level' => 1, 'fee_type_id' => 2, 'amount' => 200]);
        FeeStructure::create(['level' => 1, 'fee_type_id' => 3, 'amount' => 100]);
        FeeStructure::create(['level' => 1, 'fee_type_id' => 4, 'amount' => 100]);
        FeeStructure::create(['level' => 1, 'fee_type_id' => 5, 'amount' => 100]);
        FeeStructure::create(['level' => 1, 'fee_type_id' => 6, 'amount' => 100]);

        FeeStructure::create(['level' => 2, 'fee_type_id' => 1, 'amount' => 500]);
        FeeStructure::create(['level' => 2, 'fee_type_id' => 2, 'amount' => 200]);
        FeeStructure::create(['level' => 2, 'fee_type_id' => 3, 'amount' => 100]);
        FeeStructure::create(['level' => 2, 'fee_type_id' => 4, 'amount' => 100]);
        FeeStructure::create(['level' => 2, 'fee_type_id' => 5, 'amount' => 100]);
        FeeStructure::create(['level' => 2, 'fee_type_id' => 6, 'amount' => 100]);

        FeeStructure::create(['level' => 3, 'fee_type_id' => 1, 'amount' => 500]);
        FeeStructure::create(['level' => 3, 'fee_type_id' => 2, 'amount' => 200]);
        FeeStructure::create(['level' => 3, 'fee_type_id' => 3, 'amount' => 100]);
        FeeStructure::create(['level' => 3, 'fee_type_id' => 4, 'amount' => 100]);
        FeeStructure::create(['level' => 3, 'fee_type_id' => 5, 'amount' => 100]);
        FeeStructure::create(['level' => 3, 'fee_type_id' => 6, 'amount' => 100]);

        FeeStructure::create(['level' => 4, 'fee_type_id' => 1, 'amount' => 500]);
        FeeStructure::create(['level' => 4, 'fee_type_id' => 2, 'amount' => 200]);
        FeeStructure::create(['level' => 4, 'fee_type_id' => 3, 'amount' => 100]);
        FeeStructure::create(['level' => 4, 'fee_type_id' => 4, 'amount' => 100]);
        FeeStructure::create(['level' => 4, 'fee_type_id' => 5, 'amount' => 100]);
        FeeStructure::create(['level' => 4, 'fee_type_id' => 6, 'amount' => 100]);

        FeeStructure::create(['level' => 5, 'fee_type_id' => 1, 'amount' => 500]);
        FeeStructure::create(['level' => 5, 'fee_type_id' => 2, 'amount' => 200]);
        FeeStructure::create(['level' => 5, 'fee_type_id' => 3, 'amount' => 100]);
        FeeStructure::create(['level' => 5, 'fee_type_id' => 4, 'amount' => 100]);
        FeeStructure::create(['level' => 5, 'fee_type_id' => 5, 'amount' => 100]);
        FeeStructure::create(['level' => 5, 'fee_type_id' => 6, 'amount' => 100]);

        FeeStructure::create(['level' => 6, 'fee_type_id' => 1, 'amount' => 500]);
        FeeStructure::create(['level' => 6, 'fee_type_id' => 2, 'amount' => 200]);
        FeeStructure::create(['level' => 6, 'fee_type_id' => 3, 'amount' => 100]);
        FeeStructure::create(['level' => 6, 'fee_type_id' => 4, 'amount' => 100]);
        FeeStructure::create(['level' => 6, 'fee_type_id' => 5, 'amount' => 100]);
        FeeStructure::create(['level' => 6, 'fee_type_id' => 6, 'amount' => 100]);

        FeeStructure::create(['level' => 7, 'fee_type_id' => 1, 'amount' => 500]);
        FeeStructure::create(['level' => 7, 'fee_type_id' => 2, 'amount' => 200]);
        FeeStructure::create(['level' => 7, 'fee_type_id' => 3, 'amount' => 100]);
        FeeStructure::create(['level' => 7, 'fee_type_id' => 4, 'amount' => 100]);
        FeeStructure::create(['level' => 7, 'fee_type_id' => 5, 'amount' => 100]);
        FeeStructure::create(['level' => 7, 'fee_type_id' => 6, 'amount' => 100]);

        FeeStructure::create(['level' => 8, 'fee_type_id' => 1, 'amount' => 500]);
        FeeStructure::create(['level' => 8, 'fee_type_id' => 2, 'amount' => 200]);
        FeeStructure::create(['level' => 8, 'fee_type_id' => 3, 'amount' => 100]);
        FeeStructure::create(['level' => 8, 'fee_type_id' => 4, 'amount' => 100]);
        FeeStructure::create(['level' => 8, 'fee_type_id' => 5, 'amount' => 100]);
        FeeStructure::create(['level' => 8, 'fee_type_id' => 6, 'amount' => 100]);

        FeeStructure::create(['level' => 9, 'fee_type_id' => 1, 'amount' => 500]);
        FeeStructure::create(['level' => 9, 'fee_type_id' => 2, 'amount' => 200]);
        FeeStructure::create(['level' => 9, 'fee_type_id' => 3, 'amount' => 100]);
        FeeStructure::create(['level' => 9, 'fee_type_id' => 4, 'amount' => 100]);
        FeeStructure::create(['level' => 9, 'fee_type_id' => 5, 'amount' => 100]);
        FeeStructure::create(['level' => 9, 'fee_type_id' => 6, 'amount' => 100]);

        FeeStructure::create(['level' => 10, 'fee_type_id' => 1, 'amount' => 500]);
        FeeStructure::create(['level' => 10, 'fee_type_id' => 2, 'amount' => 200]);
        FeeStructure::create(['level' => 10, 'fee_type_id' => 3, 'amount' => 100]);
        FeeStructure::create(['level' => 10, 'fee_type_id' => 4, 'amount' => 100]);
        FeeStructure::create(['level' => 10, 'fee_type_id' => 5, 'amount' => 100]);
        FeeStructure::create(['level' => 10, 'fee_type_id' => 6, 'amount' => 100]);
    }
}

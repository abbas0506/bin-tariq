<?php

namespace Database\Seeders;

use App\Models\Grade;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Grade::create(['grade_no' => 0, 'name' => 'Nursery']);
        Grade::create(['grade_no' => 1, 'name' => 'One']);
        Grade::create(['grade_no' => 2, 'name' => 'Two']);
        Grade::create(['grade_no' => 3, 'name' => 'Three']);
        Grade::create(['grade_no' => 4, 'name' => 'Four']);
        Grade::create(['grade_no' => 5, 'name' => 'Five']);
        Grade::create(['grade_no' => 6, 'name' => 'Six']);
        Grade::create(['grade_no' => 7, 'name' => 'Seven']);
        Grade::create(['grade_no' => 8, 'name' => 'Eight']);
        Grade::create(['grade_no' => 9, 'name' => 'Nine']);
        Grade::create(['grade_no' => 10, 'name' => 'Ten']);
    }
}

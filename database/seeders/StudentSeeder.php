<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1
        $student1 = Student::create([
            'name' => 'Akhtar',
            'father_name' => 'Khawar',
            'section_id' => 1,
            'rollno' => 1,
        ]);
        $student1->fees()->create(['fee_type_id' => 1, 'amount' => 500]);
        $student1->fees()->create(['fee_type_id' => 2, 'amount' => 150]);
        $student1->fees()->create(['fee_type_id' => 3, 'amount' => 100]);

        // 2
        $student2 = Student::create([
            'name' => 'Nazim',
            'father_name' => 'Akram',
            'section_id' => 1,
            'rollno' => 2,
        ]);

        $student2->fees()->create(['fee_type_id' => 1, 'amount' => 450]);
        $student2->fees()->create(['fee_type_id' => 2, 'amount' => 200]);
        $student2->fees()->create(['fee_type_id' => 3, 'amount' => 100]);

        // 3
        $student3 = Student::create([
            'name' => 'Khursheed',
            'father_name' => 'Ahmad',
            'section_id' => 1,
            'rollno' => 3,
        ]);
        $student3->fees()->create(['fee_type_id' => 1, 'amount' => 500]);
        $student3->fees()->create(['fee_type_id' => 2, 'amount' => 200]);
        $student3->fees()->create(['fee_type_id' => 3, 'amount' => 100]);

        // 4
        $student4 = Student::create([
            'name' => 'Majeed Akbar',
            'father_name' => 'Akbar Ali',
            'section_id' => 2,
            'rollno' => 1,
        ]);
        $student4->fees()->create(['fee_type_id' => 1, 'amount' => 400]);
        $student4->fees()->create(['fee_type_id' => 2, 'amount' => 200]);
        $student4->fees()->create(['fee_type_id' => 3, 'amount' => 100]);

        // 5
        $student5 = Student::create([
            'name' => 'Umair Abbas',
            'father_name' => 'Muhammad Abbas',
            'section_id' => 2,
            'rollno' => 2,
        ]);
        $student5->fees()->create(['fee_type_id' => 1, 'amount' => 300]);
        $student5->fees()->create(['fee_type_id' => 2, 'amount' => 100]);
        $student5->fees()->create(['fee_type_id' => 3, 'amount' => 100]);
    }
}

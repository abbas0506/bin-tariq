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
        $student = Student::create([
            'name' => 'Akhtar',
            'father_name' => 'Khawar',
            'section_id' => 1,
            'rollno' => 1,
        ]);

        // 2
        $student = Student::create([
            'name' => 'Nazim',
            'father_name' => 'Akram',
            'section_id' => 1,
            'rollno' => 2,
        ]);

        // 3
        $student = Student::create([
            'name' => 'Khursheed',
            'father_name' => 'Ahmad',
            'section_id' => 1,
            'rollno' => 3,
        ]);

        // 4
        $student = Student::create([
            'name' => 'Majeed Akbar',
            'father_name' => 'Akbar Ali',
            'section_id' => 2,
            'rollno' => 1,
        ]);
        // 5
        $student = Student::create([
            'name' => 'Umair Abbas',
            'father_name' => 'Muhammad Abbas',
            'section_id' => 2,
            'rollno' => 2,
        ]);
    }
}

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
        //
        Student::create([
            'name' => 'Akhtar',
            'father_name' => 'Khawar',
            'section_id' => 1,
            'rollno' => 1,
        ]);
        Student::create([
            'name' => 'Nazim',
            'father_name' => 'Akram',
            'section_id' => 1,
            'rollno' => 2,
        ]);
        Student::create([
            'name' => 'Khursheed',
            'father_name' => 'Ahmad',
            'section_id' => 1,
            'rollno' => 3,
        ]);
        Student::create([
            'name' => 'Majeed Akbar',
            'father_name' => 'Akbar Ali',
            'section_id' => 2,
            'rollno' => 1,
        ]);
        Student::create([
            'name' => 'Umair Abbas',
            'father_name' => 'Muhammad Abbas',
            'section_id' => 2,
            'rollno' => 2,
        ]);
    }
}

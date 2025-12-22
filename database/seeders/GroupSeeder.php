<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Group::create(['name' => 'Biology', 'subjects_list' => 'Phy, Bio, Chem']);
        Group::create(['name' => 'Computer Sc.', 'subjects_list' => 'Phy, Chem, Computer Sc']);
        Group::create(['name' => 'ICT, Tech', 'subjects_list' => 'Phy, Computer Sc, Entp']);
        Group::create(['name' => 'Arts', 'subjects_list' => 'Punjabi, Islamic St, Gen. Sc']);
        Group::create(['name' => 'General', 'subjects_list' => 'Agri, History, Geography']);
    }
}

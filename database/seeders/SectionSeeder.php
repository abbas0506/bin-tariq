<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Section::create(['level' => 0, 'name' => 'Play Group']);
        Section::create(['level' => 1, 'name' => 'Nursery']);
        Section::create(['level' => 2, 'name' => 'Prep']);
        Section::create(['level' => 3, 'name' => 'One']);
        Section::create(['level' => 4, 'name' => 'Two']);
        Section::create(['level' => 5, 'name' => 'Three']);
        Section::create(['level' => 6, 'name' => 'Four']);
        Section::create(['level' => 7, 'name' => 'Five']);
        Section::create(['level' => 8, 'name' => 'Six']);
        Section::create(['level' => 9, 'name' => 'Seven']);
        Section::create(['level' => 10, 'name' => 'Eight']);
    }
}

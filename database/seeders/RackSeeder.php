<?php

namespace Database\Seeders;

use App\Models\Rack;
use Illuminate\Database\Seeder;

class RackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Rack::create(['label' => 'A1']);
        Rack::create(['label' => 'A2']);
        Rack::create(['label' => 'A3']);
        Rack::create(['label' => 'A4']);

        Rack::create(['label' => 'B1']);
        Rack::create(['label' => 'B2']);
        Rack::create(['label' => 'B3']);
        Rack::create(['label' => 'B4']);

        Rack::create(['label' => 'C1']);
        Rack::create(['label' => 'C2']);
        Rack::create(['label' => 'C3']);
        Rack::create(['label' => 'C4']);

        Rack::create(['label' => 'D1']);
        Rack::create(['label' => 'D2']);
        Rack::create(['label' => 'D3']);
        Rack::create(['label' => 'D4']);
    }
}

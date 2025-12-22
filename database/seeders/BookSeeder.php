<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Book::create([
            'title' => 'The Sufism',
            'author' => 'Ishfaq Ahmad',
            'publish_year' => 2022,
            'num_of_copies' => 2,
            'price' => 400,
            'language_id' => 1,
            'domain_id' => 2,
            'rack_id' => 1,
        ]);
        Book::create([
            'title' => 'The Great Allah',
            'author' => 'Ishfaq Ahmad',
            'publish_year' => 2022,
            'num_of_copies' => 2,
            'price' => 400,
            'language_id' => 1,
            'domain_id' => 2,
            'rack_id' => 1,
        ]);
        Book::create([
            'title' => 'The Criticism',
            'author' => 'Mr Bilal',
            'publish_year' => 2022,
            'num_of_copies' => 2,
            'price' => 400,
            'language_id' => 1,
            'domain_id' => 2,
            'rack_id' => 1,
        ]);
        Book::create([
            'title' => 'The Great Muhammad PBUH',
            'author' => 'Ishfaq Ahmad',
            'publish_year' => 2022,
            'num_of_copies' => 2,
            'price' => 400,
            'language_id' => 1,
            'domain_id' => 2,
            'rack_id' => 1,
        ]);
        Book::create([
            'title' => 'The Ocean',
            'author' => 'Ishfaq Ahmad',
            'publish_year' => 2022,
            'num_of_copies' => 2,
            'price' => 400,
            'language_id' => 1,
            'domain_id' => 2,
            'rack_id' => 1,
        ]);
        Book::create([
            'title' => 'Miracles of air',
            'author' => 'Ishfaq Ahmad',
            'publish_year' => 2022,
            'num_of_copies' => 2,
            'price' => 400,
            'language_id' => 1,
            'domain_id' => 2,
            'rack_id' => 1,
        ]);
        Book::create([
            'title' => 'The Water',
            'author' => 'Ishfaq Ahmad',
            'publish_year' => 2022,
            'num_of_copies' => 2,
            'price' => 400,
            'language_id' => 1,
            'domain_id' => 2,
            'rack_id' => 1,
        ]);
        Book::create([
            'title' => 'The Earth',
            'author' => 'Ishfaq Ahmad',
            'publish_year' => 2022,
            'num_of_copies' => 2,
            'price' => 400,
            'language_id' => 1,
            'domain_id' => 2,
            'rack_id' => 1,
        ]);
        Book::create([
            'title' => 'Eating Habits',
            'author' => 'Ishfaq Ahmad',
            'publish_year' => 2022,
            'num_of_copies' => 2,
            'price' => 400,
            'language_id' => 1,
            'domain_id' => 2,
            'rack_id' => 1,
        ]);
        Book::create([
            'title' => 'Sleep Early, Live Long',
            'author' => 'Ishfaq Ahmad',
            'publish_year' => 2022,
            'num_of_copies' => 2,
            'price' => 400,
            'language_id' => 1,
            'domain_id' => 2,
            'rack_id' => 1,
        ]);
    }
}

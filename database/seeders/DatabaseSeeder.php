<?php

namespace Database\Seeders;

use AuthorSeeder;
use BookSeeder;
use CategorySeeder;
use Illuminate\Database\Seeder;
use PublisherSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CategorySeeder::class);
        $this->call(PublisherSeeder::class);
        $this->call(AuthorSeeder::class);
        $this->call(BookSeeder::class);
    }
}

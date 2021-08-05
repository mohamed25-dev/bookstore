<?php

namespace Database\Seeders;
use App\Models\Publisher;
use Illuminate\Database\Seeder;

class PublisherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Publisher::create(['name' => 'الناشرون']);
        Publisher::create(['name' => 'دار النشر']);
        Publisher::create(['name' => 'دار الفكر']);

    }
}

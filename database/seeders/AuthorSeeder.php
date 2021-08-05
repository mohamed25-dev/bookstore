<?php

namespace Database\Seeders;
use App\Models\Author;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Author::create(['name' => 'الجاحظ']);
        Author::create(['name' => 'ابن خلدون']);
        Author::create(['name' => 'أغاثا كريستي']);
        Author::create(['name' => 'علي الطنطاوي ']);
        Author::create(['name' => 'كارل نيو بورت']);
        Author::create(['name' => 'سيبويه']);
    }
}

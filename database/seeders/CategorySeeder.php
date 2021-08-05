<?php

namespace Database\Seeders;
use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create(['name' => 'اللغة العربية']);
        Category::create(['name' => 'السيرة الذاتية']);
        Category::create(['name' => 'التاريخ']);
        Category::create(['name' => 'تطوير الذات']);
        Category::create(['name' => 'الرواية']);
    }
}

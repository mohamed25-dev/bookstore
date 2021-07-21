<?php

namespace Database\Seeders;
use App\Models\Cateogry;
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
        Cateogry::create(['name' => 'ريادة الأعمال']);
        Cateogry::create(['name' => 'العمل الحر']);
        Cateogry::create(['name' => 'التسويق والمبيعات']);
        Cateogry::create(['name' => 'التصميم']);
        Cateogry::create(['name' => 'البرمجة']);
    }
}

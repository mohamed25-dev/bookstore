<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => "admin",
            'email' => 'admin@email.com',
            'password' => bcrypt('11112222'),
            'administration_level' => '2',
        ]);

        User::create([
            'name' => "user1",
            'email' => 'user1@email.com',
            'password' => bcrypt('11112222'),
            'administration_level' => '1',
        ]);

        User::create([
            'name' => "user2",
            'email' => 'user2@email.com',
            'password' => bcrypt('11112222'),
            'administration_level' => '0',
        ]);
    }
}

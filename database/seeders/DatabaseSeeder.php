<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([ 
            'id' => '1',
            'name' => 'Administrateur',
            'email' => 'admin@gmail.com', 
            'password' => bcrypt('school@2022'), 
            //'role_id' => '1',
            'enable' => 1
        ]); 
    }
}

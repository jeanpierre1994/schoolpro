<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Statutpaiements;
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

//        $checkUser = User::where("email","admin@gmail.com")->exists();
//        if (!$checkUser) {
//            # code...
//        User::create([
//           // 'id' => '1',
//            'name' => 'Administrateur',
//            'email' => 'admin@gmail.com',
//            'password' => bcrypt('school@2022'),
//            //'role_id' => '1',
//            'enable' => 1
//        ]);
//        }
//
//        $checkData = Statutpaiements::where("libelle","EN ATTENTE")->exists();
//        if (!$checkData) {
//            # code...
//            Statutpaiements::create([
//           // 'id' => '1',
//            'libelle' => 'EN ATTENTE',
//            'created_by' => 1,
//            'updated_by' => 1
//        ]);
//        }

        $this->call(PermissionSeeder::class);
    }
}

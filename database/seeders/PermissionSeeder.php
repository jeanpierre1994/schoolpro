<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Definition de toutes les permissions
         */

        //Menu

        Permission::firstOrCreate([
            'name' => 'view parametres generaux'
        ]);
        Permission::firstOrCreate([
            'name' => 'view parametres etablissement'
        ]);
        Permission::firstOrCreate([
            'name' => 'view configuration classes'
        ]);
        Permission::firstOrCreate([
            'name' => 'view examens'
        ]);
        Permission::firstOrCreate([
            'name' => 'view finances'
        ]);
        Permission::firstOrCreate([
            'name' => 'view dossiers'
        ]);
        Permission::firstOrCreate([
            'name' => 'view imports'
        ]);
        Permission::firstOrCreate([
            'name' => 'view annonces'
        ]);
        Permission::firstOrCreate([
            'name' => 'view frais'
        ]);
        // Cycles
        Permission::firstOrCreate([
            'name' => 'viewAny cycle'
        ]);
        Permission::firstOrCreate([
            'name' => 'view cycle'
        ]);
        Permission::firstOrCreate([
            'name' => 'create cycle'
        ]);
        Permission::firstOrCreate([
            'name' => 'update cycle'
        ]);
        Permission::firstOrCreate([
            'name' => 'delete cycle'
        ]);

        // Paramétrage utilisateurs


        /**
         * Definition des rôles et assignation des permissions
         */

            /*
            |--------------------------------------------------------------------------
            | Super Admin
            | Le super admin dispose déjà de tout droit
            |--------------------------------------------------------------------------
            */
            $superAdmin = Role::firstOrCreate(['name' => "super-admin"]);

            /*
            |--------------------------------------------------------------------------
            | Superviseur
            |--------------------------------------------------------------------------
            */
            $superviseur = Role::firstOrCreate(['name' => 'superviseur']);
            $superviseur->givePermissionTo([
                'viewAny cycle', 'view cycle', 'create cycle', 'update cycle', 'delete cycle',
            ]);

            /*
            |--------------------------------------------------------------------------
            | Comptable
            |--------------------------------------------------------------------------
            */
            $comptable = Role::firstOrCreate(['name' => 'comptable']);

            /*
            |--------------------------------------------------------------------------
            | Secretaire
            |--------------------------------------------------------------------------
            */
            $secretaire = Role::firstOrCreate(['name' => 'secretaire']);

            /*
            |--------------------------------------------------------------------------
            | Prof
            |--------------------------------------------------------------------------
            */
            $prof = Role::firstOrCreate(['name' => 'professeur']);

            /*
            |--------------------------------------------------------------------------
            | Parent
            |--------------------------------------------------------------------------
            */
            $parent = Role::firstOrCreate(['name' => 'parent']);

            /*
            |--------------------------------------------------------------------------
            | Etudiant
            |--------------------------------------------------------------------------
            */
            $etudiant = Role::firstOrCreate(['name' => 'etudiant']);

            /*
            |--------------------------------------------------------------------------
            | Staff
            |--------------------------------------------------------------------------
            */

            $staff = Role::firstOrCreate(['name' => 'staff']);


        $user = User::where('id', 1)->get()->first();
        $user->assignRole('super-admin');
    }
}

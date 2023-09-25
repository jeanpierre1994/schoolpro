<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Dossiers;
use App\Models\Etudiants;
use App\Models\Personnes;
use App\Actions\GenereCode;
use Database\Factories\UserFactory;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Database\Factories\PersonneFactory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DossierImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $famille = User::firstOrCreate(
            [
                'name' => $row['last_name'] . ' Famille',
            ],[
            'email' => strtolower($row['famille'] . '@brif.com'),
            'password' => Hash::make('Inscription@2023') ,
            'profil_id' => 3,
            'enable' => 1,
        ]);

        $familePersonne = Personnes::firstOrCreate([
            'compte_id' => $famille->id,

        ],[
            'nom' => $row['last_name'],
            'prenoms' => 'Famille',
            'matricule' => $row['famille'],
            "genre" => 1,
            'statut_id' => 1,
            'tel' => 00000000,
            'email' => strtolower($row['famille'] . '@brif.com'),
            'famille' => 0,
            'created_by' => 1,
            'photo' => 'https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp'
        ]);

        $user = User::create([
            'name' => $row['last_name'] . ' ' . $row['first_name'],
            'email' => strtolower($row['register_num'] . '@brif.com'),
            'password' => Hash::make('Inscription@2023'),
            'profil_id' => 2,
            'enable' => 1,
        ]);

        $personne = Personnes::create([
            //
            'matricule' => $row['register_num'],
            'compte_id' => $user->id,
            'nom' => $row['last_name'],
            'prenoms' => $row['first_name'],
            'genre' => ($row['gender'] == 'male') ? 1 : 2,
            'tel' => 00000000,
            'email' => $user->email,
            'statut_id' => 1,
            'created_by' => $famille->id,
            'ddn' => date('Y-m-d', strtotime(str_replace('/', '-', $row['date_of_birth']))),
            'adresse' => $row['ville'],
            'nationalite' => $row['pays'],
            'photo' => 'https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp'

        ]);
     $dossier = new Dossiers([
            //

            'code' => (new GenereCode)->handle(Dossiers::class, 'DS'),
            'site_id' => 1,
            'pole_id' => 1, // FK
            'filiere_id' => 1,
            'cycle_id' => 1,
            'niveau_id' => random_int(1, 12),
            'typesponsor_id' => 2, // FK
            'annee' => 2023,
            'commentaire' => null,
            'parent_created' => 1,
            'statuttraitement_id' => 1,
            'date_traitement' => 2023,
            'validateur_id' => 1,
            'parent_id' => $famille->id,
            'created_by' => $famille->id, // FK
            'updated_by' => 1, // FK
        ]);

       
        /*$etudiant = new Etudiants([
            'matricule' => $matricule,
            'groupepedagogique_id' => NULL,
            'validateur_id' => 1,
            'commentaire' => 5,
            'statutvalidation_id' => NULL
        ]);*/
        //$personne->getCompte()->associate($user);
        $dossier->getPersonne()->associate($personne);
        $dossier->save();
        
        return $dossier;
    }
}

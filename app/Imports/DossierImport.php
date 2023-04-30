<?php

namespace App\Imports;

use App\Models\Dossiers;
use App\Models\Personnes;
use App\Models\User;
use Database\Factories\PersonneFactory;
use Database\Factories\UserFactory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Facades\Excel;

class DossierImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $user = new User([
            'name'=> $row['last_name'] . ''. $row['first_name'],
            'email' => strtolower($row['first_name'].'@mail.com'),
            'password' => strtolower($row['first_name'].$row['last_name'])
        ]);
         
        $personne = new Personnes([
            //
            'matricule' => $row['register_num'],
            'nom' => $row['last_name'],
            'prenoms' => $row['first_name'],
            'compte_id' => $user->id,
            'genre' => ($row['gender']=='male') ? 1 : 2,
            'tel' => 00000000,
            'email' => $user->email,
            'statut_id' => 2,
            'created_by' => 1,
            'ddn' => date('Y-m-d',strtotime(str_replace('/','-', $row['date_of_birth']))),
            'adresse' => $row['ville'],
            'nationalite' => $row['pays'],
           
        ]);
        return new Dossiers([
            //
            
        'code' => $row['register_num'],
        'site_id' => 1,
        'personne_id' => 1,
        'pole_id' => 1,// FK
        'filiere_id' => random_int(1,6),
        'cycle_id' => 1,
        'niveau_id' => random_int(1,12),
        'typesponsor_id' => 2, // FK
        'annee' => 2023,
        'commentaire' => null,
        'parent_created' => 1,
        'statuttraitement_id' => 2,
        'date_traitement' => 2023,
        'validateur_id' => 1, 
        'created_by' => 1, // FK
        'updated_by' => 1, // FK
        ]);
    }
}

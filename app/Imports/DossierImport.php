<?php

namespace App\Imports;

use App\Models\Dossiers;
use Maatwebsite\Excel\Concerns\ToModel;

class DossierImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Dossiers([
            //
            'code' => null,
        'site_id' => 1,
        'personne_id' =>2 ,
        'pole_id',// FK
        'filiere_id',
        'cycle_id',
        'niveau_id',
        'typesponsor_id', // FK
        'annee',
        'commentaire',
        'parent_created',
        'statuttraitement_id',
        'date_traitement',
        'validateur_id', 
        'created_by', // FK
        'updated_by', // FK
        'created_at',
        'updated_at', 
        ]);
    }
}

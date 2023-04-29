<?php

namespace App\Imports;

use App\Models\Parents;
use Maatwebsite\Excel\Concerns\ToModel;

class ParentsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Parents([
            //
            
            'nom' => $row['last_name'] ,
            'prenoms' => str_split($row['first_name'],5),
            'genre' => ($row['gender']=='male') ? 1 : 2,
            'tel' => 00000000,
            'email' => 'email@email.com',
            'statut_id' => 2,
            'created_by' => 1,
            //'ddn' => date($row['date_of_birth']),
            'adresse' => $row['ville'],
            'nationalite' => $row['pays'],
        ]);
    }
}

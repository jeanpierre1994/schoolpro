<?php

namespace App\Imports;

use App\Models\Personnes;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PersonnesImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Personnes([
            //
            'matricule' => $row['register_num'],
            'nom' => $row['last_name'],
            'prenoms' => $row['first_name'],
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

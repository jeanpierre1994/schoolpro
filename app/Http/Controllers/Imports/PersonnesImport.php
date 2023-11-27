<?php

namespace App\Imports;

use App\Models\Personnes;
use App\Models\User;
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
        $user = new User([
            'name'=> $row['last_name'] . ''. $row['first_name'],
            'email' => strtolower($row['register_num'].'@mail.com'),
            'password' => strtolower($row['first_name'].$row['last_name'])
        ]);
        return new Personnes([
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
    }
}

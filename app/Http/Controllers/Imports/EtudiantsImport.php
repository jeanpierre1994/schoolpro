<?php

namespace App\Imports;

use App\Models\Etudiants;
use Maatwebsite\Excel\Concerns\ToModel;

class EtudiantsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Etudiants([
            //
        ]);
    }
}

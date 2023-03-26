<?php

use App\Models\Etablissements;
use App\Models\Examenprog;
use App\Models\Personnes;

if (!function_exists('getPersonne')) {
    # code...
    function getPersonne($id){ 

        return $personne = Personnes::where("compte_id",$id)->first();
         
    }
}

if (!function_exists('getEtablissement')) {
    # code...
    function getEtablissement(){ 

        return $etablissement = Etablissements::first();
         
    }
}

if (!function_exists('checkMatiere')) {
    # code...
    function checkMatiere($matiere_id, $examen_id){ 
        $check_data = Examenprog::where("matiere_id",$matiere_id)->where("examen_id",$examen_id)->exists();
        if ($check_data) {
            # code...
            return false;
        } else {
            # code...
            return true;
        } 
         
    }
}

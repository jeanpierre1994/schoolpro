<?php

use App\Models\Etablissements;
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
<?php

use App\Models\Etablissements;
use App\Models\Examenprog;
use App\Models\Matiereprofesseurs;
use App\Models\Personnes;
use App\Models\Sessioncorrections;

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
 
if (!function_exists('getMatiereProf')) {
    # code...
    function getMatiereProf($professeur_id){ 
        return $data = Matiereprofesseurs::join('matieres', 'matieres.id', '=', 'matiereprofesseurs.matiere_id')
        ->join('groupepedagogiques', 'groupepedagogiques.id', '=', 'matieres.groupepedagogique_id')
        ->where("matiereprofesseurs.professeur_id",$professeur_id)
        ->get(["groupepedagogiques.libelle_classe","matieres.libelle"]);
    }

}

// 

if (!function_exists('checkSession')) {
    # code...
    function checkSession($examenprog_id){ 
        return  Sessioncorrections::where("examen_prog_id", $examenprog_id)->exists();
    } 
}
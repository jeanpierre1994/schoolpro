<?php

use App\Models\Etablissements;
use App\Models\Examenprog;
use App\Models\Matiereprofesseurs;
use App\Models\Matieres;
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
        ->get(["groupepedagogiques.libelle_classe","matieres.libelle","matiereprofesseurs.id"]);
    }

}

if (!function_exists('getProfByMatiere')) {
    # code...
    function getProfByMatiere($matiere_id,$gp_id){ 
        return $data = Matiereprofesseurs::join('matieres', 'matieres.id', '=', 'matiereprofesseurs.matiere_id')
        ->join('groupepedagogiques', 'groupepedagogiques.id', '=', 'matieres.groupepedagogique_id')
        ->leftJoin('users', 'users.id', '=', 'matiereprofesseurs.professeur_id')
        ->leftJoin('personnes', 'personnes.compte_id', '=', 'users.id')
        ->where("groupepedagogiques.id",$gp_id)
        ->where("matieres.id",$matiere_id)
        ->get(["groupepedagogiques.libelle_classe","matieres.libelle","matiereprofesseurs.id","personnes.nom","personnes.prenoms","personnes.tel","personnes.email","users.id as user_id"]);
    }

}

// 

if (!function_exists('checkSession')) {
    # code...
    function checkSession($examenprog_id){ 
        return  Sessioncorrections::where("examen_prog_id", $examenprog_id)->exists();
    } 
}

if (!function_exists('getProfesseurMatiere')) {
    # code...
    function getProfesseurMatiere($matiere_id){ 
        return  Matiereprofesseurs::where("matiere_id", $matiere_id)->get();
    } 
}


if (!function_exists('getDataProfesseur')) {
    # code...
    function getDataProfesseur($id){ 
        return Personnes::where("compte_id",$id)->first();
    } 
}


if (!function_exists('checkGpMatiere')) {
    # code...
    function checkGpMatiere($id,$matiereconfig_id){ 

       return $check_data = Matieres::where("matiereconfig_id",$matiereconfig_id)->where("groupepedagogique_id",$id)->exists();
 
         
    }

}


if (!function_exists('getClasse')) {
    # code...
    function getClasse($matiereconfig_id){ 
       return $matiere_gp = Matieres::where("matiereconfig_id",$matiereconfig_id)->get();         
    }

}



<?php

namespace App\Http\Controllers;

use App\Models\Cycles;
use App\Models\Etablissements;
use App\Models\Genres;
use App\Models\Poles;
use App\Models\Profil;
use App\Models\Typesponsors;
use Illuminate\Http\Request;

class AdminEtudiantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addEtudiant(Request $request)
    {
        // redirection sur le formulaire d'inscription 
        $genres = Genres::where("statut_id", 1)->get();
        $profils = Profil::where("statut_id", "=", 1)->where("id", "=", 2)->orWhere("id", "=", 3)->get();
        $etablissements = Etablissements::where("statut_id", 1)->get();
        $poles = Poles::where("statut_id", 1)->get();
        $cycles = Cycles::where("statut_id", 1)->get();
        $typesponsors = Typesponsors::where("statut_id", 1)->get();
        return view("backend.administrations.etudiants.create", compact("genres", "profils","etablissements","poles","cycles","typesponsors"));
    }
}

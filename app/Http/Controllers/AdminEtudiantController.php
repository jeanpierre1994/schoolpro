<?php

namespace App\Http\Controllers;

use App\Models\Genres;
use App\Models\Profil;
use Illuminate\Http\Request;

class AdminEtudiantController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addEtudiant(Request $request )
    {
        // redirection sur le formulaire d'inscription 
            $genres = Genres::where("statut_id",1)->get();
            $profils = Profil::where("statut_id","=",1)->where("id","=",2)->orWhere("id","=",3)->get(); 
        return view("backend.administrations.etudiants.create", compact("genres","profils"));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Pays;
use App\Models\Poles;
use App\Models\Cycles;
use App\Models\Genres;
use App\Models\Profil;
use App\Models\Examens;
use App\Models\Parents;
use App\Mail\ReleveNotes;
use App\Models\Etudiants;
use App\Models\Personnes;
use App\Models\Typesponsors;
use Illuminate\Http\Request;
use App\Models\Etablissements;
use App\Models\Groupepedagogiques;
use Illuminate\Support\Facades\Mail;

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
        $gp = Groupepedagogiques::all();
        $pays = Pays::all();

        $parents = Personnes::join("users","users.id","=","personnes.compte_id")
        ->where("users.profil_id",3)
        ->get(["personnes.id","personnes.nom","personnes.prenoms"]);

        $etudiants = Personnes::join("users","users.id","=","personnes.compte_id")
        ->where("users.profil_id",2)
        ->get(["personnes.id","personnes.nom","personnes.prenoms"]);

        return view("backend.administrations.etudiants.create", compact("pays", "genres", "profils","etablissements","poles","cycles","typesponsors","gp","parents","etudiants"));
    }

    public function index()
    {
        $etudiants = Etudiants::with('getDossier')->latest()->get();
        $poles = Poles::with('groupePedagogiques')->get();
        return view('backend.administrations.etudiants.index', [
            'etudiants' => $etudiants,
            'poles' => $poles
        ]);
    }

    public function edit($id)
    {
        $id = \Crypt::decrypt($id);
        $etudiant = Etudiants::where('id', $id)->get()->first();
        $genres = Genres::where("statut_id", 1)->get();
        $profils = Profil::where("statut_id", "=", 1)->where("id", "=", 2)->orWhere("id", "=", 3)->get();
        $etablissements = Etablissements::where("statut_id", 1)->get();
        $poles = Poles::where("statut_id", 1)->get();
        $cycles = Cycles::where("statut_id", 1)->get();
        $typesponsors = Typesponsors::where("statut_id", 1)->get();

        return view('backend.administrations.etudiants.edit', compact("genres", "profils","etablissements","poles","cycles","typesponsors", "etudiant"));
    }

    public function releve($id)
    {
        $id = \Crypt::decrypt($id);
        $etudiant = Etudiants::where('id', $id)->get()->first();
        $gp = Groupepedagogiques::find($etudiant->groupepedagogique_id);

        $examens = Examens::all();
        return view("backend.groupepedagogiques.lise-examens", compact("etudiant","gp","examens"));


    }

    public function sendMail($id)
    {
        $id = \Crypt::decrypt($id);
        $examen = Examens::find($id);
        $etudiant_id = \Crypt::decrypt(request()->etudiant_id);
        $etudiant = Etudiants::find($etudiant_id);
        $parentEmail = $etudiant->getDossier->getUserCreated->email;
        Mail::to($parentEmail)->send(new ReleveNotes($etudiant, $examen ));

        return redirect()->back()->with('success', 'Mail Envoyé avec succès');
    }

    public function update(Etudiants $etudiant)
    {
        dd('ok');
        return redirect()->back();
    }
}

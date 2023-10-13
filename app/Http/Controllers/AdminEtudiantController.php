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
use App\Models\Dossiers;
use App\Models\Etudiants;
use App\Models\Personnes;
use App\Models\Typesponsors;
use Illuminate\Http\Request;
use App\Models\Etablissements;
use App\Models\Groupepedagogiques;
use App\Models\User;
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
        $profils = Profil::where("id", "=", 2)->get();
        $etablissements = Etablissements::where("statut_id", 1)->get();
        $poles = Poles::where("statut_id", 1)->get();
        $cycles = Cycles::where("statut_id", 1)->get();
        $typesponsors = Typesponsors::where("statut_id", 1)->get();
        $gp = Groupepedagogiques::all();
        $pays = Pays::where("nationalite","!=","")->orderBy("nationalite","asc")->get();

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
        $gp = Groupepedagogiques::all();
        return view('backend.administrations.etudiants.edit', compact("genres", "profils","etablissements","poles","cycles","typesponsors", "etudiant","gp"));
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

    public function update(Request $request)
    {
        $this->validate($request, [
            'nom' => 'required',
            'prenoms' => 'required',
            'gp_id' => 'required',
            'genre_id' => 'required',
            'etudiant_id' => 'required',
        ]);

        $user = auth()->user();
        $user_id = $user->id;
        $etudiant = Etudiants::find($request->etudiant_id);
        // modification des informations de l'étudiant 
        $dossier = Dossiers::find($etudiant->dossier_id);
        $personne = Personnes::find($dossier->personne_id);
        $compte_etudiant = User::find($personne->compte_id);
        $gp = Groupepedagogiques::find($request->gp_id);

        $etudiant->setAttribute("groupepedagogique_id",$request->gp_id);
        $etudiant->save();

        $dossier->setAttribute("groupepedagogique_id",$request->gp_id);
        $dossier->setAttribute("pole_id",$gp->pole_id);
        $dossier->setAttribute("filiere_id",$gp->filiere_id);
        $dossier->setAttribute("cycle_id",$gp->cycle_id);
        $dossier->setAttribute("niveau_id",$gp->niveau_id);
        $dossier->save();

        $personne->setAttribute("nom",$request->nom);
        $personne->setAttribute("prenoms",$request->prenoms);
        $personne->setAttribute("genre",$request->genre_id);
        $personne->setAttribute("ddn",$request->ddn);
        $personne->setAttribute("tel",$request->telephone);
        $personne->setAttribute("lieunais",$request->lieu_naissance);
        $personne->save();

        $compte_etudiant->setAttribute("name",$request->nom.' '.$request->prenoms);
        $compte_etudiant->setAttribute("email",$request->email);
        $compte_etudiant->save();

        return redirect()->route('admin.etudiants')
            ->with('success', 'Modification effectuée avec succès');
             
    }
}

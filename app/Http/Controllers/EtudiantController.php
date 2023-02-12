<?php

namespace App\Http\Controllers;

use App\Models\Cycles;
use App\Models\Dossiers;
use App\Models\Etablissements;
use App\Models\Filieres;
use App\Models\Genres;
use App\Models\Niveaux;
use App\Models\Personnes;
use App\Models\Poles;
use App\Models\Statuttraitements;
use App\Models\Typesponsors;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert as Alert;

class EtudiantController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function identite()
    {
        $user = Auth()->user();
        $etudiant = Personnes::where("compte_id", $user->id)->first();
        return view("frontend.etudiants.identite", compact("etudiant"));
    }

    // editProfil
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function editProfil(Request $request, $id)
    {
        $etudiant = Personnes::find($id);
        $genres = Genres::where("statut_id",1)->get();
        return view("frontend.etudiants.edit_profil", compact("etudiant","genres"));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function editProfilStore(Request $request)
    {
        $this->validate($request, [
            'nom' => 'required',
            'prenoms' => 'required',
            'telephone' => 'required',
            'email' => 'required', 
            'genre_id' => 'required',  
            'etudiant_id'=> 'required',  

        ]);

        // vérifier si l'étudiant existe déjà
        $check_personne = Personnes::where("nom",$request->nom)->where("prenoms",$request->prenoms)->where("tel",$request->telephone)->where("email",$request->email)
        ->where("id","!=",$request->etudiant_id)->exists();

        if($check_personne){
           // if categorie exist redirect to form with error message
            return redirect()->back()->with('error', "Un utilisateur avec les mêmes informations existe déjà.");
        }

         // enregistrement de la photo si disponible 
        // initialize photo_path value
        $photo_path = null;
        $picture = $request->photo;
        if (!empty($picture)) {
            # code... 
            $extension_picture = $picture->getClientOriginalExtension();  
            $photo_path = "photo_".date('Ymd-His').'.'.$extension_picture;
            $picture->storeAs('photos', $photo_path,'public');  
        }  


        // modification le compte de l'utilisateur 
        $personne = Personnes::find($request->etudiant_id);
        $compte_user = User::find($personne->compte_id);
        $name = $request->nom." ".$request->prenoms;  
        $compte_user->setAttribute('name', trim($name));
        $compte_user->setAttribute('email', trim($request->email));   
        $compte_user->update();

        // enregistrement compte étudiant 
        $personne->setAttribute('nom', trim($request->nom));
        $personne->setAttribute('prenoms', trim($request->prenoms));
        $personne->setAttribute('compte_id', $compte_user->id); 
        $personne->setAttribute('genre', trim($request->genre_id)); 
        $personne->setAttribute('tel', trim($request->telephone));
        $personne->setAttribute('email', trim($request->email)); 
        $personne->setAttribute('ddn', trim($request->ddn));   
        $personne->setAttribute('tel', trim($request->telephone));   
        $personne->setAttribute('lieunais', trim($request->lieu_naissance));   
        $personne->setAttribute('nomjeunefille', trim($request->nom_jeune_fille));   
        $personne->setAttribute('adresse', trim($request->adresse)); 
        $personne->setAttribute('site_web', trim($request->site_web)); 
        $personne->setAttribute('lien_linkedin', trim($request->lien_linkedin)); 
        $personne->setAttribute('lien_github', trim($request->lien_github)); 
        $personne->setAttribute('lien_facebook', trim($request->lien_facebook)); 
        if (!empty($photo_path)) {
            # code...
            $personne->setAttribute('photo', trim($photo_path)); 
        }  
        $personne->setAttribute('created_by', $compte_user->id); 
        $personne->setAttribute('updated_by', $compte_user->id);
        $personne->setAttribute('statut_id', 1);
        $personne->update();

        Alert::toast("Modification effectuée avec succès.",'success');

        return redirect()->route("etudiant.identite");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dossiers()
    {
        $user = Auth()->user();
        $etudiant = Personnes::where("compte_id", $user->id)->first();
        $dossiers = Dossiers::where("created_by", $user->id)->where("statuttraitement_id","!=", 2)->get();
        return view("frontend.etudiants.dossiers", compact("etudiant","dossiers"));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function newDossier()
    {  
        $user = Auth()->user();
        $etudiant = Personnes::where("compte_id", $user->id)->first();
        $etablissements = Etablissements::where("statut_id", 1)->get();
        $poles = Poles::where("statut_id", 1)->get();
        $cycles = Cycles::where("statut_id", 1)->get();  
        $typesponsors = Typesponsors::where("statut_id", 1)->get();  

        return view("frontend.etudiants.new_dossier", compact("etudiant","poles","cycles","etablissements","poles","cycles","typesponsors"));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveDossier(Request $request)
    {
        $this->validate($request, [
            'etudiant_id' => 'required',
            'etablissement_id' => 'required',
            'site_id' => 'required',
            'pole_id' => 'required', 
            'filiere_id' => 'required',  
            'cycle_id'=> 'required',  
            'niveau_id'=> 'required',  
            'annee'=> 'required',  
            'typesponsor_id'=> 'required',  

        ]);

        // vérifier si le dossier existe déjà
        $check_dossier = Dossiers::where("personne_id",$request->etudiant_id)->where("site_id",$request->site_id)->where("pole_id",$request->pole_id)->where("filiere_id",$request->filiere_id)
        ->where("cycle_id",$request->cycle_id)->where("niveau_id",$request->niveau_id)
        ->where("typesponsor_id",$request->typesponsor_id)
        ->exists();

        if($check_dossier){
           // if categorie exist redirect to form with error message
            return redirect()->back()->with('error', "Ce dossier existe déjà.");
        } 

        $user = Auth()->user();
        $statut_traitement = Statuttraitements::where("libelle","EN ATTENTE")->first();
       
 
        //##################### générer le code  ###########################
        // procédure d'incrémentation du code
        $annee_actuelle = date('y');
        $indicatif = "DS";
        $id_1 = "";
        // récupérer le dernier enregistrement
        $last_numero = Dossiers::orderBy('id', 'desc')->first();
 
        if ($last_numero == NULL) {
            $last_id = "";
        } else {
            $last_id = $last_numero->code_user;
        }

        if (!empty($last_id)) {
            //$str = "DS11111122"; 
            // delete DS
            $delete_bu = substr($last_id, -8); 
            // delete YEAR
            $correct_code = substr($delete_bu,0, 6);
            $id_1 = $correct_code;
        } else {
            $id_1 = '000000';
        }

        // récupérer le numéro à incrémenter sur la position 2 du tableau $id_1
        if (!empty($last_id)) {
            //vérifier si nous somme dans une nouvelle année pour réinitialiser le compteur
            $get_date = substr($last_id, -2);
            if ($annee_actuelle > $get_date) {
                # code...
                $numero = '000000';
            } else {
                # code...
                //$str = "BU111111122"; 
                // delete BU
                $delete_bu = substr($last_id, -8); 
                // delete YEAR
                $correct_code = substr($delete_bu,0, 6); 
                $numero = $correct_code;
            } 
        } else {
            $numero = '000000';
        }

         

        $numero_user = $numero + 1;

        $numero_user_formatted = str_pad($numero_user, 6, "0", STR_PAD_LEFT);
        $code_dossier = $indicatif.$numero_user_formatted.$annee_actuelle;
       
        //################################### end générer le code  ###################




        $dossier = new Dossiers();   
        $dossier->setAttribute('code', trim($code_dossier));
        $dossier->setAttribute('personne_id', trim($request->etudiant_id));
        $dossier->setAttribute('site_id', trim($request->site_id));
        $dossier->setAttribute('pole_id', $request->pole_id); 
        $dossier->setAttribute('filiere_id', trim($request->filiere_id)); 
        $dossier->setAttribute('cycle_id', trim($request->cycle_id));
        $dossier->setAttribute('niveau_id', trim($request->niveau_id)); 
        $dossier->setAttribute('annee', trim($request->annee));   
        $dossier->setAttribute('typesponsor_id', trim($request->typesponsor_id));   
        $dossier->setAttribute('sponsor', trim($request->sponsor));   
        $dossier->setAttribute('parent_created', false);   
        $dossier->setAttribute('statuttraitement_id', trim($statut_traitement->id));  
        $dossier->setAttribute('created_by', $user->id); 
        $dossier->setAttribute('updated_by', $user->id); 
        $dossier->save();

        Alert::toast("Enregistrement effectué avec succès.",'success');

        return redirect()->route("etudiant.dossiers");
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dossierValide()
    {
        $user = Auth()->user();
        $etudiant = Personnes::where("compte_id", $user->id)->first();
        $dossiers = Dossiers::where("created_by", $user->id)->where("statuttraitement_id", 2)->get();
        return view("frontend.etudiants.inscriptions", compact("etudiant","dossiers"));
    }

}

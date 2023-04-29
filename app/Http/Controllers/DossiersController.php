<?php

namespace App\Http\Controllers;

use App\Models\Dossiers;
use App\Models\Etudiants;
use App\Models\Groupepedagogiques;
use App\Models\Statuttraitements;
use Illuminate\Http\Request;

class DossiersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function enAttente()
    {
        // dossier en attente
        $dossiers = Dossiers::where("statuttraitement_id","=", 1)->get();
        return view("backend.dossiers.en_attente", compact("dossiers"));
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function valide()
    {
        // dossier en attente
        $dossiers = Etudiants::orderBy('id', 'DESC')->get();
        return view("backend.dossiers.valide", compact("dossiers"));
    }

 

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function rejete()
    {
        // dossier en attente
        $dossiers = Dossiers::where("statuttraitement_id", 3)->get();
        return view("backend.dossiers.rejete", compact("dossiers"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function traitement(Request $request, $id)
    {
        // traitement des dossiers en attente
        $dossier = Dossiers::find($id);
        $gp = Groupepedagogiques::orderBy("libelle_classe","asc")->get();
        $statuttraitements  = Statuttraitements::all();
        return view("backend.dossiers.traitement", compact("dossier","gp","statuttraitements"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeTraitement(Request $request)
    {
        $this->validate($request, [
            'statuttraitement_id' => 'required',
            'id' => 'required',
            'groupepedagogique_id' => 'required', 
        ]);

        $user = auth()->user(); 
        $dossier = Dossiers::find($request->id);

        if ($request->statuttraitement_id == 2) {
            # code...
            $dossier->setAttribute("statuttraitement_id",$request->statuttraitement_id);
            $dossier->setAttribute("statuttraitement_id",$request->statuttraitement_id);
            $dossier->setAttribute("commentaire",$request->commentaire);
            $dossier->setAttribute("date_traitement",date("d-m-Y"));
            $dossier->setAttribute("validateur_id",$user->id);
            $dossier->update();

            //##################### générer le code  ###########################
        // procédure d'incrémentation du code
        $annee_actuelle = date('y');
        $indicatif = "MT";
        $id_1 = "";
        // récupérer le dernier enregistrement
        $last_numero = Etudiants::orderBy('id', 'desc')->first();
 
        if ($last_numero == NULL) {
            $last_id = "";
        } else {
            $last_id = $last_numero->matricule;
        }

        if (!empty($last_id)) { 
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
        $matricule = $indicatif.$numero_user_formatted.$annee_actuelle;
       
        //################################### end générer le code  ###################


            // créer le compte étudiant
            $inscription = new Etudiants();
            $inscription->setAttribute("matricule",$matricule);
            $inscription->setAttribute("dossier_id",$request->id);
            $inscription->setAttribute("validateur_id",$user->id);
            $inscription->setAttribute("commentaitaire",$request->id);
            $inscription->save();


        } else {
            # code...

            $dossier->setAttribute("statuttraitement_id",$request->statuttraitement_id);
            $dossier->setAttribute("statuttraitement_id",$request->statuttraitement_id);
            $dossier->setAttribute("commentaire",$request->commentaire);
            $dossier->setAttribute("date_traitement",date("d-m-Y"));
            $dossier->setAttribute("validateur_id",$user->id);
            $dossier->update();

        }
         return redirect()->route("dossiers.en_attente")->with("success","Traitement effectué avec succès.");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dossiers  $dossiers
     * @return \Illuminate\Http\Response
     */
    public function show(Dossiers $dossiers)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dossiers  $dossiers
     * @return \Illuminate\Http\Response
     */
    public function edit(Dossiers $dossiers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dossiers  $dossiers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dossiers $dossiers)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dossiers  $dossiers
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dossiers $dossiers)
    {
        //
    }
}

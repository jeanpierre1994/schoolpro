<?php

namespace App\Http\Controllers;

use App\Models\Dossiers;
use App\Models\Etudiants;
use App\Models\Groupepedagogiques;
use App\Models\Paiements;
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
        $dossiers = Dossiers::where("statuttraitement_id", "=", 1)->get();
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
        $gp = Groupepedagogiques::orderBy("libelle_classe", "asc")->get();
        $statuttraitements  = Statuttraitements::all();
        return view("backend.dossiers.traitement", compact("dossier", "gp", "statuttraitements"));
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
            $dossier->setAttribute("statuttraitement_id", $request->statuttraitement_id);
            $dossier->setAttribute("groupepedagogique_id", $request->groupepedagogique_id);
            $dossier->setAttribute("commentaire", $request->commentaire);
            $dossier->setAttribute("date_traitement", date("d-m-Y"));
            $dossier->setAttribute("validateur_id", $user->id);
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
                $correct_code = substr($delete_bu, 0, 6);
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
                    $correct_code = substr($delete_bu, 0, 6);
                    $numero = $correct_code;
                }
            } else {
                $numero = '000000';
            }



            $numero_user = $numero + 1;

            $numero_user_formatted = str_pad($numero_user, 6, "0", STR_PAD_LEFT);
            $matricule = $indicatif . $numero_user_formatted . $annee_actuelle;

            //################################### end générer le code  ###################


            // créer le compte étudiant
            $inscription = new Etudiants();
            $inscription->setAttribute("matricule", $matricule);
            $inscription->setAttribute('groupepedagogique_id', $request->groupepedagogique_id);
            $inscription->setAttribute("dossier_id", $request->id);
            $inscription->setAttribute("validateur_id", $user->id);
            if (!empty($request->montant_payer)) {
                # code... 
                $inscription->setAttribute("compte", $request->montant_payer);
            }
            $inscription->setAttribute("commentaitaire", $request->id);
            $inscription->save();
        } else {
            # code...

            $dossier->setAttribute("statuttraitement_id", $request->statuttraitement_id);
            $dossier->setAttribute("groupepedagogique_id", $request->groupepedagogique_id);
            $dossier->setAttribute("commentaire", $request->commentaire);
            $dossier->setAttribute("date_traitement", date("d-m-Y"));
            $dossier->setAttribute("validateur_id", $user->id);
            $dossier->update();
        }

        // enregistrement des paiement
        if (isset($_POST["paiement"]) && $request->montant_payer > 0 && $request->statuttraitement_id == 2) {
            // enregistrer le paiement avec statut en attente
            // générer le numero de reference facture
            // procédure d'incrémentation du numéro inventaire
            $annee_actuelle = date('Y');
            $type_reference = "FACT";
            $indicatif = "SCH";
            $id_1 = "";
            // récupérer le dernier enregistrement
            $last_numero_paiement = Paiements::orderBy('id', 'desc')->first();

            if ($last_numero_paiement == NULL) {
                $last_id = "";
            } else {
                $last_id = $last_numero_paiement->reference;
            }

            if (!empty($last_id)) {
                $id_1 = explode('-', $last_id);
                //vérifier si nous somme dans une nouvelle année pour réinitialiser le compteur
                $get_date = $id_1[1];
                if ($annee_actuelle > $get_date) {
                    # code...
                    $numero = '0000000';
                } else {
                    # code...
                    $numero = $id_1[3];
                }
            } else {
                $id_1 = '000000';
                $numero = '000000';
            }

            $numero_fact = $numero + 1;

            $numero_fact_formatted = str_pad($numero_fact, 6, "0", STR_PAD_LEFT);
            $reference_paiement = $indicatif . '-' . $annee_actuelle . '-' . $type_reference . '-' . $numero_fact_formatted;

            // enregistrement du paiement

            $preuve_path = null;
        $preuve = $request->preuve;

        if (!empty($preuve)) {
            # code... 
            $extension_preuve = $preuve->extension(); // getClientOriginalExtension();  
            $preuve_path = "preuve_" . date('Ymd-His') . '.' . $extension_preuve;
            $preuve->storeAs('preuve', $preuve_path, 'public');
        }

            $paiement = new Paiements();
            $paiement->setAttribute('reference', $reference_paiement);
            $paiement->setAttribute('montant_a_payer', $request->montant_a_payer);
            $paiement->setAttribute('montant_paye', $request->montant_payer);
            $paiement->setAttribute('statut_traitement', "ATTENTE");
            $paiement->setAttribute('etudiant_id', $inscription->id);

            if (isset($_POST["mode_paiement"])) {
                # code...
                $paiement->setAttribute('mod_paiement', $request->mode_paiement);
            }
 
            $paiement->setAttribute('preuve', $preuve_path);
             

            $paiement->setAttribute('enregistrer_par', $user->id);
            $paiement->save();
            // redirection sur le formulaire de paiement kkiapay
            return redirect()->route("paiement.kkiapay",$paiement->reference);

        }else{
            return redirect()->route("dossiers.en_attente")->with("success", "Traitement effectué avec succès.");
        }


        
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

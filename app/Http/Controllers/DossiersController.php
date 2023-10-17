<?php

namespace App\Http\Controllers;

use App\Models\Dossiers;
use App\Models\Echeanciers;
use App\Models\Etudiants;
use App\Models\Groupepedagogiques;
use App\Models\historiquepaiementecheanciers;
use App\Models\Historiqueportefeuilles;
use App\Models\Lignetarifs;
use App\Models\Paiements;
use App\Models\Personnes;
use App\Models\Portefeuilles;
use App\Models\Statuttraitements;
use Illuminate\Contracts\Session\Session;
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
        $gp = Groupepedagogiques::find($request->groupepedagogique_id);
        if ($gp->grilletarifaire_id) {
            # code...
        } else {
            return redirect()->back()->with("error", "La grille tarifaire n'est pas encore configuré pour ce groupe pédagogique.");
        }

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
            return redirect()->route("dossiers.en_attente")->with("success", "Traitement effectué avec succès.");
        }

        // vérifier si le compte parent existe
        if ($dossier->parent_id) {
            # code...
            $get_parent = Personnes::where("compte_id", $dossier->parent_id)->first();
            // vérifier si le parent dispose déjà de portefeuille
            $check_portefeuille = Portefeuilles::where("personne_id", $get_parent->id)->first();
            if ($check_portefeuille) {
                # code...
                $dossier->setAttribute("portefeuille_id", $check_portefeuille->id);
                $dossier->update();
            } else {
                # code... new portefeuille
                $portefeuille = new Portefeuilles();
                $portefeuille->setAttribute("montant", 0);
                $portefeuille->setAttribute("personne_id", $get_parent->id);
                $portefeuille->setAttribute("statut_id", 1);
                $portefeuille->setAttribute("created_by", $dossier->parent_id);
                $portefeuille->setAttribute("updated_by", $dossier->parent_id);
                $portefeuille->save();
                $dossier->setAttribute("portefeuille_id", $portefeuille->id);
                $dossier->update();
            }
        } else {
            # code... prendre le portefeuille de l'étudiant même
            $check_portefeuille = Portefeuilles::where("personne_id", $dossier->personne_id)->first();
            if ($check_portefeuille) {
                # code...
                $dossier->setAttribute("portefeuille_id", $check_portefeuille->id);
                $dossier->update();
            } else {
                # code... new portefeuille
                $portefeuille = new Portefeuilles();
                $portefeuille->setAttribute("montant", 0);
                $portefeuille->setAttribute("personne_id", $dossier->personne_id);
                $portefeuille->setAttribute("statut_id", 1);
                $portefeuille->setAttribute("created_by", $dossier->getPersonne->compte_id);
                $portefeuille->setAttribute("updated_by", $dossier->getPersonne->compte_id);
                $portefeuille->save();
                $dossier->setAttribute("portefeuille_id", $portefeuille->id);
                $dossier->update();
            }
        }

        // vérifier si un la génération des échéances est faite : 
        $checkGeneration = Echeanciers::where("dossier_id", $dossier->id)->exists();
        if (!$checkGeneration) {
            # code... génération de l'échéance
            // vérifier si le groupe pédagogique possède déjà une grille tarifaire
            if ($gp->grilletarifaire_id != null && $gp->grilletarifaire_id != 0) {
                # code...
                $ligne_tarif = Lignetarifs::where("grille_tarifaire_id", $gp->grilletarifaire_id)->get();
                foreach ($ligne_tarif as $value) {
                    # code...
                    $echeancier = new Echeanciers();
                    $echeancier->setAttribute("dossier_id", $dossier->id);
                    $echeancier->setAttribute("lignetarif_id", $value->id);
                    $echeancier->setAttribute("montant_rubrique", $value->montant);
                    $echeancier->setAttribute("montant_payer", $value->montant);
                    $echeancier->setAttribute("montant_restant", $value->montant);
                    $echeancier->setAttribute("statutpaiement_id", 1); // en attente
                    $echeancier->setAttribute("created_by", $user->id);
                    $echeancier->setAttribute("updated_by", $user->id);
                    $echeancier->save();
                }

                // afficher l'interface permettant de choisir les rubriques de paiement
                return redirect()->route("paiements.choix_rubrique", $dossier->id);
            }
        }


        // choix rubrique : 
        return redirect()->route("paiements.choix_rubrique", $dossier->id);
        // enregistrement des paiement
        /*if (isset($_POST["paiement"]) && $request->montant_payer > 0 && $request->statuttraitement_id == 2) {
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
            return redirect()->route("paiement.kkiapay", $paiement->reference);
        } else {
            return redirect()->route("dossiers.en_attente")->with("success", "Traitement effectué avec succès.");
        }*/
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

    // choix des rubriques
    public function ajouterPaiement(Request $request, $id)
    {
        $dossier = Dossiers::find($id);
        if ($dossier->groupepedagogique_id) {
        } else {
            $etudiant = Etudiants::where("dossier_id",$dossier->id)->first();
            $dossier->setAttribute("groupepedagogique_id",$etudiant->groupepedagogique_id)->update();;
            //$dossier
        }
        $checkEcheancier = Echeanciers::where("dossier_id", $dossier->id)->exists();
       
        if ($checkEcheancier) {
            # code...

        } else {
 
            # code...
             # code...
             $user = auth()->user();
             $ligne_tarif = Lignetarifs::where("grille_tarifaire_id", $dossier->getGp->grilletarifaire_id)->get();
            
             foreach ($ligne_tarif as $value) {
                 # code...
                 $echeancier = new Echeanciers();
                 $echeancier->setAttribute("dossier_id", $dossier->id);
                 $echeancier->setAttribute("lignetarif_id", $value->id);
                 $echeancier->setAttribute("montant_rubrique", $value->montant);
                 $echeancier->setAttribute("montant_payer", $value->montant);
                 $echeancier->setAttribute("montant_restant", $value->montant);
                 $echeancier->setAttribute("statutpaiement_id", 1); // en attente
                 $echeancier->setAttribute("created_by", $user->id);
                 $echeancier->setAttribute("updated_by", $user->id);
                 $echeancier->save();
             }

        }
        
        
        $echeanciers = Echeanciers::
        join("lignetarifs","lignetarifs.id","=","echeanciers.lignetarif_id")
        ->join("rubriques","rubriques.id","=","lignetarifs.rubrique_id")
        ->join("dossiers","dossiers.id","=","echeanciers.dossier_id")
        ->join("famille_rubriques","famille_rubriques.id","=","rubriques.famille_rubrique_id")
        ->where("dossier_id", $dossier->id)->where("active", true)
        ->orderBy("famille_rubriques.libelle","ASC") 
        ->get(["echeanciers.id","echeanciers.dossier_id","famille_rubriques.libelle as famille","rubriques.libelle as rubrique","echeanciers.montant_rubrique","echeanciers.lignetarif_id","dossiers.code"]);
       
        if ($dossier->portefeuille_id) {
        } else {
            // vérifier si le compte parent existe
            if ($dossier->parent_id) {
                # code...
                $get_parent = Personnes::where("compte_id", $dossier->parent_id)->first();
                // vérifier si le parent dispose déjà de portefeuille
                $check_portefeuille = Portefeuilles::where("personne_id", $get_parent->id)->first();
                if ($check_portefeuille) {
                    # code...

                    $dossier->setAttribute("portefeuille_id", $check_portefeuille->id);
                    $dossier->update();
                } else {
                    # code... new portefeuille
                    $portefeuille = new Portefeuilles();
                    $portefeuille->setAttribute("montant", 0);
                    $portefeuille->setAttribute("personne_id", $get_parent->id);
                    $portefeuille->setAttribute("statut_id", 1);
                    $portefeuille->setAttribute("created_by", $dossier->parent_id);
                    $portefeuille->setAttribute("updated_by", $dossier->parent_id);
                    $portefeuille->save();
                    $dossier->setAttribute("portefeuille_id", $portefeuille->id);
                    $dossier->update();
                }
            } else {
                # code... prendre le portefeuille de l'étudiant même
                $personne = Personnes::find($dossier->personne_id);
                $check_portefeuille = Portefeuilles::where("personne_id", $personne->id)->first();
                if ($check_portefeuille) {
                    # code...
                    $dossier->setAttribute("portefeuille_id", $check_portefeuille->id);
                    $dossier->update();
                } else {
                    # code... new portefeuille
                    $portefeuille = new Portefeuilles();
                    $portefeuille->setAttribute("montant", 0);
                    $portefeuille->setAttribute("personne_id", $personne->id);
                    $portefeuille->setAttribute("statut_id", 1);
                    $portefeuille->setAttribute("created_by", $personne->compte_id);
                    $portefeuille->setAttribute("updated_by", $personne->compte_id);
                    $portefeuille->save();
                    $dossier->setAttribute("portefeuille_id", $portefeuille->id);
                    $dossier->update();
                }
            }
        }

        return view('backend.paiements.reglement', compact('dossier', 'echeanciers'));
    }

    public function reglementEcheancier(Request $request)
    {
        $user = auth()->user();
        $this->validate($request, [
            'get_montant_total_restant' => 'required',
            'get_montant_total_regler' => 'required',
            'dossier_id' => 'required',
            'montant_portefeuille' => 'required', 
            'montant_restant' => 'required',
            'montant_regle' => 'required',
            'echeancier_id' => 'required'
        ]);
        $dossier = Dossiers::find($request->dossier_id);
 
        // enregistrement historique paiement echeancier
        $data = $request->echeancier_id;
        $montant_restant = $request->montant_restant;
        $montant_regle = $request->montant_regle;         
 
        // enregistrement du paiement
        // création paiement 
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

            $preuve_path = null; 

            // enregistrement du paiement
            $paiement = new Paiements();
            $paiement->setAttribute('reference', $reference_paiement);
            $paiement->setAttribute('montant_a_payer', $request->get_montant_total_regler);
            $paiement->setAttribute('montant_paye', $request->get_montant_total_regler);
            $paiement->setAttribute('statut_traitement', "VALIDE"); // à revoir 
            if (isset($_POST["mode_paiement"])) {
                # code...
                $paiement->setAttribute('mod_paiement', $request->modepaiement);
            }
            $paiement->setAttribute('preuve', $preuve_path);
            $paiement->setAttribute('enregistrer_par', $user->id);
            $paiement->save();

            // debit portefeuille

            // enregistrement historique paiement 
            $historique = new Historiqueportefeuilles();
            $historique->setAttribute("old_montant", $dossier->getPortefeuille->montant);
            $historique->setAttribute("new_montant", $request->get_montant_total_regler);
            $historique->setAttribute("type", "DEBIT"); // CREDIT ou DEBIT
            $historique->setAttribute("portefeuille_id", $dossier->getPortefeuille->id);
            $historique->setAttribute("created_by", $user->id);
            $historique->save();

            // update portefeuille
            $portefeuille = Portefeuilles::find($dossier->getPortefeuille->id);
            $new_montant = $portefeuille->montant - $request->get_montant_total_regler;
            $portefeuille->setAttribute("montant", $new_montant);
            $portefeuille->setAttribute("updated_at", Date("Y-m-d H:i:s"));
            $portefeuille->update(); 

            foreach ($data as $key =>  $echeancier_id) {
                # code...
                // enregistrement détails paiement
               // if ($montant_regle[$key] > 0) {
                    # code...

                    if (isset($montant_regle[$key]) && !empty($montant_regle[$key])) {
                        # code...
                $echeancier = Echeanciers::find($echeancier_id);
                $detail = new historiquepaiementecheanciers();
                $detail->setAttribute("paiement_id",$paiement->id);
                $detail->setAttribute("echeancier_id",$echeancier->id);
                $detail->setAttribute("montant_payer",$montant_regle[$key]);
                $detail->setAttribute("montant_restant",$montant_restant[$key]-$montant_regle[$key]);
                $detail->setAttribute("date_paiement",date("Y-m-d"));
                $detail->setAttribute("created_by",$user->id);
                $detail->setAttribute("updated_by",$user->id);
                $detail->save();
     
                // update echeancier
                //$echeancier->setAttribute("montant_payer",$montant_negocier[$key]);
                //$echeancier->setAttribute("remise",$remise[$key]);
                $echeancier->setAttribute("montant_restant",$montant_restant[$key]-$montant_regle[$key]);
                $echeancier->update();
                    }
                    
               // }
                
            }
 
            // valider dossier
            $statut_traitement = Statuttraitements::where("libelle", "VALIDE")->first();
            $dossier->setAttribute('statuttraitement_id', trim($statut_traitement->id));
            $dossier->setAttribute("date_traitement",date("Y-m-d"));
            $dossier->setAttribute("validateur_id",$user->id);
            $dossier->update();  
            $request->session()->put("redirect_uri", route("dossiers.valide"));
            return redirect()->route("info.impression-recu",$paiement->reference);
    }

}

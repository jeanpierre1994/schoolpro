<?php

namespace App\Http\Controllers;

use App\Models\Dossiers;
use App\Models\Echeanciers;
use App\Models\Etudiants;
use App\Models\historiquepaiementecheanciers;
use App\Models\Historiqueportefeuilles;
use App\Models\Paiements;
use App\Models\Portefeuilles;
use App\Models\Statuttraitements;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function crediterPortefeuille(Request $request)
    {
        $this->validate($request, [
            'montant' => 'required',
            'portefeuille_id' => 'required'
        ]);
        // enregistrement du paiement
        $user = auth()->user();
        $portefeuille = Portefeuilles::find($request->portefeuille_id);
        // check mode paiement

        if (!empty($request->modepaiement) && $request->modepaiement == "MoMo") {
            # code...
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
            $preuve = $request->preuve;

            if (!empty($preuve)) {
                # code... 
                $extension_preuve = $preuve->extension(); // getClientOriginalExtension();  
                $preuve_path = "preuve_" . date('Ymd-His') . '.' . $extension_preuve;
                $preuve->storeAs('preuve', $preuve_path, 'public');
            }

            // enregistrement du paiement
            $paiement = new Paiements();
            $paiement->setAttribute('reference', $reference_paiement);
            $paiement->setAttribute('montant_a_payer', $request->montant);
            $paiement->setAttribute('montant_paye', $request->montant);
            $paiement->setAttribute('statut_traitement', "ATTENTE");
            if (isset($_POST["mode_paiement"])) {
                # code...
                $paiement->setAttribute('mod_paiement', $request->modepaiement);
            }
            $paiement->setAttribute('preuve', $preuve_path);
            $paiement->setAttribute('enregistrer_par', $user->id);
            $paiement->save();
            // redirection sur le formulaire de paiement kkiapay
            return response()->json(['status' => 200, 'montant_portefeuille' => $portefeuille->montant, 'nom_client' => $portefeuille->getPersonne->nom . ' ' . $portefeuille->getPersonne->prenoms, 'reference' => $paiement->reference, 'kkiapay' => true]);
            //return redirect()->route("recharge-portefeuille-parent.kkiapay", ['id'=>$portefeuille->id,'reference'=>$paiement->reference]);
        } else {
            # code...
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
            $preuve = $request->preuve;

            if (!empty($preuve)) {
                # code... 
                $extension_preuve = $preuve->extension(); // getClientOriginalExtension();  
                $preuve_path = "preuve_" . date('Ymd-His') . '.' . $extension_preuve;
                $preuve->storeAs('preuve', $preuve_path, 'public');
            }

            // enregistrement du paiement
            $paiement = new Paiements();
            $paiement->setAttribute('reference', $reference_paiement);
            $paiement->setAttribute('montant_a_payer', $request->montant);
            $paiement->setAttribute('montant_paye', $request->montant);
            $paiement->setAttribute('statut_traitement', "VALIDE"); // à revoir 
            if (isset($_POST["mode_paiement"])) {
                # code...
                $paiement->setAttribute('mod_paiement', $request->modepaiement);
            }
            $paiement->setAttribute('preuve', $preuve_path);
            $paiement->setAttribute('enregistrer_par', $user->id);
            $paiement->save();

            // enregistrement historique paiement 
            $historique = new Historiqueportefeuilles();
            $historique->setAttribute("old_montant", $portefeuille->montant);
            $historique->setAttribute("new_montant", $request->montant);
            $historique->setAttribute("type", "CREDIT"); // CREDIT ou DEBIT
            $historique->setAttribute("portefeuille_id", $portefeuille->id);
            $historique->setAttribute("created_by", $user->id);
            $historique->save();

            // update portefeuille
            $new_montant = $portefeuille->montant + $request->montant;
            $portefeuille->setAttribute("montant", $new_montant);
            $portefeuille->setAttribute("updated_at", Date("Y-m-d H:i:s"));
            $portefeuille->update();
            return response()->json(['status' => 200, 'montant_portefeuille' => $portefeuille->montant, 'reference' => $paiement->reference, 'nom_client' => $portefeuille->getPersonne->nom . ' ' . $portefeuille->getPersonne->prenoms, 'kkiapay' => false]);
        }
    }

    public function paiementKkiapayStore(Request $request)
    {
        $this->validate($request, [
            'reference' => 'required',
            'id_transaction' => 'required',
            'portefeuille_id' => 'required'
        ]);
        $code = $request->id_transaction;
        $reference = $request->reference;

        // $statut_sandbox = env("KKIAPAY_SANDBOX");

        //if ($statut_sandbox) {
        $public_key = env("KKIAPAY_SANDBOX_PUBLIC_KEY");
        $private_key = env("KKIAPAY_SANDBOX_PRIVATE_KEY");
        $secret = env("KKIAPAY_SANDBOX_SECRET_KEY");
        /*} else {

            $public_key = env("KKIAPAY_LIVE_PUBLIC_KEY");
            $private_key = env("KKIAPAY_LIVE_PRIVATE_KEY");
            $secret = env("KKIAPAY_LIVE_SECRET_KEY");
        }*/


        //$kkiapay = new \Kkiapay\Kkiapay($public_key, $private_key, $secret, $sandbox=true);
        /*$kkiapay = new \Kkiapay\Kkiapay(
            $public_key,
            $private_key,
            $secret,
            $statut_sandbox
        );

        $frais_transaction = 0;
        $statut_transaction = $kkiapay->verifyTransaction($transactionId)->status;
*/
        // mise à jour de la table paiement
        $paiement = Paiements::where('reference', $reference)->get()->first();
        $paiement->setAttribute('num_transaction', $code);
        $paiement->setAttribute('statut_transaction', $code);
        $paiement->setAttribute('statut_traitement', "VALIDE"); // à revoir
        $paiement->setAttribute('updated_at', date('Y-m-d H:i:s'));
        $paiement->update();

        $portefeuille = Portefeuilles::find($request->portefeuille_id);
        $user = auth()->user();
        // enregistrement historique paiement 
        $historique = new Historiqueportefeuilles();
        $historique->setAttribute("old_montant", $portefeuille->montant);
        $historique->setAttribute("new_montant", $paiement->montant_paye);
        $historique->setAttribute("type", "CREDIT"); // CREDIT ou DEBIT
        $historique->setAttribute("portefeuille_id", $portefeuille->id);
        $historique->setAttribute("created_by", $user->id);
        $historique->save();

        // update portefeuille
        $new_montant = $portefeuille->montant + $paiement->montant_paye;
        $portefeuille->setAttribute("montant", $new_montant);
        $portefeuille->setAttribute("updated_at", Date("Y-m-d H:i:s"));
        $portefeuille->update();
        return response()->json(['status' => 200, 'montant_portefeuille' => $portefeuille->montant, 'reference' => $paiement->reference, 'nom_client' => $portefeuille->getPersonne->nom . ' ' . $portefeuille->getPersonne->prenoms, 'kkiapay' => false]);
        // redirection
        return redirect()->route("dossiers.en_attente")->with("success", "Opération effectuée avec succès.");
    }

    public function ventilationEcheancier(Request $request)
    {
        $user = auth()->user();
        $this->validate($request, [
            'get_montant_total_negocier' => 'required',
            'get_montant_total_regler' => 'required',
            'dossier_id' => 'required',
            'montant_portefeuille' => 'required',
            'remise' => 'required',
            'montant_negocier' => 'required',
            'montant_regle' => 'required',
            'echeancier_id' => 'required'
        ]);
        $dossier = Dossiers::find($request->dossier_id);
 
        // enregistrement historique paiement echeancier
        $data = $request->echeancier_id;
        $montant_negocier = $request->montant_negocier;
        $montant_regle = $request->montant_regle;
        $remise = $request->remise; 
        
 
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
                    $echeancier = Echeanciers::find($echeancier_id);
                $detail = new historiquepaiementecheanciers();
                $detail->setAttribute("paiement_id",$paiement->id);
                $detail->setAttribute("echeancier_id",$echeancier->id);
                $detail->setAttribute("montant_payer",$montant_regle[$key]);
                $detail->setAttribute("montant_restant",$montant_negocier[$key]-$montant_regle[$key]);
                $detail->setAttribute("date_paiement",date("Y-m-d"));
                $detail->setAttribute("created_by",$user->id);
                $detail->setAttribute("updated_by",$user->id);
                $detail->save();
     
                // update echeancier
                $echeancier->setAttribute("montant_payer",$montant_negocier[$key]);
                $echeancier->setAttribute("remise",$remise[$key]);
                $echeancier->setAttribute("montant_restant",$montant_negocier[$key]-$montant_regle[$key]);
                $echeancier->update();
               // }
                
            }


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
            $inscription->setAttribute('groupepedagogique_id', $dossier->groupepedagogique_id);
            $inscription->setAttribute("dossier_id", $dossier->id);
            $inscription->setAttribute("validateur_id", $user->id); 
            $inscription->setAttribute("commentaitaire", "RAS");
            $inscription->save();

            // valider dossier
            $statut_traitement = Statuttraitements::where("libelle", "VALIDE")->first();
            $dossier->setAttribute('statuttraitement_id', trim($statut_traitement->id));
            $dossier->setAttribute("date_traitement",date("Y-m-d"));
            $dossier->setAttribute("validateur_id",$user->id);
            $dossier->update();


            return redirect()->route("impression-recu",$paiement->reference);
    }
}

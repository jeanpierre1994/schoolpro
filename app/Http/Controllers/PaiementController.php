<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dossiers;
use App\Models\Etudiants;
use App\Models\Paiements;
use App\Models\Echeanciers;
use Illuminate\Http\Request;
use App\Models\Portefeuilles;
use Illuminate\Support\Facades\Date;
use App\Models\Historiqueportefeuilles;
use App\Models\historiquepaiementecheanciers;

class PaiementController extends Controller
{
    // choix des rubriques
    public function choixRubrique(Request $request, $id)
    {
        $dossier = Dossiers::find($id);
        $echeanciers = Echeanciers::where("dossier_id", $dossier->id)->where("active",true)->get();
        return view('backend.paiements.choix_rubrique', compact('dossier', 'echeanciers'));
    }

    // retrait rubrique
    public function retirerRubrique(Request $request, $id)
    {
        $echeancier = Echeanciers::find($id);
        $echeancier->setAttribute("active", false);
        $echeancier->update();
        return redirect()->route("paiements.choix_rubrique", $echeancier->dossier_id)->with("success", "Opération effectuée avec succès");
    }

    // retrait multiple rubriques
    public function retirerMultipleRubrique(Request $request)
    {
        $this->validate($request, [
            'choix_rubrique' => 'required',
            'dossier_id' => 'required'
        ]);

        foreach ($request->choixRubrique as $value) {
            # code...
            if (!empty($value)) {
                # code...
                dd($value);
            }
        }

        /*$echeancier = Echeanciers::find($id); 
        $echeancier->setAttribute("active",false);
        $echeancier->update();*/
        //return redirect()->route("paiements.choix_rubrique", $echeancier->dossier_id)->with("success","Opération effectuée avec succès"); 
    }

    public function rechargePortefeuille(Request $request)
    {
        $this->validate($request, [
            'montant' => 'required',
            'dossier_id' => 'required'
        ]);
        $etudiant = Etudiants::where("dossier_id", $request->dossier_id)->first();
        $user = auth()->user();
        $dossier = Dossiers::find($request->dossier_id);
        // check if paiement is momo
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
            $paiement->setAttribute('dossier_id', $dossier->id);
            if (isset($_POST["mode_paiement"])) {
                # code...
                $paiement->setAttribute('mod_paiement', $request->modepaiement);
            }
            $paiement->setAttribute('preuve', $preuve_path);
            $paiement->setAttribute('enregistrer_par', $user->id);
            $paiement->save();
            // redirection sur le formulaire de paiement kkiapay
            return redirect()->route("paiement-express.kkiapay", $paiement->reference);
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
            $paiement->setAttribute('dossier_id', $dossier->id);
            if (isset($_POST["mode_paiement"])) {
                # code...
                $paiement->setAttribute('mod_paiement', $request->modepaiement);
            }
            $paiement->setAttribute('preuve', $preuve_path);
            $paiement->setAttribute('enregistrer_par', $user->id);
            $paiement->save();

            // enregistrement historique paiement
            $portefeuille = Portefeuilles::find($dossier->portefeuille_id);
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

            // vérifier si le dossier de l'apprenant existe
            $checkEtudiant = Etudiants::where("dossier_id",$dossier->id)->exists();
            if (!$checkEtudiant) {
                # code...

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

                // update statut dossier
                $dossier->setAttribute("statuttraitement_id", 2);
                $dossier->setAttribute("validateur_id", $user->id);
                $dossier->setAttribute("date_traitement", Date("Y-m-d H:i:s"));
                $dossier->update();
            
            }

            // redirection 
            return redirect()->route("dossiers.valide")->with("success", "Opération effectuée avec succès.");
        }
    }

    public function paiementKkiapay($reference)
    {
        $paiement = Paiements::where('reference', $reference)->get()->first();
        return view('backend.paiements.paiement_kkiapay', compact('paiement'));
    }

    public function paiementKkiapayStore(Request $request, $reference, $code = null)
    {
        
        $code = $_GET['transaction_id'];
        $transactionId = $code;

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



            // vérifier si le dossier de l'apprenant existe
            $checkEtudiant = Etudiants::where("dossier_id",$paiement->dossier_id)->exists();
            if (!$checkEtudiant) {
                # code...

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
            $dossier = Dossiers::find($paiement->dossier_id);
            $user = auth()->user();
            // créer le compte étudiant
            $inscription = new Etudiants();
            $inscription->setAttribute("matricule", $matricule);
            $inscription->setAttribute('groupepedagogique_id', $dossier->groupepedagogique_id);
            $inscription->setAttribute("dossier_id", $dossier->id);
            $inscription->setAttribute("validateur_id", $user->id); 
            $inscription->setAttribute("commentaitaire", "RAS");
            $inscription->save();
            
            // update statut dossier
            $dossier->setAttribute("statuttraitement_id",2);
            $dossier->setAttribute("validateur_id",$user->id);
            $dossier->setAttribute("date_traitement",Date("Y-m-d H:i:s"));
            $dossier->update();
            }
        // redirection
        return redirect()->route("dossiers.en_attente")->with("success", "Opération effectuée avec succès.");
    }

    public function paiementKkiapayExpress($reference)
    {
        $paiement = Paiements::where('reference', $reference)->get()->first();
        return view('backend.paiements.paiement_express_kkiapay', compact('paiement'));
    }

    public function paiementKkiapayExpressStore(Request $request, $reference, $code = null)
    {
        $code = $_GET['transaction_id'];
        $transactionId = $code;

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
        $paiement->setAttribute('montant_paye', $paiement->montant_a_payer);
        $paiement->setAttribute('statut_traitement', "VALIDE"); // à revoir
        $paiement->setAttribute('updated_at', date('Y-m-d H:i:s'));
        $paiement->update();



            // vérifier si le dossier de l'apprenant existe
            $checkEtudiant = Etudiants::where("dossier_id",$paiement->dossier_id)->exists();
            if (!$checkEtudiant) {
                # code...

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
            $dossier = Dossiers::find($paiement->dossier_id);
            $user = auth()->user();
            // créer le compte étudiant
            $inscription = new Etudiants();
            $inscription->setAttribute("matricule", $matricule);
            $inscription->setAttribute('groupepedagogique_id', $dossier->groupepedagogique_id);
            $inscription->setAttribute("dossier_id", $dossier->id);
            $inscription->setAttribute("validateur_id", $user->id); 
            $inscription->setAttribute("commentaitaire", "RAS");
            $inscription->save();
            
            }

        $dossier = Dossiers::find($paiement->dossier_id); 
        $user = auth()->user(); 
        // enregistrement historique paiement
        $portefeuille = Portefeuilles::find($dossier->portefeuille_id);
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

        // update statut dossier
        $dossier->setAttribute("statuttraitement_id",2);
        $dossier->setAttribute("validateur_id",$user->id);
        $dossier->setAttribute("date_traitement",Date("Y-m-d H:i:s"));
        $dossier->update();

        // redirection 
        return redirect()->route("dossiers.valide")->with("success", "Opération effectuée avec succès.");


        // redirection
        // return redirect()->route("dossiers.valide")->with("success", "Opération effectuée avec succès.");


    }

    public function index()
    {
        $paiements = historiquepaiementecheanciers::all();
        return view('backend.paiements.index', compact('paiements'));
    }

    public function listePaiements($etudiantId)
    {
        $etudiantId = \Crypt::decrypt($etudiantId);
        $etudiant = Etudiants::find($etudiantId);

        $dossier = Dossiers::where('id', $etudiant->dossier_id)->get()->first();
        $echeanciers = Echeanciers::where("dossier_id",$etudiant->dossier_id)->get();

        return view('backend.paiements.list', compact('dossier',"echeanciers"));
    }

    public function historiquePaiements(Request $request)
    {  
        $echeanciers = Echeanciers::orderBy("id","desc")->get();

        return view('backend.paiements.historiques', compact("echeanciers"));
    }

    public function historiquePaiementsPortefeuilles(Request $request)
    {  
        $portefeuilles = Historiqueportefeuilles::where("type","CREDIT")->orderBy("id","desc")->get();
        $montant_total = Historiqueportefeuilles::sum("new_montant");
      

        return view('backend.paiements.historiques-portefeuilles', compact("portefeuilles","montant_total"));
    }
}

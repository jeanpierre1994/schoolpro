<?php

namespace App\Http\Controllers;

use App\Models\Cycles;
use App\Models\Dossiers;
use App\Models\Etablissements;
use App\Models\Etudiants;
use App\Models\Filieres;
use App\Models\Genres;
use App\Models\Groupepedagogiques;
use App\Models\Niveaux;
use App\Models\Paiements;
use App\Models\Personnes;
use App\Models\Poles;
use App\Models\Statuttraitements;
use App\Models\Typesponsors;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
        $genres = Genres::where("statut_id", 1)->get();
        return view("frontend.etudiants.edit_profil", compact("etudiant", "genres"));
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
            'etudiant_id' => 'required',

        ]);

        // vérifier si l'étudiant existe déjà
        $check_personne = Personnes::where("nom", $request->nom)->where("prenoms", $request->prenoms)->where("tel", $request->telephone)->where("email", $request->email)
            ->where("id", "!=", $request->etudiant_id)->exists();

        if ($check_personne) {
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
            $photo_path = "photo_" . date('Ymd-His') . '.' . $extension_picture;
            $picture->storeAs('photos', $photo_path, 'public');
        }


        // modification le compte de l'utilisateur 
        $personne = Personnes::find($request->etudiant_id);
        $compte_user = User::find($personne->compte_id);
        $name = $request->nom . " " . $request->prenoms;
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

        Alert::toast("Modification effectuée avec succès.", 'success');

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
        $dossiers = Dossiers::where("created_by", $user->id)->where("statuttraitement_id", "!=", 2)->get();
        return view("frontend.etudiants.dossiers", compact("etudiant", "dossiers"));
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

        return view("frontend.etudiants.new_dossier", compact("etudiant", "poles", "cycles", "etablissements", "poles", "cycles", "typesponsors"));
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
            'cycle_id' => 'required',
            'niveau_id' => 'required',
            'annee' => 'required',
            'typesponsor_id' => 'required',

        ]);

        // vérifier si le dossier existe déjà
        $check_dossier = Dossiers::where("personne_id", $request->etudiant_id)->where("site_id", $request->site_id)->where("pole_id", $request->pole_id)->where("filiere_id", $request->filiere_id)
            ->where("cycle_id", $request->cycle_id)->where("niveau_id", $request->niveau_id)
            ->where("typesponsor_id", $request->typesponsor_id)
            ->exists();

        if ($check_dossier) {
            // if categorie exist redirect to form with error message
            return redirect()->back()->with('error', "Ce dossier existe déjà.");
        }

        $user = Auth()->user();
        $statut_traitement = Statuttraitements::where("libelle", "EN ATTENTE")->first();

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
            $last_id = $last_numero->code;
        }

        if (!empty($last_id)) {
            //$str = "DS11111122"; 
            // delete DS
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
        $code_dossier = $indicatif . $numero_user_formatted . $annee_actuelle;

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

        Alert::toast("Enregistrement effectué avec succès.", 'success');

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
        return view("frontend.etudiants.inscriptions", compact("etudiant", "dossiers"));
    }


    // ********* enregistrement express des étudiants **************

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeEtudiant(Request $request)
    {
        $user = Auth()->user();
        $this->validate($request, [
            'nom' => 'required',
            'prenoms' => 'required',
            'telephone'  => 'required',
            'email'  => 'required',
            'profil_id'  => 'required',
            'genre_id'  => 'required',
            'gp_id'  => 'required',
            'annee'  => 'required',
            'sponsor_id'  => 'required',
            'password'  => 'required',
            'nationalite'  => 'required',            
        ]);

        // vérifier si l'étudiant existe déjà 
        $check_personne = Personnes::where("nom", $request->nom)->where("prenoms", $request->prenoms)->where("tel", $request->telephone)->where("email", $request->email)
            ->exists();

        if ($check_personne) {
            // if categorie exist redirect to form with error message
            return redirect()->back()->with('error', "Inscription déjà effectuée.");
        }

        // enregistrer le compte de l'utilisateur
        $compte_user = new User();
        $name = $request->nom . " " . $request->prenoms;
        $code_email =  sha1(time());
        $compte_user->setAttribute('name', trim($name));
        $compte_user->setAttribute('email', trim($request->email));
        $compte_user->setAttribute('password', Hash::make($request->password));
        $compte_user->setAttribute('enable', true); // activer le compte
        $compte_user->setAttribute('code_email', $code_email);
        $compte_user->setAttribute('profil_id', $request->profil_id); // profil etudiant 
        $compte_user->save();

        // enregistrement compte étudiant
        $personne = new Personnes();
        $personne->setAttribute('nom', trim($request->nom));
        $personne->setAttribute('prenoms', trim($request->prenoms));
        $personne->setAttribute('compte_id', $compte_user->id);
        $personne->setAttribute('genre', trim($request->genre_id));
        $personne->setAttribute('tel', trim($request->telephone));
        $personne->setAttribute('email', trim($request->email));
        $personne->setAttribute('created_by', $compte_user->id);
        $personne->setAttribute('updated_by', $compte_user->id);
        $personne->setAttribute('ddn', $request->ddn);
        $personne->setAttribute('nationalite', $request->nationalite);
        $personne->setAttribute('updated_by', $compte_user->id);
        $personne->setAttribute('statut_id', 1);
        $personne->save();


        // vérifier si le dossier existe déjà
        $gp = Groupepedagogiques::find($request->gp_id);

        $check_dossier = Dossiers::where("personne_id", $personne->id)->where("site_id", $gp->site_id)->where("pole_id", $gp->pole_id)->where("filiere_id", $gp->filiere_id)
            ->where("cycle_id", $gp->cycle_id)->where("niveau_id", $gp->niveau_id)
            ->where("typesponsor_id", $request->sponsor_id)
            ->exists();

        if ($check_dossier) {
            // if categorie exist redirect to form with error message
            return redirect()->back()->with('error', "Ce dossier existe déjà.");
        }

        $statut_traitement = Statuttraitements::where("libelle", "EN ATTENTE")->first();

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
            $last_id = $last_numero->code;
        }

        if (!empty($last_id)) {
            //$str = "DS11111122"; 
            // delete DS
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
        $code_dossier = $indicatif . $numero_user_formatted . $annee_actuelle;

        //################################### end générer le code  ###################

        $dossier = new Dossiers();
        $dossier->setAttribute('code', trim($code_dossier));
        $dossier->setAttribute('personne_id', trim($personne->id));
        $dossier->setAttribute('site_id', trim($gp->site_id));
        $dossier->setAttribute('pole_id', $gp->pole_id);
        $dossier->setAttribute('filiere_id', trim($gp->filiere_id));
        $dossier->setAttribute('cycle_id', trim($gp->cycle_id));
        $dossier->setAttribute('niveau_id', trim($gp->niveau_id));
        $dossier->setAttribute('annee', trim($request->annee));
        $dossier->setAttribute('typesponsor_id', trim($request->sponsor_id));
        $dossier->setAttribute('sponsor', trim($request->sponsor));
        $dossier->setAttribute('parent_created', false);
        $dossier->setAttribute('statuttraitement_id', trim($statut_traitement->id));
        $dossier->setAttribute('created_by', $user->id);
        $dossier->setAttribute('updated_by', $user->id);
        $dossier->save();

        // vérifier le choix parent 

        if ($request->ajout_parent == "2") { // choix parent
            # code... none
            if (!empty($request->choix_parent_id)) {
                # code...
                $personne->setAttribute("created_by", $request->choix_parent_id);
                $personne->setAttribute("famille", true);
                $personne->update();

                $dossier->setAttribute("created_by", $request->choix_parent_id);
                $dossier->update();
            }
        }

        if ($request->ajout_parent == "3") { // add parent
            # code... none
            if (!empty($request->nom_parent) && !empty($request->prenoms_parent) && !empty($request->telephone_parent) && !empty($request->email_parent) && !empty($request->genre_parent_id)) {
                # code...
                // vérifier si l'étudiant existe déjà 
                $check_personne = Personnes::where("nom", $request->nom_parent)->where("prenoms", $request->prenoms_parent)->where("tel", $request->telephone_parent)->where("email", $request->email_parent)
                    ->exists();

                if ($check_personne) {
                    // if categorie exist redirect to form with error message
                    // return redirect()->back()->with('error', "Inscription déjà effectuée.");
                } else {
                    // enregistrer le compte de l'utilisateur
                    $compte_parent = new User();
                    $name = $request->nom_parent . " " . $request->prenoms_parent;
                    $code_email =  sha1(time());
                    $compte_parent->setAttribute('name', trim($name));
                    $compte_parent->setAttribute('email', trim($request->email_parent));
                    $compte_parent->setAttribute('password', Hash::make("parent"));
                    $compte_parent->setAttribute('enable', true); // activer le compte
                    $compte_parent->setAttribute('code_email', $code_email);
                    $compte_parent->setAttribute('profil_id', 3); // profil etudiant 
                    $compte_parent->save();

                    // enregistrement compte étudiant
                    $parent = new Personnes();
                    $parent->setAttribute('nom', trim($request->nom_parent));
                    $parent->setAttribute('prenoms', trim($request->prenoms_parent));
                    $parent->setAttribute('compte_id', $compte_parent->id);
                    $parent->setAttribute('genre', trim($request->genre_parent_id));
                    $parent->setAttribute('tel', trim($request->telephone_parent));
                    $parent->setAttribute('email', trim($request->email_parent));
                    $parent->setAttribute('created_by', $compte_parent->id);
                    $parent->setAttribute('updated_by', $compte_parent->id);
                    $parent->setAttribute('statut_id', 1);
                    $parent->save();

                    $personne->setAttribute("created_by", $compte_parent->id);
                    $personne->setAttribute("famille", true);
                    $personne->update();

                    $dossier->setAttribute("created_by", $compte_parent->id);
                    $dossier->update();

                }
            }
        }
 
        // enregistrement des paiement
        if (isset($_POST["paiement"]) && $request->montant_payer > 0) {
            // création du compte de l'étudiant

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
            $inscription->setAttribute('groupepedagogique_id', $request->gp_id);
            $inscription->setAttribute("dossier_id", $dossier->id);
            $inscription->setAttribute("validateur_id", $user->id);
            if (!empty($request->montant_payer)) {
                # code... 
                $inscription->setAttribute("compte", $request->montant_payer);
            }
            $inscription->setAttribute("commentaitaire", $request->id);
            $inscription->save();

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

            $paiement->setAttribute('enregistrer_par', $user->id);
            $paiement->save();
            // redirection sur le formulaire de paiement kkiapay
            return redirect()->route("paiement-express.kkiapay",$paiement->reference);

        }

        return redirect()->route("dossiers.en_attente")->with("success", "Enregistrement effectuée avec succès.");
    }


     // ********* enregistrement express des dossier **************

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeDossierSansInscription(Request $request)
    {
        $user = Auth()->user();
        $this->validate($request, [
            'etudiant_id' => 'required', 
            'gp_id'  => 'required',
            'annee'  => 'required', 
        ]);

        // vérifier si l'étudiant existe déjà 
        $personne = Personnes::where("id", $request->etudiant_id)->first();

        if ($personne) { 
        }else{
            return redirect()->back()->with('error', "Le compte de l'étudiant n'existe pas.");
        }
  
        // vérifier si le dossier existe déjà
        $gp = Groupepedagogiques::find($request->gp_id);

        $check_dossier = Dossiers::where("personne_id", $personne->id)->where("site_id", $gp->site_id)->where("pole_id", $gp->pole_id)->where("filiere_id", $gp->filiere_id)
            ->where("cycle_id", $gp->cycle_id)->where("niveau_id", $gp->niveau_id) 
            ->exists();

        if ($check_dossier) {
            // if categorie exist redirect to form with error message
            return redirect()->back()->with('error', "Ce dossier existe déjà.");
        }

        $statut_traitement = Statuttraitements::where("libelle", "EN ATTENTE")->first();

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
            $last_id = $last_numero->code;
        }

        if (!empty($last_id)) {
            //$str = "DS11111122"; 
            // delete DS
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
        $code_dossier = $indicatif . $numero_user_formatted . $annee_actuelle;

        //################################### end générer le code  ###################

        $dossier = new Dossiers();
        $dossier->setAttribute('code', trim($code_dossier));
        $dossier->setAttribute('personne_id', trim($personne->id));
        $dossier->setAttribute('site_id', trim($gp->site_id));
        $dossier->setAttribute('pole_id', $gp->pole_id);
        $dossier->setAttribute('filiere_id', trim($gp->filiere_id));
        $dossier->setAttribute('cycle_id', trim($gp->cycle_id));
        $dossier->setAttribute('niveau_id', trim($gp->niveau_id));
        $dossier->setAttribute('annee', trim($request->annee));
        $dossier->setAttribute('typesponsor_id', 1);
        $dossier->setAttribute('sponsor', "");
        $dossier->setAttribute('parent_created', false);
        $dossier->setAttribute('statuttraitement_id', trim($statut_traitement->id));
        $dossier->setAttribute('created_by', $user->id);
        $dossier->setAttribute('updated_by', $user->id);
        $dossier->save();

        // vérifier le choix parent

        if ($request->ajout_parent == "1") {
            # code... none
        }

        if ($request->ajout_parent == "2") { // choix parent
            # code... none
            if (!empty($request->choix_parent_id)) {
                # code...
                $personne->setAttribute("created_by", $request->choix_parent_id);
                $personne->setAttribute("famille", true);
                $personne->update();

                $dossier->setAttribute("created_by", $request->choix_parent_id);
                $dossier->setAttribute('parent_created', true);
                $dossier->update();
            }
        }

        if ($request->ajout_parent == "3") { // add parent
            # code... none
            if (!empty($request->nom_parent) && !empty($request->prenoms_parent) && !empty($request->telephone_parent) && !empty($request->email_parent) && !empty($request->genre_parent_id)) {
                # code...
                // vérifier si l'étudiant existe déjà 
                $check_personne = Personnes::where("nom", $request->nom_parent)->where("prenoms", $request->prenoms_parent)->where("tel", $request->telephone_parent)->where("email", $request->email_parent)
                    ->exists();

                if ($check_personne) {
                    // if categorie exist redirect to form with error message
                    // return redirect()->back()->with('error', "Inscription déjà effectuée.");
                } else {
                    // enregistrer le compte de l'utilisateur
                    $compte_parent = new User();
                    $name = $request->nom_parent . " " . $request->prenoms_parent;
                    $code_email =  sha1(time());
                    $compte_parent->setAttribute('name', trim($name));
                    $compte_parent->setAttribute('email', trim($request->email_parent));
                    $compte_parent->setAttribute('password', Hash::make("parent"));
                    $compte_parent->setAttribute('enable', true); // activer le compte
                    $compte_parent->setAttribute('code_email', $code_email);
                    $compte_parent->setAttribute('profil_id', 3); // profil etudiant 
                    $compte_parent->save();

                    // enregistrement compte étudiant
                    $parent = new Personnes();
                    $parent->setAttribute('nom', trim($request->nom_parent));
                    $parent->setAttribute('prenoms', trim($request->prenoms_parent));
                    $parent->setAttribute('compte_id', $compte_parent->id);
                    $parent->setAttribute('genre', trim($request->genre_parent_id));
                    $parent->setAttribute('tel', trim($request->telephone_parent));
                    $parent->setAttribute('email', trim($request->email_parent));
                    $parent->setAttribute('created_by', $compte_parent->id);
                    $parent->setAttribute('updated_by', $compte_parent->id);
                    $parent->setAttribute('statut_id', 1);
                    $parent->save();

                    $personne->setAttribute("created_by", $compte_parent->id);
                    $personne->setAttribute("famille", true);
                    $personne->update();

                    $dossier->setAttribute("created_by", $compte_parent->id);
                    $dossier->setAttribute('parent_created', true);
                    $dossier->update();

                }
            }
        }
 
        // enregistrement des paiement
        if (isset($_POST["paiement"]) && $request->montant_payer > 0) {
            // création du compte de l'étudiant

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
            $inscription->setAttribute('groupepedagogique_id', $request->gp_id);
            $inscription->setAttribute("dossier_id", $dossier->id);
            $inscription->setAttribute("validateur_id", $user->id);
            if (!empty($request->montant_payer)) {
                # code... 
                $inscription->setAttribute("compte", $request->montant_payer);
            }
            $inscription->setAttribute("commentaitaire", $request->id);
            $inscription->save();

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

            $paiement->setAttribute('enregistrer_par', $user->id);
            $paiement->save();
            // redirection sur le formulaire de paiement kkiapay
            return redirect()->route("paiement-express.kkiapay",$paiement->reference);

        }


        return redirect()->route("dossiers.en_attente")->with("success", "Enregistrement effectuée avec succès.");
    }
}

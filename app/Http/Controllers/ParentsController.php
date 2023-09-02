<?php

namespace App\Http\Controllers;

use App\Models\Pays;
use App\Models\User;
use App\Models\Poles;
use App\Models\Cycles;
use App\Models\Genres;
use App\Models\Profil;
use App\Models\Parents;
use App\Models\Dossiers;
use App\Models\Personnes;
use App\Models\Typesponsors;
use Illuminate\Http\Request;
use App\Models\Etablissements;
use App\Models\Historiqueportefeuilles;
use App\Models\Paiements;
use App\Models\Portefeuilles;
use App\Models\Statuttraitements;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert as Alert;

class ParentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function identite()
    {
        $user = Auth()->user();
        $parent = Personnes::where("compte_id", $user->id)->first();
        return view("frontend.parents.identite", compact("parent"));
    }
    

     // editProfil
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function editProfil(Request $request, $id)
    {
        $parent = Personnes::find($id);
        $genres = Genres::where("statut_id",1)->get();
        return view("frontend.parents.edit_profil", compact("parent","genres"));
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
            'parent_id'=> 'required',  

        ]);

        // vérifier si l'étudiant existe déjà
        $check_personne = Personnes::where("nom",$request->nom)->where("prenoms",$request->prenoms)->where("tel",$request->telephone)->where("email",$request->email)
        ->where("id","!=",$request->parent_id)->exists();

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
        $personne = Personnes::find($request->parent_id);
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

        return redirect()->route("parent.identite");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function etudiants(Request $request)
    {
        $user = auth()->user(); 
        $etudiants = Personnes::where("created_by",$user->id)->where("famille",true)->get(); 
         return view("frontend.parents.etudiants", compact("etudiants"));
    }
 
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addEtudiant()
    { 
        $pays = Pays::orderBy("nom_pays","asc")->get();
        $paysNationalites = $pays->pluck('nationalite', 'nom_pays', 'code_iso');
        $genres = Genres::where("statut_id",1)->get(); 
        return view("frontend.parents.add_etudiant", compact("genres", 'paysNationalites', 'pays'));
    }

      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeEtudiant(Request $request)
    {
        $this->validate($request, [
            'nom' => 'required',
            'prenoms' => 'required',
            'telephone' => 'required',
            'email' => 'required',  
            'genre_id' => 'required', 
            'password' => 'required|min:3|confirmed',
            ]);
            // vérifier si l'étudiant existe déjà
            $check_personne = Personnes::where("nom",$request->nom)->where("prenoms",$request->prenoms)->where("tel",$request->telephone)->where("email",$request->email)
            ->exists();

            if($check_personne){
                // if categorie exist redirect to form with error message
                return redirect()->back()->with('error', "Inscription déjà effectuée.");
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
  
            // enregistrer le compte de l'utilisateur
            $compte_user = new User(); 
            $name = $request->nom." ".$request->prenoms; 
            $code_email =  sha1(time());
            $compte_user->setAttribute('name', trim($name));
            $compte_user->setAttribute('email', trim($request->email));
            $compte_user->setAttribute('password', Hash::make($request->password));
            $compte_user->setAttribute('enable', true); // activer le compte
            $compte_user->setAttribute('code_email', $code_email);
            $compte_user->setAttribute('profil_id', 2); // profil etudiant 
            $compte_user->save();

            $user = auth()->user();

            // enregistrement compte étudiant
            $personne = new Personnes();
            $personne->setAttribute('nom', trim($request->nom));
            $personne->setAttribute('prenoms', trim($request->prenoms));
            $personne->setAttribute('compte_id', $compte_user->id); 
            $personne->setAttribute('genre', trim($request->genre_id)); 
            $personne->setAttribute('tel', trim($request->telephone));
            $personne->setAttribute('email', trim($request->email)); 
            $personne->setAttribute('ddn', trim($request->ddn));    
            $personne->setAttribute('lieunais', trim($request->lieu_naissance));   
            $personne->setAttribute('nomjeunefille', trim($request->nom_jeune_fille));   
            $personne->setAttribute('adresse', trim($request->adresse)); 
            $personne->setAttribute('site_web', trim($request->site_web)); 
            $personne->setAttribute('lien_linkedin', trim($request->lien_linkedin)); 
            $personne->setAttribute('lien_github', trim($request->lien_github)); 
            $personne->setAttribute('lien_facebook', trim($request->lien_facebook));
            $personne->setAttribute('famille', true);   
            if (!empty($photo_path)) {
                # code...
                $personne->setAttribute('photo', trim($photo_path)); 
            }  
            $personne->setAttribute('created_by', $user->id); 
            $personne->setAttribute('updated_by', $user->id);
            $personne->setAttribute('statut_id', 1);
            $personne->save();

        Alert::toast("Enregistrement effectué avec succès.",'success');

        return redirect()->route("parent.etudiants");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function newDossier($id)
    {   
        $etudiant = Personnes::find($id);
        $etablissements = Etablissements::where("statut_id", 1)->get();
        $poles = Poles::where("statut_id", 1)->get();
        $cycles = Cycles::where("statut_id", 1)->get();  
        $typesponsors = Typesponsors::where("statut_id", 1)->get();  

        return view("frontend.parents.new_dossier", compact("etudiant","poles","cycles","etablissements","poles","cycles","typesponsors"));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeDossier(Request $request)
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
            $last_id = $last_numero->code;
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
        $dossier->setAttribute('parent_created', true);   
        $dossier->setAttribute('statuttraitement_id', trim($statut_traitement->id));  
        $dossier->setAttribute('created_by', $user->id); 
        $dossier->setAttribute('updated_by', $user->id); 
        $dossier->save();

        Alert::toast("Enregistrement effectué avec succès.",'success');

        return redirect()->route("parent.etudiants");
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
        return view("frontend.parents.dossiers", compact("etudiant","dossiers"));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function inscriptions()
    {
        $user = Auth()->user();
        $etudiant = Personnes::where("compte_id", $user->id)->first();
        $dossiers = Dossiers::where("created_by", $user->id)->where("statuttraitement_id", 2)->get();
        
        return view("frontend.parents.inscriptions", compact("etudiant","dossiers"));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function compte()
    {
        $user = Auth()->user();
        $portefeuille = Portefeuilles::where("created_by", $user->id)->first();
        $personne = Personnes::where("compte_id",$user->id)->first(); 
        // check if portefeuille is created 
        if ($portefeuille) {
            # code... nothing to do
        } else {
            # code... create acompte
            if ($personne) {
                # code... 
                $portefeuille = new Portefeuilles();
                $portefeuille->setAttribute("montant",0);
                $portefeuille->setAttribute("personne_id",$personne->id);
                $portefeuille->setAttribute("statut_id",1);
                $portefeuille->setAttribute("created_by",$user->id);
                $portefeuille->setAttribute("updated_by",$user->id);
                $portefeuille->save();
            } else {
                # code...
                Alert::toast("L'identifiant personne n'existe pas.",'error');
                return redirect()->back();
            }
            
        } 
        $historiques = Historiqueportefeuilles::where("portefeuille_id",$portefeuille->id)->get();
        
        return view("frontend.parents.portefeuille", compact("portefeuille","historiques","personne"));
    }

    // recharger portefeuille
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function rechargerPortefeuilleParent(Request $request)
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
            return redirect()->route("recharge-portefeuille-parent.kkiapay", ['id'=>$portefeuille->id,'reference'=>$paiement->reference]);
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

            // redirection 
            return redirect()->route("parent.compte")->with("success", "Opération effectuée avec succès.");
        }
    }

}

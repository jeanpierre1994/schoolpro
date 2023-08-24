<?php

namespace App\Http\Controllers;

use Closure;
use App\Models\User;
use App\Models\Sites;
use App\Models\Genres;
use App\Models\Profil;
use App\Models\Parents;
use App\Models\Personnes;
use Illuminate\Http\Request;
use App\Models\Lienparentals;
use App\Models\Etablissements;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert as Alert;
use Illuminate\Console\View\Components\Alert as ComponentsAlert;

class FrontendController extends Controller
{ 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request )
    {  
        return view("index");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function connexion(Request $request )
    {
        return view("login");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function inscription(Request $request )
    {
        // redirection sur le formulaire d'inscription
        //return view("frontend.inscriptions.choix_categorie");
            $genres = Genres::where("statut_id",1)->get();
            $profils = Profil::where("statut_id","=",1)->where("id","=",2)->orWhere("id","=",3)->get(); 
        return view("frontend.inscriptions.form", compact("genres","profils"));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request )
    { 
        //Enrégistrement de la categorie
        $this->validate($request, [
            'nom' => 'required',
            'prenoms' => 'required',
            'telephone' => 'required',
            'email' => 'required|unique:users,email|indisposable',
            'profil_id' => 'required', 
            'genre_id' => 'required', 
            'password' => 'required|min:3|confirmed',
            'g-recaptcha-response' => ['required', function (string $attribute, mixed $value, Closure $fail){
                $g_response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret' => config('services.recaptcha.secret_key'),
                    'response' =>$value,
                    'remoteip' => request()->ip()
                ]);

                if(!$g_response->json('success'))
                {
                    $fail("The {$attribute} is invalid");
                }

            }]
        ]);

        // vérifier si l'étudiant existe déjà
        $check_personne = Personnes::where("nom",$request->nom)->where("prenoms",$request->prenoms)->where("tel",$request->telephone)->where("email",$request->email)
        ->exists();

        if($check_personne){
           // if categorie exist redirect to form with error message
            return redirect()->back()->with('error', "Inscription déjà effectuée.");
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
        $compte_user->setAttribute('profil_id', $request->profil_id ); // profil etudiant 
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
        $personne->setAttribute('statut_id', 1);
        $personne->save();

        Alert::toast("Inscription effectuée avec succès.",'success');

        return redirect()->route("login");

    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function inscriptionForm(Request $request )
    { 
        
        if (isset($_POST['etudiant'])) {
            # code... 
            $genres = Genres::where("statut_id",1)->get();
            $etablissements = Etablissements::where("statut_id",1)->get(); 
            return view("frontend.inscriptions.etudiant",compact("genres","etablissements"));
        }else{ 
            $genres = Genres::where("statut_id",1)->get();
            return redirect()->route("profil");
            //return view("frontend.inscriptions.parent",compact("genres"));
        }
    } 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function inscriptionParentEtudiant(Request $request, $id)
    {  
        $parent = Parents::find($id);
        $lienparentals = Lienparentals::where("statut_id",1)->get();
        $genres = Genres::where("statut_id",1)->get();
        $etablissements = Etablissements::where("statut_id",1)->get(); 
        return view("frontend.inscriptions.parent_etudiant",compact("genres","etablissements","parent","lienparentals"));
    } 
 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeEtudiant(Request $request )
    { 
        //Enrégistrement de la categorie
        $this->validate($request, [
            'nom' => 'required',
            'prenoms' => 'required',
            'telephone' => 'required',
            'ddn' => 'required',
            'lieu_naissance' => 'required',
            'email' => 'required',
            'genre_id' => 'required',
            'nationalite_id' => 'required',
            'etablissement_id' => 'required',
            'site_id' => 'required',
            'password' => 'required',
        ]);

        // vérifier si l'étudiant existe déjà
        $check_personne = Personnes::where("nom",$request->nom)->where("prenoms",$request->prenoms)->where("tel",$request->telephone)->where("ddn",$request->ddn)->where("lieunais",$request->lieu_naissance)->where("email",$request->email)
        ->where("nationalite",$request->nationalite_id)->where("etablissement_id",$request->etablissement_id)->exists(); // nationalite_id

        if($check_personne){
           // if categorie exist redirect to form with error message
            return redirect()->back()->with('error', "L'étudiant existe déjà.");
        }

        // enregistrer le compte de l'utilisateur
        $compte_user = new User(); 
        $name = $request->nom." ".$request->prenoms;
        $profil = Profil::where("libelle","ETUDIANT")->first();
        $code_email =  sha1(time());
        $compte_user->setAttribute('name', trim($name));
        $compte_user->setAttribute('email', trim($request->email));
        $compte_user->setAttribute('password', Hash::make($request->password));
        $compte_user->setAttribute('enable', true); // activer le compte
        $compte_user->setAttribute('code_email', $code_email);
        $compte_user->setAttribute('profil_id', $profil->id ); // profil etudiant 
        $compte_user->save();

        // enregistrement compte étudiant
        $personne = new Personnes();
        $personne->setAttribute('nom', trim($request->nom));
        $personne->setAttribute('prenoms', trim($request->prenoms));
        $personne->setAttribute('compte_id', $compte_user->id);
        $personne->setAttribute('surnom', trim($request->surnom));
        $personne->setAttribute('nomjeunefille', trim($request->nom_jeune_fille));
        $personne->setAttribute('genre', trim($request->genre_id));
        $personne->setAttribute('ddn', trim($request->ddn));
        $personne->setAttribute('lieunais', trim($request->lieu_naissance));
        $personne->setAttribute('nationalite', trim($request->nationalite_id));
        $personne->setAttribute('tel', trim($request->telephone));
        $personne->setAttribute('email', trim($request->email));
        $personne->setAttribute('site_id', trim($request->site_id));
        $personne->setAttribute('etablissement_id', trim($request->etablissement_id));
        $personne->setAttribute('adresse', trim($request->adresse));
        $personne->setAttribute('famille', false); 
        $personne->setAttribute('created_by', $compte_user->id); 
        $personne->setAttribute('updated_by', $compte_user->id);
        $personne->setAttribute('statut_id', 1);
        $personne->save();

        Alert::toast("Inscription effectuée avec succès.",'success');

        return redirect()->route("index");

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeParent(Request $request )
    {
        //Enrégistrement de la categorie
        $this->validate($request, [
            'nom' => 'required',
            'prenoms' => 'required',
            'telephone' => 'required', 
            'email' => 'required',
            'genre_id' => 'required',
            'nationalite' => 'required', 
            'password' => 'required',
        ]);

        // vérifier si le parent existe déjà
        $check_parent = Personnes::where("nom",$request->nom)->where("prenoms",$request->prenoms)->where("tel",$request->telephone)->where("email",$request->email)
        ->where("nationalite",$request->nationalite)->exists(); 

        if($check_parent){ 
            return redirect()->back()->with('error', "Le parent existe déjà.");
        }

        // enregistrer le compte de l'utilisateur
        $compte_user = new User(); 
        $name = $request->nom." ".$request->prenoms;
        $profil = Profil::where("libelle","PARENT")->first();
        $code_email =  sha1(time());
        $compte_user->setAttribute('name', trim($name));
        $compte_user->setAttribute('email', trim($request->email));
        $compte_user->setAttribute('password', Hash::make($request->password));
        $compte_user->setAttribute('enable', true); // activer le compte
        $compte_user->setAttribute('code_email', $code_email);
        $compte_user->setAttribute('profil_id', $profil->id ); // profil etudiant 
        $compte_user->save();

        // enregistrement compte étudiant
        $personne = new Parents();
        $personne->setAttribute('nom', trim($request->nom));
        $personne->setAttribute('prenoms', trim($request->prenoms));
        $personne->setAttribute('compte_id', $compte_user->id); 
        $personne->setAttribute('genre', trim($request->genre_id)); 
        $personne->setAttribute('nationalite', trim($request->nationalite));
        $personne->setAttribute('tel', trim($request->telephone));
        $personne->setAttribute('email', trim($request->email));
        $personne->setAttribute('adresse', trim($request->adresse)); 
        $personne->setAttribute('created_by', $compte_user->id); 
        $personne->setAttribute('updated_by', $compte_user->id);
        $personne->setAttribute('statut_id', 1);
        $personne->save();

        Alert::toast("Inscription effectuée avec succès. Passez à l'étape suivante",'success');

        return redirect()->route("parent_etudiant",$personne->id);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeParentEtudiant(Request $request )
    { 
        //Enrégistrement de la categorie
        $this->validate($request, [
            'nom' => 'required',
            'prenoms' => 'required',
            'telephone' => 'required',
            'ddn' => 'required',
            'lieu_naissance' => 'required',
            'email' => 'required',
            'genre_id' => 'required',
            'nationalite_id' => 'required',
            'etablissement_id' => 'required',
            'site_id' => 'required',
            'password' => 'required',
            'lienparental_id' => 'required',
            'parent_id' => 'required'
        ]);

        // vérifier si l'étudiant existe déjà
        $check_personne = Personnes::where("nom",$request->nom)->where("prenoms",$request->prenoms)->where("tel",$request->telephone)->where("ddn",$request->ddn)->where("lieunais",$request->lieu_naissance)->where("email",$request->email)
        ->where("nationalite",$request->nationalite_id)->where("etablissement_id",$request->etablissement_id)->exists(); // nationalite_id

        if($check_personne){
           // if categorie exist redirect to form with error message
            return redirect()->back()->with('error', "L'étudiant existe déjà.");
        }

        // enregistrer le compte de l'utilisateur
        $compte_user = new User(); 
        $name = $request->nom." ".$request->prenoms;
        $profil = Profil::where("libelle","ETUDIANT")->first();
        $code_email =  sha1(time());
        $compte_user->setAttribute('name', trim($name));
        $compte_user->setAttribute('email', trim($request->email));
        $compte_user->setAttribute('password', Hash::make($request->password));
        $compte_user->setAttribute('enable', false); // activer le compte
        $compte_user->setAttribute('code_email', $code_email);
        $compte_user->setAttribute('profil_id', $profil->id ); // profil etudiant 
        $compte_user->save();

        // enregistrement compte étudiant

        // get parent id
        $get_parent = Parents::find($request->parent_id);
        $parent = User::find($get_parent->compte_id);
        $personne = new Personnes();
        $personne->setAttribute('nom', trim($request->nom));
        $personne->setAttribute('prenoms', trim($request->prenoms));
        $personne->setAttribute('compte_id', $compte_user->id);
        $personne->setAttribute('surnom', trim($request->surnom));
        $personne->setAttribute('nomjeunefille', trim($request->nom_jeune_fille));
        $personne->setAttribute('genre', trim($request->genre_id));
        $personne->setAttribute('ddn', trim($request->ddn));
        $personne->setAttribute('lieunais', trim($request->lieu_naissance));
        $personne->setAttribute('nationalite', trim($request->nationalite_id));
        $personne->setAttribute('tel', trim($request->telephone));
        $personne->setAttribute('email', trim($request->email));
        $personne->setAttribute('adresse', trim($request->adresse));
        $personne->setAttribute('site_id', trim($request->site_id));
        $personne->setAttribute('etablissement_id', trim($request->etablissement_id));
        $personne->setAttribute('famille', true); 
        $personne->setAttribute('lien_parental', $request->lienparental_id); 
        $personne->setAttribute('created_by', $parent->id); 
        $personne->setAttribute('updated_by', $parent->id);
        $personne->setAttribute('statut_id', 1);
        $personne->save();

        Alert::toast("Enregistrement effectué avec succès. Cliquez sur le bouton 'Terminer' si vous n'avez plus d'étudiant à déclarer.",'success');

        return redirect()->route("parent_etudiant",$request->parent_id);

    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function profil(Request $request )
    {
        $id = 10;
        $parent = Parents::find(2);
        $etudiants = Personnes::where("created_by",$id)->get(); 
        return view("frontend.inscriptions.profil", compact("etudiants","parent"));
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajouterEtudiant(Request $request )
    {
        $id = 2;
        $parent = Parents::find($id);
        $lienparentals = Lienparentals::where("statut_id",1)->get();
        $genres = Genres::where("statut_id",1)->get();
        $etablissements = Etablissements::where("statut_id",1)->get(); 
        return view("frontend.inscriptions.ajouter_etudiant",compact("genres","etablissements","parent","lienparentals"));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveEtudiant(Request $request )
    { 
        //Enrégistrement de la categorie
        $this->validate($request, [
            'nom' => 'required',
            'prenoms' => 'required',
            'telephone' => 'required',
            'ddn' => 'required',
            'lieu_naissance' => 'required',
            'email' => 'required',
            'genre_id' => 'required',
            'nationalite_id' => 'required',
            'etablissement_id' => 'required',
            'site_id' => 'required',
            'password' => 'required',
            'lienparental_id' => 'required',
            'parent_id' => 'required'
        ]);

        // vérifier si l'étudiant existe déjà
        $check_personne = Personnes::where("nom",$request->nom)->where("prenoms",$request->prenoms)->where("tel",$request->telephone)->where("ddn",$request->ddn)->where("lieunais",$request->lieu_naissance)->where("email",$request->email)
        ->where("nationalite",$request->nationalite_id)->where("etablissement_id",$request->etablissement_id)->exists(); // nationalite_id

        if($check_personne){
           // if categorie exist redirect to form with error message
            return redirect()->back()->with('error', "L'étudiant existe déjà.");
        }

        // enregistrer le compte de l'utilisateur
        $compte_user = new User(); 
        $name = $request->nom." ".$request->prenoms;
        $profil = Profil::where("libelle","ETUDIANT")->first();
        $code_email =  sha1(time());
        $compte_user->setAttribute('name', trim($name));
        $compte_user->setAttribute('email', trim($request->email));
        $compte_user->setAttribute('password', Hash::make($request->password));
        $compte_user->setAttribute('enable', false); // activer le compte
        $compte_user->setAttribute('code_email', $code_email);
        $compte_user->setAttribute('profil_id', $profil->id ); // profil etudiant 
        $compte_user->save();

        // enregistrement compte étudiant

        // get parent id
        $get_parent = Parents::find($request->parent_id);
        $parent = User::find($get_parent->compte_id);
        $personne = new Personnes();
        $personne->setAttribute('nom', trim($request->nom));
        $personne->setAttribute('prenoms', trim($request->prenoms));
        $personne->setAttribute('compte_id', $compte_user->id);
        $personne->setAttribute('surnom', trim($request->surnom));
        $personne->setAttribute('nomjeunefille', trim($request->nom_jeune_fille));
        $personne->setAttribute('genre', trim($request->genre_id));
        $personne->setAttribute('ddn', trim($request->ddn));
        $personne->setAttribute('site_id', trim($request->site_id));
        $personne->setAttribute('etablissement_id', trim($request->etablissement_id));
        $personne->setAttribute('lieunais', trim($request->lieu_naissance));
        $personne->setAttribute('nationalite', trim($request->nationalite_id));
        $personne->setAttribute('tel', trim($request->telephone));
        $personne->setAttribute('email', trim($request->email));
        $personne->setAttribute('adresse', trim($request->adresse));
        $personne->setAttribute('famille', true); 
        $personne->setAttribute('lien_parental', $request->lienparental_id); 
        $personne->setAttribute('created_by', $parent->id); 
        $personne->setAttribute('updated_by', $parent->id);
        $personne->setAttribute('statut_id', 1);
        $personne->save();

        Alert::toast("Enregistrement effectué avec succès. Cliquez sur le bouton 'Terminer' si vous n'avez plus d'étudiant à déclarer.",'success');

        return redirect()->route("profil");

    }
    
}

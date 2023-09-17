<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Poles;
use App\Models\Sites;
use App\Models\Cycles;
use App\Models\Genres;
use App\Models\Profil;
use App\Models\Examens;
use App\Models\Niveaux;
use App\Models\Statuts;
use App\Models\Dossiers;
use App\Models\Filieres;
use App\Models\Matieres;
use App\Models\Sections;
use App\Models\Categories;
use App\Models\Examentypes;
use App\Models\Typesponsors;
use Illuminate\Http\Request;
use App\Models\Etablissements;
use App\Models\Statutjuridiques;
use App\Models\Groupepedagogiques;
use App\Models\Matiereprofesseurs;
use App\Models\Sessioncorrections;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert as Alert; 

class AdminController extends Controller
{

     /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
   
     public function checkDashboard()
     { 
         if(Auth::check()){
            if(auth()->user()->profil_id == 2){ // etudiant
                return redirect()->route('dashboard_etudiant'); 
            }elseif(auth()->user()->profil_id == 3){ // parent
                return redirect()->route('dashboard_parent'); 
            }else{ // admin
                return redirect()->route('dashboard'); 
            } 
         }
         Alert::toast("Vous n'êtes pas autorisé à accéder.",'error');
         return redirect()->route('login');
     } 
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
   
    public function dashboard()
    {
        $nbre_genre = Genres::all()->count();
        $nbre_etablissement = Etablissements::all()->count();
        $nbre_site = Sites::all()->count();
        $nbre_profil = Profil::all()->count();
        $nbre_statut = Statuts::all()->count();
        $nbre_statutjuridique = Statutjuridiques::all()->count();
        $nbre_niveau = Niveaux::all()->count();
        $nbre_filiere = Filieres::all()->count();
        $nbre_cycle = Cycles::all()->count();
        $nbre_pole = Poles::all()->count();
        $nbre_genre = Genres::all()->count();
        $nbre_typesponsor = Typesponsors::all()->count();
        $nbre_gp = Groupepedagogiques::all()->count();
        $nbre_categorie = Categories::all()->count();
        $nbre_section = Sections::all()->count();
        $nbre_matiere = Matieres::all()->count();
        $nbre_examentype = Examentypes::all()->count();
        $nbre_examen = Examens::all()->count();
        $nbre_matiere_prof = Matiereprofesseurs::all()->count();
        $sessionCorrection = Sessioncorrections::all()->count();
        $profil_professeur = Profil::where("libelle","PROFESSEUR")->first();

        if ($profil_professeur) {
            # code...
            $nbre_professeur = User::where("profil_id",$profil_professeur->id)->count();
        } else {
            # code...
            $nbre_professeur = 0;
        } 
        $dossierEnAttente = Dossiers::where('statuttraitement_id', 1)->count(); 
        $dossierValide = Dossiers::where('statuttraitement_id', 2)->count(); 
        $dossierRejete = Dossiers::where('statuttraitement_id', 3)->count();
        if(Auth::check()){
            return view('backend.dashboard.dashboard', compact("nbre_categorie","nbre_gp","nbre_section", 'sessionCorrection','nbre_matiere_prof',"nbre_niveau","nbre_typesponsor","nbre_matiere", "nbre_genre", "nbre_filiere", "nbre_cycle", "nbre_pole", "nbre_statut", "nbre_genre","nbre_statutjuridique","dossierValide","nbre_profil","nbre_site","nbre_etablissement","nbre_examentype","nbre_examen","nbre_professeur", "dossierEnAttente"));
        }
        Alert::toast("Vous n'êtes pas autorisé à accéder.",'error');
        return redirect()->route('login');
    } 

    public function dashboardEtudiant()
    { 
        if(Auth::check()){
            if(auth()->user()->profil_id == 2){ 
                return view('frontend.dashboard.dashboard_etudiant');
            }else{ 
                Alert::toast("Vous n'êtes pas autorisé à accéder à cette page.",'error');
                return redirect()->route('logout');  
            } 
        }
        Alert::toast("Vous n'êtes pas autorisé à accéder à cette page.",'error');
        return redirect()->route('login');  
    } 

    public function dashboardParent()
    {
        $dossierEnAttente = Dossiers::where('statuttraitement_id', 1)->where('created_by', auth()->user()->id)->count(); 
        $dossierValide = Dossiers::where('statuttraitement_id', 2)->where('created_by', auth()->user()->id)->count(); 
        $dossierRejete = Dossiers::where('statuttraitement_id', 3)->where('created_by', auth()->user()->id)->count(); 
        if(Auth::check()){
            if(auth()->user()->profil_id == 3){ 
                return view('frontend.dashboard.dashboard_parent', compact('dossierRejete', 'dossierEnAttente', 'dossierValide'));
            }else{ 
                Alert::toast("Vous n'êtes pas autorisé à accéder à cette page.",'error');
                return redirect()->route('logout');  
            }
        }
        Alert::toast("Vous n'êtes pas autorisé à accéder à cette page.",'error');
        return redirect()->route('login');  
    } 


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function parametres(Request $request)
    { 
        $nbre_genre = Genres::all()->count();
        $nbre_etablissement = Etablissements::all()->count();
        $nbre_site = Sites::all()->count();
        $nbre_profil = Profil::all()->count();
        $nbre_statut = Statuts::all()->count();
        $nbre_statutjuridique = Statutjuridiques::all()->count();
        $nbre_niveau = Niveaux::all()->count();
        $nbre_filiere = Filieres::all()->count();
        $nbre_cycle = Cycles::all()->count();
        $nbre_pole = Poles::all()->count();
        $nbre_genre = Genres::all()->count();
        $nbre_typesponsor = Typesponsors::all()->count();
        $nbre_gp = Groupepedagogiques::all()->count();
        $nbre_categorie = Categories::all()->count();
        $nbre_section = Sections::all()->count();
        $nbre_matiere = Matieres::all()->count();
        $nbre_examentype = Examentypes::all()->count();
        $nbre_examen = Examens::all()->count();
        $nbre_matiere_prof = Matiereprofesseurs::all()->count();
        $sessionCorrection = Sessioncorrections::all()->count();
        $profil_professeur = Profil::where("libelle","PROFESSEUR")->first();
        if ($profil_professeur) {
            # code...
            $nbre_professeur = User::where("profil_id",$profil_professeur->id)->count();
        } else {
            # code...
            $nbre_professeur = 0;
        } 
        
        return view("backend.parametres",compact("nbre_categorie","nbre_gp","nbre_section", 'sessionCorrection','nbre_matiere_prof',"nbre_niveau","nbre_typesponsor","nbre_matiere", "nbre_genre", "nbre_filiere", "nbre_cycle", "nbre_pole", "nbre_statut", "nbre_genre","nbre_statutjuridique","nbre_profil","nbre_site","nbre_etablissement","nbre_examentype","nbre_examen","nbre_professeur"));
         
     }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxRequete(Request $request)
    {
        // get_matiere
        if (isset($_POST['get_matiere'])) { 
            $gp_id = $_POST['gp_id'];
            $matiere_professeur = Matiereprofesseurs::where("professeur_id",$request->professeur_id)->get(["id"]);
            $matieres = Matieres::whereNotIn('id', $matiere_professeur)->where('groupepedagogique_id', $gp_id)->where("statut_id",1)->get(["id","libelle"]);
            return json_encode($matieres,true);          
        }

         // récupérer la liste des communes par département
         if (isset($_POST['etablissement_id'])) { 
            $etablissement_id = $_POST['etablissement_id'];
            $sites = Sites::where('ets', $etablissement_id)->where("statut_id",1)->get(["id","sigle"]);
            return json_encode($sites,true);          
        }

        // récupérer la liste des filière par pole
        if (isset($_POST['pole_change'])) { 
            $pole_id = $_POST['pole_id'];
            $filieres = Filieres::where('pole_id', $pole_id)->where("statut_id",1)->get(["id","libelle"]);
            return json_encode($filieres,true);          
        }

        // récupérer la liste des niveau si filière change
        if (isset($_POST['filiere_change'])) { 
            $filiere_id = $_POST["filiere_id"]; 
            $cycles = DB::table("niveaux")
                ->join('cycles', 'cycles.id', '=', 'niveaux.cycle_id') 
                ->select('cycles.id', 'cycles.libelle')
                ->distinct()
                ->where('niveaux.filiere_id',$filiere_id) 
                ->get();
            //$niveaux = Niveaux::where('filiere_id', $filiere_id)->where('cycle_id', $cycle_id)->where("statut_id",1)->get(["id","libelle"]);
            return json_encode($cycles,true);          
        }

        // récupérer la liste des niveaux si cycle change
        if (isset($_POST['cycle_change'])) { 
            $filiere_id = $_POST["filiere_id"];
            $cycle_id = $_POST["cycle_id"];
            $niveaux = Niveaux::where('filiere_id', $filiere_id)->where('cycle_id', $cycle_id)->where("statut_id",1)->get(["id","libelle"]);
            return json_encode($niveaux,true);          
        }
       
    }


    /**
     *
     *@param  \Illuminate\Http\Request  $request
     *  
     * @return \Illuminate\Http\Response
     */
    public function newUpdate(Request $request, $id, $table, $statut)
    {
        // 
        $user = auth()->user();
        if ($statut == "activation") {
            # code... 
            $update_table = DB::table($table)->where('id', $id)
                ->update(['statut_id' => 1, 'updated_by' => $user->id, 'updated_at' => new \DateTime()]);
        } else {
            # code...
            $update_table = DB::table($table)->where('id', $id)
                ->update(['statut_id' => 2, 'updated_by' => $user->id, 'updated_at' => new \DateTime()]);
        }
        if ($update_table) {
            # code...
            return redirect()->back()->with('success', 'Opération bien effectuée');
        } else {
            # code...
            return redirect()->back()->with('error', 'Echec lors de traitement de la requête');
        }
    }

}

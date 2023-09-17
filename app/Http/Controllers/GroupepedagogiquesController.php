<?php

namespace App\Http\Controllers;

use App\Models\Cycles;
use App\Models\Etablissements;
use App\Models\Etudiants;
use App\Models\Examens;
use App\Models\Grilletarifaires;
use App\Models\Groupepedagogiques;
use App\Models\Matiereconfig;
use App\Models\Matiereprofesseurs;
use App\Models\Matieres;
use App\Models\Personnes;
use App\Models\Poles;
use App\Models\Profil;
use App\Models\Sections;
use App\Models\Typesponsors;
use Illuminate\Http\Request;

class GroupepedagogiquesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gp = Groupepedagogiques::orderBy("id", "desc")->get();
        return view("backend.groupepedagogiques.index", compact("gp"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { 
        $etablissements = Etablissements::where("statut_id", 1)->get();
        $poles = Poles::where("statut_id", 1)->get();
        $cycles = Cycles::where("statut_id", 1)->get();  
        $grilles = Grilletarifaires::all();
 
        return view("backend.groupepedagogiques.create", compact("grilles", "poles","cycles","etablissements"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [ 
            'etablissement_id' => 'required',
            'site_id' => 'required',
            'pole_id' => 'required', 
            'filiere_id' => 'required',  
            'cycle_id'=> 'required',  
            'niveau_id'=> 'required',   
            'libelle_classe'=> 'required', 
            'libelle_secondaire'=> 'required', 
            'grilletarifaire_id' => 'required'
        ]);

        // vérifier si le données existe déjà
        $check_data = Groupepedagogiques::where("libelle_classe",$request->libelle_classe)->where("libelle_secondaire",$request->libelle_secondaire)->where("site_id",$request->site_id)->where("pole_id",$request->pole_id)->where("filiere_id",$request->filiere_id)
        ->where("cycle_id",$request->cycle_id)->where("niveau_id",$request->niveau_id)
        ->where("pole_id",$request->pole_id)
        ->exists();

        if($check_data){
           // if categorie exist redirect to form with error message
            return redirect()->back()->with('error', "Ce groupe pédagogique existe déjà.");
        } 

        $user = Auth()->user(); 
 
         
        $gp = new Groupepedagogiques();    
        $gp->setAttribute('libelle_classe', trim($request->libelle_classe));
        $gp->setAttribute('libelle_secondaire', trim($request->libelle_secondaire));
        $gp->setAttribute('description_classe', trim($request->description_classe));
        $gp->setAttribute('site_id', trim($request->site_id));
        $gp->setAttribute('pole_id', $request->pole_id); 
        $gp->setAttribute('filiere_id', trim($request->filiere_id)); 
        $gp->setAttribute('cycle_id', trim($request->cycle_id));
        $gp->setAttribute('niveau_id', trim($request->niveau_id));  
        $gp->setAttribute('grilletarifaire_id', trim($request->grilletarifaire_id));  
        $gp->setAttribute('created_by', $user->id); 
        $gp->setAttribute('updated_by', $user->id); 
        $gp->save();
 
        return redirect()->route("groupepedagogiques.index") ->with('success', 'Enregistrement effectué avec succès');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Groupepedagogiques  $groupepedagogiques
     * @return \Illuminate\Http\Response
     */
    public function show(Groupepedagogiques $groupepedagogiques)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Groupepedagogiques  $groupepedagogiques
     * @return \Illuminate\Http\Response
     */
    public function edit(Groupepedagogiques $groupepedagogique)
    {
        $gp = $groupepedagogique;
        $etablissements = Etablissements::where("statut_id", 1)->get();
        $poles = Poles::where("statut_id", 1)->get();
        $cycles = Cycles::where("statut_id", 1)->get(); 
        $grilles = Grilletarifaires::all();
        return view("backend.groupepedagogiques.edit", compact("grilles", "poles","cycles","etablissements","gp"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Groupepedagogiques  $groupepedagogiques
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Groupepedagogiques $groupepedagogique)
    {
        $this->validate($request, [ 
            'etablissement_id' => 'required',
            'site_id' => 'required',
            'pole_id' => 'required', 
            'filiere_id' => 'required',  
            'cycle_id'=> 'required',  
            'niveau_id'=> 'required',   
            'libelle_classe'=> 'required', 
            'libelle_secondaire'=> 'required', 
            'grilletarifaire_id'=> 'required', 
        ]);

        // vérifier si le données existe déjà
        $check_data = Groupepedagogiques::where("libelle_classe",$request->libelle_classe)->where("libelle_secondaire",$request->libelle_secondaire)->where("site_id",$request->site_id)->where("pole_id",$request->pole_id)->where("filiere_id",$request->filiere_id)
        ->where("cycle_id",$request->cycle_id)->where("niveau_id",$request->niveau_id)
        ->where("pole_id",$request->pole_id)
        ->where("id","!=",$groupepedagogique->id)
        ->exists();

        if($check_data){
           // if categorie exist redirect to form with error message
            return redirect()->back()->with('error', "Ce groupe pédagogique existe déjà.");
        } 

        $user = Auth()->user(); 
 
           
        $groupepedagogique->setAttribute('libelle_classe', trim($request->libelle_classe));
        $groupepedagogique->setAttribute('libelle_secondaire', trim($request->libelle_secondaire));
        $groupepedagogique->setAttribute('description_classe', trim($request->description_classe));
        $groupepedagogique->setAttribute('site_id', trim($request->site_id));
        $groupepedagogique->setAttribute('pole_id', $request->pole_id); 
        $groupepedagogique->setAttribute('filiere_id', trim($request->filiere_id)); 
        $groupepedagogique->setAttribute('cycle_id', trim($request->cycle_id));
        $groupepedagogique->setAttribute('niveau_id', trim($request->niveau_id));   
        $groupepedagogique->setAttribute('updated_by', $user->id); 
        $groupepedagogique->setAttribute('grilletarifaire_id', $request->grilletarifaire_id); 
        $groupepedagogique->update();

        return redirect()->route("groupepedagogiques.index") ->with('success', 'Modification effectuée avec succès');

    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function association(Request $request)
    {
        $user = Auth()->user();  
        $gp = Groupepedagogiques::find($request->id);
        $matieres = Matieres::where("groupepedagogique_id",$gp->id)->get();
        $listeMatieres = Matiereconfig::orderBy("libelle","asc")->get();  
        $sections = Sections::where("statut_id", 1)->get();  
        $profil_professeur = Profil::where("libelle", "PROFESSEUR")->first();
        // généré l'association des matières au groupe pédagogique 
        if ($matieres->count() == 0) {
            # code...
            $listeM = Matiereconfig::all();
            foreach ($listeM as $data) {
                # code...
                $matiere = new Matieres();    
                $matiere->setAttribute('matiereconfig_id', $data->id);
                $matiere->setAttribute('libelle', $data->libelle); 
                $matiere->setAttribute('section_id', 1);
                $matiere->setAttribute('sigle', "N/A"); 
                $matiere->setAttribute('groupepedagogique_id', $gp->id); 
                $matiere->setAttribute('note_max', 20);
                $matiere->setAttribute('moyenne', 20);  
                $matiere->setAttribute('coef', 1);    
                $matiere->setAttribute('statut_id', 1); 
                $matiere->setAttribute('created_by', $user->id); 
                $matiere->setAttribute('updated_by', $user->id); 
                $matiere->save();
            }  
            
        }
        
        if ($profil_professeur) {
            # code...
            $professeurs = Personnes::join("users", "users.id", "=", "personnes.compte_id")
                ->join("genres", "genres.id", "=", "personnes.genre")
                ->where("users.profil_id", 4)
                ->select(["personnes.nom", "personnes.prenoms", "personnes.tel", "personnes.email", "personnes.updated_at", "genres.id as id_genre", "genres.libelle as libelle_genre", "personnes.id","personnes.compte_id"])
                ->get();
            //User::where("profil_id",$profil_professeur->id)->orderBy("id","desc")->get();
        } else {
            # code...
            $professeurs = null;
        }
        return view("backend.groupepedagogiques.association", compact("gp","matieres","listeMatieres","professeurs","sections"));
    }

    /**
     * Display the specified resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function associationStore(Request $request)
    {
        $this->validate($request, [
            'matiere_id'  => 'required',
            'section_id' => 'required',   
            'note_max'=> 'required',   
            'moyenne'=> 'required', 
            'coef' => 'required',
            'gp_id' => 'required'
        ]);

        $check_data = Matieres::where("matiereconfig_id",$request->matiere_id)->where("groupepedagogique_id",$request->gp_id)->where("section_id",$request->section_id)
        ->where("sigle",$request->sigle)->where("note_max",$request->note_max)
        ->where("moyenne",$request->moyenne)->where("coef",$request->coef)
        ->exists();

        if($check_data){
           // if categorie exist redirect to form with error message
            return redirect()->back()->with('error', "Cette matière existe déjà.");
        } 

        $user = Auth()->user();  
        $matiereconfig = Matiereconfig::find($request->matiere_id);
        $matiere = new Matieres();    
        $matiere->setAttribute('matiereconfig_id', $request->matiere_id);
        $matiere->setAttribute('libelle', $matiereconfig->libelle); 
        $matiere->setAttribute('section_id', trim($request->section_id));
        $matiere->setAttribute('sigle', "N/A");
        //$matiere->setAttribute('categorie_id', $request->categorie_id); 
        $matiere->setAttribute('groupepedagogique_id', trim($request->gp_id)); 
        $matiere->setAttribute('note_max', trim($request->note_max));
        $matiere->setAttribute('moyenne', trim($request->moyenne));  
        $matiere->setAttribute('coef', trim($request->coef));    
        $matiere->setAttribute('statut_id', 1); 
        $matiere->setAttribute('created_by', $user->id); 
        $matiere->setAttribute('updated_by', $user->id); 
        $matiere->save();

        // enregistrement des professeurs
        if(!empty($request->professeur_id)){
            $check_matiere = Matiereprofesseurs::where("matiere_id", $matiere->id)->where("professeur_id", $request->professeur_id)->exists();

            if ($check_matiere) {
                # code... 
            }else{
                $save_data = new Matiereprofesseurs();
                $save_data->setAttribute('matiere_id', $matiere->id);
                $save_data->setAttribute('professeur_id', $request->professeur_id);
                $save_data->setAttribute('statut_id', 1);
                $save_data->setAttribute('created_by', auth()->user()->id);
                $save_data->setAttribute('updated_by', auth()->user()->id);
                $save_data->save();
            } 

        }
        return redirect()->back()->with("success", "enregistrement effectué avec succès.");
    }
/**
     * Display the specified resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function updateMatiereProf(Request $request)
    {
        $this->validate($request, [
            'prof_matiere_id'  => 'required',  
        ]);
        if(isset($request->coef) || isset($request->moyenne) || isset($request->note_max) || isset($request->section_id))
        {
            $attributes = $request->validate([
                'coef' => 'numeric',
                'moyenne' => 'min:2|numeric',
                'note_max' => 'numeric',
                'section_id' => 'exists:sections,id'
            ]);
            $matiere = Matieres::find($request->prof_matiere_id);
            $matiere->setAttribute("coef",$request->coef);
            $matiere->setAttribute("moyenne",$request->moyenne);
            $matiere->setAttribute("note_max",$request->note_max);
            $matiere->setAttribute("section_id",$request->section_id);
            $matiere->update();
           // return redirect()->back()->with("success", "Opération effectuée avec succès.");

        }

        if ($request->professeur_id) {
            # code...
            $check_data = Matiereprofesseurs::where("matiere_id",$request->prof_matiere_id)->where("professeur_id",$request->professeur_id)->exists();
        if ($check_data) {
            # code...
            return redirect()->back()->with("error", "Le professeur est déjà associé à cette matière.");
        } else {
            # code...
            $check = Matiereprofesseurs::where("matiere_id",$request->prof_matiere_id)->exists();
            if ($check) {
                # code...
                $save_data = Matiereprofesseurs::where("matiere_id",$request->prof_matiere_id)->first();
                $save_data->setAttribute('matiere_id', $request->prof_matiere_id);
                $save_data->setAttribute('professeur_id', $request->professeur_id);
                $save_data->setAttribute('statut_id', 1);
                $save_data->setAttribute('created_by', auth()->user()->id);
                $save_data->setAttribute('updated_by', auth()->user()->id);
                $save_data->update();
            } else {
                # code...
                $save_data = new Matiereprofesseurs();
                $save_data->setAttribute('matiere_id', $request->prof_matiere_id);
                $save_data->setAttribute('professeur_id', $request->professeur_id);
                $save_data->setAttribute('statut_id', 1);
                $save_data->setAttribute('created_by', auth()->user()->id);
                $save_data->setAttribute('updated_by', auth()->user()->id);
                $save_data->save();
            } 
            
        } 

        }

        return redirect()->back()->with("success", "Opération effectuée avec succès.");

        
    }
    /**
     * Display the specified resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function deleteMatiereProf(Request $request)
    {
        $this->validate($request, [
            'matiere_delete_id'  => 'required',
            'delete_data' => 'required',    
            'gp_id' => 'required', 
        ]); 

        switch ($request->delete_data) {

            case 1:
                # code... delete only matiere
                $check_matiere = Matieres::find($request->matiere_delete_id);
                if ($check_matiere) {
                    # code... 
                    try {
                        //code...
                        $check_matiere->delete();
                    } catch (\Throwable $th) {
                        //throw $th;
                        return redirect()->back()->with("error", "Echec de la suppression, La matière est liée à un examen.");
                    }
                   
                } else {
                    # code...
                    return redirect()->back()->with("error", "Echec de la suppression, la matière n'existe pas.");
                }
                return redirect()->back()->with("success", "Opération effectuée avec succès.");
                break; 
            case 2:
                # code... delete only professeur 
                $check_matiere_prof = Matiereprofesseurs::where("matiere_id",$request->matiere_delete_id)->where("professeur_id",$request->prof_sup_id)->exists();
                if ($check_matiere_prof) {
                    # code...
                    $matiere_prof = Matiereprofesseurs::where("matiere_id",$request->matiere_delete_id)->where("professeur_id",$request->prof_sup_id)->first();
                   try {
                    //code...
                    $matiere_prof->delete();
                   } catch (\Throwable $th) {
                    //throw $th;
                    return redirect()->back()->with("error", "Echec de la suppression, L'entité est liée à une autre table.");
                   }
                } else {
                    # code...
                    return redirect()->back()->with("error", "Echec de la suppression, l'identifiant du professeur n'existe pas.");
                }                
                return redirect()->back()->with("success", "Opération effectuée avec succès.");
                break; 
            case 3:
                # code... delete only matiere and professeur 
                $config = Matieres::find($request->matiere_delete_id);
                $check_matiere_prof = Matiereprofesseurs::where("matiere_id",$request->matiere_delete_id)->where("professeur_id",$request->prof_sup_id)->exists();
                if ($check_matiere_prof) {
                    # code...
                    $matiere_prof = Matiereprofesseurs::where("matiere_id",$request->matiere_delete_id)->where("professeur_id",$request->prof_sup_id)->first();
                   try {
                    //code...
                    $matiere_prof->delete();
                   } catch (\Throwable $th) {
                    //throw $th;
                    return redirect()->back()->with("error", "Echec de la suppression, L'entité est liée à une autre table.");
                   }
                } 

                $check_matiere = Matieres::find($request->matiere_delete_id);
                if ($check_matiere) {
                    # code...
                    try {
                        //code...
                        $check_matiere->delete();
                    } catch (\Throwable $th) {
                        //throw $th;
                        return redirect()->back()->with("error", "Echec de la suppression, L'entité est liée à une autre table.");
                    }
                    
                } 
                return redirect()->back()->with("success", "Opération effectuée avec succès.");
                break;
            
            default:
                # code...
                return redirect()->back()->with("error", "Echec de la suppression, vous devez choisir une option.");
                break;
        }
 
    }


    public function deleteGpProf(Request $request)
    {
        $this->validate($request, [
            'matiere_delete_id'  => 'required',
            'delete_data' => 'required',    
            'gp_id' => 'required', 
        ]); 
        
        switch ($request->delete_data) {

            case 1:
                # code... delete only matiere
                $check_matiere = Matieres::where('groupepedagogique_id',$request->gp_id)->get()->first();
                if ($check_matiere) {
                    # code...
                    $check_matiere->delete();
                } else {
                    # code...
                    return redirect()->back()->with("error", "Echec de la suppression, la matière n'existe pas.");
                }
                return redirect()->back()->with("success", "Opération effectuée avec succès.");
                break; 
            case 2:
                # code... delete only professeur 
                $check_matiere_prof = Matiereprofesseurs::where("matiere_id",$request->matiere_delete_id)->where("professeur_id",$request->prof_sup_id)->exists();
                if ($check_matiere_prof) {
                    # code...
                    $matiere_prof = Matiereprofesseurs::where("matiere_id",$request->matiere_delete_id)->where("professeur_id",$request->prof_sup_id)->first();
                    $matiere_prof->delete();
                } else {
                    # code...
                    return redirect()->back()->with("error", "Echec de la suppression, l'identifiant du professeur n'existe pas.");
                }                
                return redirect()->back()->with("success", "Opération effectuée avec succès.");
                break; 
            case 3:
                # code... delete only matiere and professeur 
                $config = Matieres::find($request->matiere_delete_id);
                $check_matiere_prof = Matiereprofesseurs::where("matiere_id",$request->matiere_delete_id)->where("professeur_id",$request->prof_sup_id)->exists();
                if ($check_matiere_prof) {
                    # code...
                    $matiere_prof = Matiereprofesseurs::where("matiere_id",$request->matiere_delete_id)->where("professeur_id",$request->prof_sup_id)->first();
                    $matiere_prof->delete();
                } 

                $check_matiere = Matieres::where('groupepedagogique_id',$request->gp_id)->get()->first();
                if ($check_matiere) {
                    # code...
                    $check_matiere->delete();
                } 
                return redirect()->back()->with("success", "Opération effectuée avec succès.");
                break;
            
            default:
                # code...
                return redirect()->back()->with("error", "Echec de la suppression, vous devez choisir une option.");
                break;
        }
 
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listeEtudiant(Request $request, $id)
    {
        $etudiants = Etudiants::where("groupepedagogique_id",$id)->orderBy("matricule","asc")->get();
        $gp = Groupepedagogiques::find($id);
        return view("backend.groupepedagogiques.lise-etudiant", compact("etudiants","gp"));
    }

    // listeExamen

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listeExamen(Request $request, $id, $etudiant_id)
    {
        $etudiant = Etudiants::find($etudiant_id);
        $gp = Groupepedagogiques::find($id);
        $examens = Examens::all();
        return view("backend.groupepedagogiques.lise-examens", compact("etudiant","gp","examens"));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Groupepedagogiques  $groupepedagogiques
     * @return \Illuminate\Http\Response
     */
    public function destroy(Groupepedagogiques $groupepedagogiques)
    {
        //
    }
}

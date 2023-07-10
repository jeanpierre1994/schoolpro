<?php

namespace App\Http\Controllers;

use App\Models\Groupepedagogiques;
use App\Models\Matiereconfig;
use App\Models\Matiereprofesseurs;
use App\Models\Matieres;
use App\Models\Personnes;
use App\Models\Profil;
use App\Models\Sections;
use Illuminate\Http\Request;

class MatiereconfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $matiereconfigs = Matiereconfig::orderBy("id", "desc")->get();
        return view("backend.matiereconfigs.index", compact("matiereconfigs"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("backend.matiereconfigs.create");
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
            'libelle' => 'required',
            'libelle_secondaire'  => 'required',
            'sigle'  => 'required'
        ]);

        $check_matiere = Matiereconfig::where("libelle",$request->libelle)->where("libelle_secondaire",$request->libelle_secondaire)->where("sigle",$request->sigle)->exists();
        if ($check_matiere) {
            # code...
            return redirect()->back()->with("error","La matière existe déjà.");
        }
        $user = auth()->user();
        $user_id = $user->id;

        $matiereconfig = new Matiereconfig();
        $matiereconfig->setAttribute('libelle', $request->libelle);
        $matiereconfig->setAttribute('sigle', $request->sigle);
        $matiereconfig->setAttribute('libelle_secondaire', $request->libelle_secondaire);
        $matiereconfig->setAttribute('description', $request->description);
        $matiereconfig->setAttribute('created_by', $user_id);
        $matiereconfig->setAttribute('created_at', new \DateTime());
        $matiereconfig->setAttribute('updated_by', $user_id);
        $matiereconfig->setAttribute('statut_id', 1);
        $matiereconfig->save();

        return redirect()->route('matiereconfigs.index')
            ->with('success', 'Enregistrement effectué avec succès');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Matiereconfigs  $matiereconfig
     * @return \Illuminate\Http\Response
     */
    public function show(Matiereconfig $matiereconfig)
    { 
        $gp = Groupepedagogiques::orderBy("libelle_classe", "ASC")->get();
        $sections = Sections::where("statut_id", 1)->get();   
        $matiere_gp = Matieres::where("matiereconfig_id",$matiereconfig->id)->get();

        $profil_professeur = Profil::where("libelle", "PROFESSEUR")->first();
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
 
        return view("backend.matiereconfigs.show", compact("professeurs", "gp","sections","matiereconfig","matiere_gp"));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        // modification 
        $matiereconfig = Matiereconfig::where("id", $id)->get()->first();
        return view("backend.matiereconfigs.edit", compact("matiereconfig"));
    }



    /**
     * Display the specified resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function addGP(Request $request)
    {
        $this->validate($request, [
            'matiereconfig_id'  => 'required',
            'section_id' => 'required',   
            'note_max'=> 'required',   
            'moyenne'=> 'required', 
            'coef' => 'required',
            'gp_id' => 'required'
        ]);

        $check_data = Matieres::where("matiereconfig_id",$request->matiereconfig_id)->where("groupepedagogique_id",$request->gp_id)->where("section_id",$request->section_id)
        ->where("sigle",$request->sigle)->where("note_max",$request->note_max)
        ->where("moyenne",$request->moyenne)->where("coef",$request->coef)
        ->exists();

        if($check_data){
           // if categorie exist redirect to form with error message
            return redirect()->back()->with('error', "Cette matière existe déjà.");
        } 

        $user = Auth()->user();  
        $matiereconfig = Matiereconfig::find($request->matiereconfig_id);
        $matiere = new Matieres();    
        $matiere->setAttribute('matiereconfig_id', $request->matiereconfig_id);
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
        return redirect()->back()->with("enregistrement effectué avec succès.");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Matiereconfigd  $matiereconfig
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Matiereconfig $matiereconfig)
    {
        //update requete
        $this->validate($request, [
            'libelle'  => 'required',
            'libelle_secondaire'  => 'required',
            'sigle' => 'required'
        ]);

        // vérifier si le matiereconfig existe déjà 
        $check_matiere = Matiereconfig::where("libelle",$request->libelle)->where("libelle_secondaire",$request->libelle_secondaire)->where("sigle",$request->sigle)->where("id","!=",$matiereconfig->id)->exists();
        if ($check_matiere) {
            # code...
            return redirect()->back()->with("error","La matière existe déjà.");
        } 
        // get current user id
        $user = auth()->user(); 
        $matiereconfig->setAttribute('libelle', $request->libelle);
        $matiereconfig->setAttribute('sigle', $request->sigle);
        $matiereconfig->setAttribute('libelle_secondaire', $request->libelle_secondaire);
        $matiereconfig->setAttribute('description', $request->description);
        $matiereconfig->setAttribute('updated_at', new \DateTime());
        $matiereconfig->setAttribute('updated_by', $user->id);
        $matiereconfig->update(); 

        return redirect()->route('matiereconfigs.index')->with('success', 'Modification effectuée avec succès');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        try {
            $matiereconfig = Matiereconfig::find($id);
            //Récupérer le libelle de l'élément supprimé
            $value = $matiereconfig->libelle;
            $matiereconfig->delete();
            // get current user id
            $user = auth()->user(); 
            return redirect()->route('matiereconfigs.index')->with('success', 'Opération bien effectuéé');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with("error", "Vous ne pouvez pas supprimer cet élément à cause du contrôle d'intégrité.");
        }
    }
}

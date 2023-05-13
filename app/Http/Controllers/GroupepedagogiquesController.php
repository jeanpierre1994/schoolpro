<?php

namespace App\Http\Controllers;

use App\Models\Cycles;
use App\Models\Etablissements;
use App\Models\Groupepedagogiques;
use App\Models\Poles;
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
 
        return view("backend.groupepedagogiques.create", compact("poles","cycles","etablissements"));
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
    public function edit(Groupepedagogiques $groupepedagogiques)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Groupepedagogiques  $groupepedagogiques
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Groupepedagogiques $groupepedagogiques)
    {
        //
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

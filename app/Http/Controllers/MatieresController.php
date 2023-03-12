<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Groupepedagogiques;
use App\Models\Matieres;
use App\Models\Sections;
use Illuminate\Http\Request;

class MatieresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $matieres = Matieres::orderBy("id", "desc")->get();
        return view("backend.matieres.index", compact("matieres"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Categories::where("statut_id", 1)->get();
        $gp = Groupepedagogiques::orderBy("libelle_classe", "ASC")->get();
        $sections = Sections::where("statut_id", 1)->get();  
 
        return view("backend.matieres.create", compact("categories","gp","sections"));
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
            'gp_id' => 'required',
            'section_id' => 'required',
            'categorie_id' => 'required', 
            'libelle' => 'required',  
            'sigle'=> 'required',  
            'note_max'=> 'required',   
            'moyenne'=> 'required', 
            'coef' => 'required'
        ]);

        // vérifier si le données existe déjà
        $check_data = Matieres::where("libelle",$request->libelle)->where("groupepedagogique_id",$request->gp_id)->where("section_id",$request->section_id)->where("categorie_id",$request->categorie_id)
        ->where("sigle",$request->sigle)->where("note_max",$request->note_max)
        ->where("moyenne",$request->moyenne)->where("coef",$request->coef)
        ->exists();

        if($check_data){
           // if categorie exist redirect to form with error message
            return redirect()->back()->with('error', "Cette matière existe déjà.");
        } 

        $user = Auth()->user(); 
 
         
        $matiere = new Matieres();    
        $matiere->setAttribute('libelle', trim($request->libelle));
        $matiere->setAttribute('sigle', trim($request->sigle));
        $matiere->setAttribute('section_id', trim($request->section_id));
        $matiere->setAttribute('categorie_id', $request->categorie_id); 
        $matiere->setAttribute('groupepedagogique_id', trim($request->gp_id)); 
        $matiere->setAttribute('note_max', trim($request->note_max));
        $matiere->setAttribute('moyenne', trim($request->moyenne));  
        $matiere->setAttribute('coef', trim($request->coef));    
        $matiere->setAttribute('statut_id', 1); 
        $matiere->setAttribute('created_by', $user->id); 
        $matiere->setAttribute('updated_by', $user->id); 
        $matiere->save();
 
        return redirect()->route("matieres.index") ->with('success', 'Enregistrement effectué avec succès');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Matieres  $matieres
     * @return \Illuminate\Http\Response
     */
    public function show(Matieres $matieres)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Matieres  $matiere
     * @return \Illuminate\Http\Response
     */
    public function edit(Matieres $matiere)
    {
        $categories = Categories::where("statut_id", 1)->get();
        $gp = Groupepedagogiques::orderBy("libelle_classe", "ASC")->get();
        $sections = Sections::where("statut_id", 1)->get();  
 
        return view("backend.matieres.edit", compact("categories","gp","sections","matiere"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Matieres  $matiere
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Matieres $matiere)
    {
        $this->validate($request, [ 
            'gp_id' => 'required',
            'section_id' => 'required',
            'categorie_id' => 'required', 
            'libelle' => 'required',  
            'sigle'=> 'required',  
            'note_max'=> 'required',   
            'moyenne'=> 'required', 
            'coef' => 'required'
        ]);

        // vérifier si le données existe déjà
        $check_data = Matieres::where("libelle",$request->libelle)->where("groupepedagogique_id",$request->gp_id)->where("section_id",$request->section_id)->where("categorie_id",$request->categorie_id)
        ->where("sigle",$request->sigle)->where("note_max",$request->note_max)
        ->where("moyenne",$request->moyenne)->where("coef",$request->coef)->where("id","!=",$matiere->id)
        ->exists();

        if($check_data){
           // if categorie exist redirect to form with error message
            return redirect()->back()->with('error', "Cette matière existe déjà.");
        } 

        $user = Auth()->user(); 
      
        $matiere->setAttribute('libelle', trim($request->libelle));
        $matiere->setAttribute('sigle', trim($request->sigle));
        $matiere->setAttribute('section_id', trim($request->section_id));
        $matiere->setAttribute('categorie_id', $request->categorie_id); 
        $matiere->setAttribute('groupepedagogique_id', trim($request->gp_id)); 
        $matiere->setAttribute('note_max', trim($request->note_max));
        $matiere->setAttribute('moyenne', trim($request->moyenne));  
        $matiere->setAttribute('coef', trim($request->coef));   
        $matiere->setAttribute('updated_by', $user->id); 
        $matiere->setAttribute('updated_at', date("Y-m-d H:i:s"));
        $matiere->update();
 
        return redirect()->route("matieres.index") ->with('success', 'Modification effectuée avec succès');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Matieres  $matieres
     * @return \Illuminate\Http\Response
     */
    public function destroy(Matieres $matieres)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Filieres;
use App\Models\Poles;
use Illuminate\Http\Request;

class FilieresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filieres = Filieres::orderBy("id", "desc")->get();
        return view("backend.filieres.index", compact("filieres"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $poles = Poles::where("statut_id",1)->get();
        return view("backend.filieres.create", compact("poles"));
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
            'pole_id' => 'required',
            'libelle' => 'required', 
            'libelle_secondaire'  => 'required'
        ]);

        $user = auth()->user();
        $user_id = $user->id;

        // vérifier si l'établissement existe déjà

        $check_filiere = Filieres::where("libelle",$request->libelle)->where("pole_id",$request->pole_id)
        ->exists();

        if ($check_filiere) {
            # code...
            return redirect()->back()->with("error","La filière existe déjà");
        }

        $filiere = new Filieres();
        $filiere->setAttribute('pole_id', $request->pole_id); 
        $filiere->setAttribute('libelle', $request->libelle);  
        $filiere->setAttribute('libelle_secondaire', $request->libelle_secondaire);  
        $filiere->setAttribute('description', $request->description); 
        $filiere->setAttribute('created_by', $user_id);
        $filiere->setAttribute('created_at', new \DateTime());
        $filiere->setAttribute('updated_by', $user_id);
        $filiere->setAttribute('statut_id', 1);
        $filiere->save();

        return redirect()->route('filieres.index')
            ->with('success', 'Enregistrement effectué avec succès');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Filieres  $filieres
     * @return \Illuminate\Http\Response
     */
    public function show(Filieres $filieres)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $poles = Poles::where("statut_id",1)->get();
        $filiere = Filieres::find($id);
        return view("backend.filieres.edit",compact("poles","filiere"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Filieres  $filiere
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Filieres $filiere)
    {
        $this->validate($request, [
            'pole_id' => 'required', 
            'libelle' => 'required',  
            'libelle_secondaire'  => 'required'
        ]);

        $user = auth()->user();
        $user_id = $user->id;

        // vérifier si la filière existe déjà

        $check_filiere = Filieres::where("pole_id",$request->pole_id)
        ->where("libelle",$request->libelle) 
        ->where("id","!=",$filiere->id)->exists();

        if ($check_filiere) {
            # code...
            return redirect()->back()->with("error","La filière existe déjà");
        }
 
        $filiere->setAttribute('pole_id', $request->pole_id); 
        $filiere->setAttribute('libelle', $request->libelle); 
        $filiere->setAttribute('description', $request->description);
        $filiere->setAttribute('libelle_secondaire', $request->libelle_secondaire);  
        $filiere->setAttribute('updated_at', new \DateTime());
        $filiere->setAttribute('updated_by', $user_id);
        $filiere->update();

        return redirect()->route('filieres.index')
            ->with('success', 'Modification effectuée avec succès');
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
            $filiere = Filieres::find($id);
            //Récupérer l'élément supprimé
            $value = $filiere->libelle;
            $filiere->delete();
            // get current user id
            $user = auth()->user(); 
            return redirect()->route('filieres.index')->with('success', 'Opération bien effectuée');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with("error", "Vous ne pouvez pas supprimer cet élément à cause du contrôle d'intégrité.");
        }
    }
}

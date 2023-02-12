<?php

namespace App\Http\Controllers;

use App\Models\Cycles;
use App\Models\Filieres;
use App\Models\Niveaux;
use Illuminate\Http\Request;

class NiveauxController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $niveaux = Niveaux::orderBy("id", "desc")->get();
        return view("backend.niveaux.index", compact("niveaux"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $filieres = Filieres::where("statut_id",1)->get();
        $cycles = Cycles::where("statut_id",1)->get();
        return view("backend.niveaux.create", compact("cycles","filieres"));
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
            'filiere_id' => 'required',
            'cycle_id' => 'required',
            'libelle' => 'required', 
        ]);

        $user = auth()->user();
        $user_id = $user->id;

        // vérifier si l'établissement existe déjà

        $check_niveau = Niveaux::where("libelle",$request->libelle)->where("filiere_id",$request->filiere_id)->where("cycle_id",$request->cycle_id)
        ->exists();

        if ($check_niveau) {
            # code...
            return redirect()->back()->with("error","Le niveau existe déjà");
        }

        $niveau = new Niveaux();
        $niveau->setAttribute('filiere_id', $request->filiere_id); 
        $niveau->setAttribute('cycle_id', $request->cycle_id); 
        $niveau->setAttribute('libelle', $request->libelle);  
        $niveau->setAttribute('description', $request->description); 
        $niveau->setAttribute('created_by', $user_id);
        $niveau->setAttribute('created_at', new \DateTime());
        $niveau->setAttribute('updated_by', $user_id);
        $niveau->setAttribute('statut_id', 1);
        $niveau->save();

        return redirect()->route('niveaux.index')
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
        $filieres = Filieres::where("statut_id",1)->get();
        $cycles = Cycles::where("statut_id",1)->get();
        $niveau = Niveaux::find($id);
        return view("backend.niveaux.edit",compact("filieres","cycles","niveau"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Niveaux  $niveau
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Niveaux $niveau)
    {
        $this->validate($request, [
            'filiere_id' => 'required', 
            'cycle_id' => 'required', 
            'libelle' => 'required',  
        ]);

        $user = auth()->user();
        $user_id = $user->id;

        // vérifier si la filière existe déjà

        $check_niveau = Niveaux::where("libelle",$request->libelle)->where("filiere_id",$request->filiere_id)->where("cycle_id",$request->cycle_id)
        ->where("id","!=",$niveau->id)->exists();

        if ($check_niveau) {
            # code...
            return redirect()->back()->with("error","Le niveau existe déjà");
        }
 
        $niveau->setAttribute('filiere_id', $request->filiere_id); 
        $niveau->setAttribute('cycle_id', $request->cycle_id); 
        $niveau->setAttribute('libelle', $request->libelle); 
        $niveau->setAttribute('updated_at', new \DateTime());
        $niveau->setAttribute('updated_by', $user_id);
        $niveau->update();

        return redirect()->route('niveaux.index')
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
            $niveau = Niveaux::find($id);
            //Récupérer l'élément supprimé
            $value = $niveau->libelle;
            $niveau->delete();
            // get current user id
            $user = auth()->user(); 
            return redirect()->route('niveaus.index')->with('success', 'Opération bien effectuée');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with("error", "Vous ne pouvez pas supprimer cet élément à cause du contrôle d'intégrité.");
        }
    }
}

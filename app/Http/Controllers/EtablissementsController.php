<?php

namespace App\Http\Controllers;

use App\Models\Etablissements;
use App\Models\Statutjuridiques;
use Illuminate\Http\Request;

class EtablissementsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $etablissements = Etablissements::orderBy("id", "desc")->get();
        return view("backend.etablissements.index", compact("etablissements"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statutjuridiques = Statutjuridiques::where("statut_id",1)->get();
        return view("backend.etablissements.create", compact("statutjuridiques"));
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
            'sigle' => 'required',
            'description' => 'required',
            'telephone' => 'required',
            'ifu' => 'required',
            'statutjuridique_id' => 'required',
            'dirigeant' => 'required',
            'adresse' => 'required',
        ]);

        $user = auth()->user();
        $user_id = $user->id;

        // vérifier si l'établissement existe déjà

        $check_etablissement = Etablissements::where("sigle",$request->sigle)->where("description",$request->description)
        ->where("telephone",$request->telephone)->where("ifu",$request->ifu)->where("statutjuridique_id",$request->statutjuridique_id)
        ->where("dirigeant",$request->dirigeant)->where("adresse",$request->adresse)->exists();

        if ($check_etablissement) {
            # code...
            return redirect()->back()->with("error","L'établissement existe déjà");
        }

        $etablissement = new Etablissements();
        $etablissement->setAttribute('sigle', $request->sigle);
        $etablissement->setAttribute('description', $request->description);
        $etablissement->setAttribute('telephone', $request->telephone);
        $etablissement->setAttribute('ifu', $request->ifu);
        $etablissement->setAttribute('statutjuridique_id', $request->statutjuridique_id);
        $etablissement->setAttribute('dirigeant', $request->dirigeant);
        $etablissement->setAttribute('adresse', $request->adresse);
        $etablissement->setAttribute('created_by', $user_id);
        $etablissement->setAttribute('created_at', new \DateTime());
        $etablissement->setAttribute('updated_by', $user_id);
        $etablissement->setAttribute('statut_id', 1);
        $etablissement->save();

        return redirect()->route('etablissements.index')
            ->with('success', 'Enregistrement effectué avec succès');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Etablissements  $etablissements
     * @return \Illuminate\Http\Response
     */
    public function show(Etablissements $etablissements)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $statutjuridiques = Statutjuridiques::where("statut_id",1)->get();
        $etablissement = Etablissements::find($id);
        return view("backend.etablissements.edit",compact("statutjuridiques","etablissement"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Etablissements  $etablissement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Etablissements $etablissement)
    {
        $this->validate($request, [
            'sigle' => 'required',
            'description' => 'required',
            'telephone' => 'required',
            'ifu' => 'required',
            'statutjuridique_id' => 'required',
            'dirigeant' => 'required',
            'adresse' => 'required',
        ]);

        $user = auth()->user();
        $user_id = $user->id;

        // vérifier si l'établissement existe déjà

        $check_etablissement = Etablissements::where("sigle",$request->sigle)->where("description",$request->description)
        ->where("telephone",$request->telephone)->where("ifu",$request->ifu)->where("statutjuridique_id",$request->statutjuridique_id)
        ->where("dirigeant",$request->dirigeant)->where("adresse",$request->adresse)
        ->where("id","!=",$etablissement->id)->exists();

        if ($check_etablissement) {
            # code...
            return redirect()->back()->with("error","L'établissement existe déjà");
        }
 
        $etablissement->setAttribute('sigle', $request->sigle);
        $etablissement->setAttribute('description', $request->description);
        $etablissement->setAttribute('telephone', $request->telephone);
        $etablissement->setAttribute('ifu', $request->ifu);
        $etablissement->setAttribute('statutjuridique_id', $request->statutjuridique_id);
        $etablissement->setAttribute('dirigeant', $request->dirigeant);
        $etablissement->setAttribute('adresse', $request->adresse); 
        $etablissement->setAttribute('updated_at', new \DateTime());
        $etablissement->setAttribute('updated_by', $user_id);
        $etablissement->update();

        return redirect()->route('etablissements.index')
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
            $etablissement = Etablissements::find($id);
            //Récupérer le sigle de l'élément supprimé
            $value = $etablissement->sigle;
            $etablissement->delete();
            // get current user id
            $user = auth()->user(); 
            return redirect()->route('etablissements.index')->with('success', 'Opération bien effectuéé');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with("error", "Vous ne pouvez pas supprimer cet élément à cause du contrôle d'intégrité.");
        }
    }
}

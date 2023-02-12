<?php

namespace App\Http\Controllers;

use App\Models\Statutjuridiques;
use Illuminate\Http\Request;

class StatutjuridiquesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Liste des statuts
        $statutjuridiques = Statutjuridiques::orderBy("id", "desc")->get();
        return view("backend.statutjuridiques.index", compact("statutjuridiques"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("backend.statutjuridiques.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Enrégistrements du statuts
        $this->validate($request, [
            'libelle' => 'required|unique:statutjuridiques,libelle'
        ]);

        $user = auth()->user();
        $user_id = $user->id;

        $statutjuridique = new Statutjuridiques();
        $statutjuridique->setAttribute('libelle', $request->libelle);
        $statutjuridique->setAttribute('description', $request->description);
        $statutjuridique->setAttribute('created_by', $user_id);
        $statutjuridique->setAttribute('created_at', new \DateTime());
        $statutjuridique->setAttribute('updated_by', $user_id);
        $statutjuridique->setAttribute('statut_id', 1);
        $statutjuridique->save();

        return redirect()->route('statutjuridiques.index')
            ->with('success', 'Enregistrement effectué avec succès');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Statutjuridiques  $statutjuridiques
     * @return \Illuminate\Http\Response
     */
    public function show(Statutjuridiques $statutjuridiques)
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
        // modification 
        $statutjuridique = Statutjuridiques::where("id", $id)->get()->first();
        return view("backend.statutjuridiques.edit", compact("statutjuridique"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Statutjuridiques  $statutjuridique
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Statutjuridiques $statutjuridique)
    {
        //update requete
        $this->validate($request, [

            'libelle'  => [
                'required',
                \Illuminate\Validation\Rule::unique('statutjuridiques')->where(function ($query) use ($request, $statutjuridique) {
                    return $query
                        ->whereLibelle($request->libelle)
                        ->whereNotIn('libelle', [$statutjuridique->libelle]);
                }),
            ]

        ]);
        // get current user id
        $user = auth()->user(); 
        $statutjuridique->setAttribute('libelle', $request->libelle);
        $statutjuridique->setAttribute('description', $request->description);
        $statutjuridique->setAttribute('updated_at', new \DateTime());
        $statutjuridique->setAttribute('updated_by', $user->id);
        $statutjuridique->update(); 

        return redirect()->route('statutjuridiques.index')->with('success', 'Modification effectuée avec succès');
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
            $statutjuridique = Statutjuridiques::find($id);
            //Récupérer le libelle de l'élément supprimé
            $value = $statutjuridique->libelle;
            $statutjuridique->delete();
            // get current user id
            $user = auth()->user(); 
            return redirect()->route('statutjuridiques.index')->with('success', 'Opération bien effectuéé');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with("error", "Vous ne pouvez pas supprimer cet élément à cause du contrôle d'intégrité.");
        }
    }
}

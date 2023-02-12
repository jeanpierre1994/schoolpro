<?php

namespace App\Http\Controllers;

use App\Models\Statuts;
use Illuminate\Http\Request;

class StatutsController extends Controller
{  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        //Liste des statuts
        $statuts = Statuts::orderBy("id", "desc")->get();
        return view("backend.statuts.index", compact("statuts"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Formulaire d'ajout d'un statut
        return view("backend.statuts.create");
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

            'libelle' => 'required|unique:statuts,libelle'

        ]);
        $user = auth()->user();
        $user_id = $user->id;

        $statut = new Statuts();
        $statut->setAttribute('libelle', $request->libelle);
        $statut->setAttribute('description', $request->description);
        $statut->setAttribute('created_by', $user_id);
        $statut->setAttribute('created_at', new \DateTime());
        $statut->setAttribute('updated_by', $user_id);
        $statut->save(); 
        
        return redirect()->route('statuts.index')
            ->with('success', 'Enregistrement effectué avec succès');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        // get records
        $statut = Statuts::where("id", $id)->get()->first();
        return view("backend.statuts.show", compact("statut"));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        // get records
        $statut = Statuts::where("id", $id)->get()->first();
        return view("backend.statuts.edit", compact("statut"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Statuts $statut)
    {

        //update requete
        $this->validate($request, [

            'libelle'  => [
                'required',
                \Illuminate\Validation\Rule::unique('statuts')->where(function ($query) use ($request, $statut) {
                    return $query
                        ->whereLibelle($request->libelle)
                        ->whereNotIn('libelle', [$statut->libelle]);
                }),
            ]

        ]);
        // get current user id
        $user = auth()->user();
        $statut = Statuts::find($statut->id);
        $statut->setAttribute('libelle', $request->libelle);
        $statut->setAttribute('description', $request->description);
        $statut->setAttribute('updated_at', new \DateTime());
        $statut->setAttribute('updated_by', $user->id);
        $statut->update(); 

        return redirect()->route('statuts.index')->with('success', 'Modification effectuée avec succès');
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
            $statut = Statuts::find($id);
            //Récupérer le libelle de l'élément supprimé
            $value = $statut->libelle;
            $statut->delete();
            // get current user id
            $user = auth()->user(); 
            return redirect()->route('statuts.index')->with('success', 'Opération bien effectuéé');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with("error", "Vous ne pouvez pas supprimer cet élément à cause du contrôle d'intégrité.");
        }
    }
}

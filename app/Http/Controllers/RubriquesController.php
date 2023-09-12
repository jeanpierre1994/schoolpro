<?php

namespace App\Http\Controllers;

use App\Models\Rubriques;
use Illuminate\Http\Request;
use App\Models\FamilleRubrique;
use App\Http\Requests\StoreRubriqueRequest;
use App\Http\Requests\UpdateRubriqueRequest;

class RubriquesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rubriques = Rubriques::all();
        return view('backend.frais.rubriques.index', compact('rubriques'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $familleRubriques = FamilleRubrique::all();
        return view('backend.frais.rubriques.create', compact('familleRubriques'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRubriqueRequest $request)
    {
        Rubriques::create($request->validated());
        return redirect()->route('rubriques.index')->with('success', 'Rubrique crée avec succès');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rubriques  $rubrique
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rubriques  $rubrique
     * @return \Illuminate\Http\Response
     */
    public function edit(Rubriques $rubrique)
    {
        $familleRubriques = FamilleRubrique::all();
        return view('backend.frais.rubriques.edit', compact('familleRubriques', 'rubrique'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rubriques  $rubriques
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRubriqueRequest $request, Rubriques $rubrique)
    {
        $rubrique->update($request->validated());
        return redirect()->route('rubriques.index')->with('success', 'Rubrique modifié avec succès');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rubriques  $rubrique
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rubriques $rubrique)
    {
        try {
            $rubrique->delete();
            return redirect()->route('rubriques.index')->with('success', 'Opération bien effectuée');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with("error", "Vous ne pouvez pas supprimer cet élément à cause du contrôle d'intégrité.");
        }
       

     }
}

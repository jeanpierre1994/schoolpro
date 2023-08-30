<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grilletarifaires;
use App\Http\Requests\StoreGrilleRequest;
use App\Http\Requests\UpdateGrilleRequest;

class GrilletarifairesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grilleTarifaires = Grilletarifaires::all();
        return view('backend.frais.grilleTarifaires.index', compact('grilleTarifaires'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.frais.grilleTarifaires.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGrilleRequest $request)
    {
        Grilletarifaires::create($request->validated());

        return redirect()->route('grille_tarifaires.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Grilletarifaires  $grilletarifaire
     * @return \Illuminate\Http\Response
     */
    public function show(Grilletarifaires $grilletarifaires)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Grilletarifaires  $grilletarifaire
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $grilleTarifaire = Grilletarifaires::find($id);
        return view('backend.frais.grilleTarifaires.edit', compact('grilleTarifaire'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Grilletarifaires  $grilletarifaires
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGrilleRequest $request, Grilletarifaires $grilleTarifaire)
    {
        $grilleTarifaire->update($request->validated());
        return redirect()->route('grille_tarifaires.index')->with('success', 'Modification effectuée avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Grilletarifaires  $grilletarifaires
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $grilletarifaire = Grilletarifaires::find($id);
        $grilletarifaire->delete();

        return redirect()->back()->with('success', 'Suppression effectuée');
    }
}

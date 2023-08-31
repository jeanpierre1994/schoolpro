<?php

namespace App\Http\Controllers;

use App\Models\Rubriques;
use App\Models\Lignetarifs;
use Illuminate\Http\Request;
use App\Models\Grilletarifaires;
use App\Http\Requests\StoreLigneTarifaireRequest;
use App\Http\Requests\UpdateLigneTarifaireRequest;

class LignetarifsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ligneTarifaires = Lignetarifs::all();
        return view('backend.frais.ligneTarifaires.index', compact('ligneTarifaires')); ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $grilleTarifaires = Grilletarifaires::all();
        $rubriques = Rubriques::all();
        return view('backend.frais.ligneTarifaires.create', compact('grilleTarifaires', 'rubriques'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLigneTarifaireRequest $request)
    {
        $request->is_required == "on" ? $is_required = true : $is_required = false;
        Lignetarifs::create($request->validated() + ['is_required' => $is_required]);
        return redirect()->route('ligne_tarifaires.index')->with('success', 'Created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lignetarifs  $lignetarif
     * @return \Illuminate\Http\Response
     */
    public function show(Lignetarifs $lignetarifs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lignetarifs  $lignetarifs
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $grilleTarifaires = Grilletarifaires::all();

        $rubriques = Rubriques::all();
        $ligneTarifaire = Lignetarifs::find($id);
        return view('backend.frais.ligneTarifaires.edit', compact('grilleTarifaires', 'rubriques', 'ligneTarifaire'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lignetarifs  $lignetarif
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLigneTarifaireRequest $request, $id)
    {
        $request->is_required == "on" ? $is_required = true : $is_required = false;
        $ligneTarifaire = Lignetarifs::find($id);
        $lignetarif->update($request->validated() + ['is_required' => $is_required] );
        return redirect()->route('ligne_tarifaires.index')->with('success', 'Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lignetarifs  $lignetarif
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ligneTarifaire = Lignetarifs::find($id);

        $ligneTarifaire->delete();

        return redirect()->route('ligne_tarifaires.index')->with('success', 'Deleted successfully');
    }
}

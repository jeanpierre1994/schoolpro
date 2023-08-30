<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FamilleRubrique;
use App\Http\Requests\StoreFamilleRubriqueRequest;
use App\Http\Requests\UpdateFamilleRubriqueRequest;

class FamilleRubriqueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $familleRubriques = FamilleRubrique::all();
        return view('backend.frais.familleRubriques.index', compact('familleRubriques')) ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.frais.familleRubriques.create') ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFamilleRubriqueRequest $request)
    {
        FamilleRubrique::create($request->validated()+ ['code' => 3]);
        return redirect()->route('famille_rubriques.index')->with('success', 'Famille de Rubrique crée avec succès');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $familleRubrique = FamilleRubrique::find($id);
        return view('backend.frais.familleRubriques.edit', compact('familleRubrique'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFamilleRubriqueRequest $request, FamilleRubrique $familleRubrique)
    {
        $familleRubrique->update($request->validated());
        return redirect()->route('famille_rubriques.index')->with('success', 'Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $familleRubrique = FamilleRubrique::where('id',$id)->get()->first();
        $familleRubrique->delete();

        return redirect()->route('famille_rubriques.index')->with('success', 'Deleted Successfully');
    }
}

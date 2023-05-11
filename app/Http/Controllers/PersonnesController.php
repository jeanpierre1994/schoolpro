<?php

namespace App\Http\Controllers;

use App\Imports\DossierImport;
use App\Imports\EtudiantsImport;
use App\Imports\ParentsImport;
use App\Imports\PersonnesImport;
use App\Models\Personnes;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PersonnesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Personnes  $personnes
     * @return \Illuminate\Http\Response
     */
    public function show(Personnes $personnes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Personnes  $personnes
     * @return \Illuminate\Http\Response
     */
    public function edit(Personnes $personnes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Personnes  $personnes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Personnes $personnes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Personnes  $personnes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Personnes $personnes)
    {
        //
    }

    public function importPersonnes()
    {
        return view('backend.personnes.import');
    }

    public function uploadPersonnes(Request $request)
    {
       Excel::import(new DossierImport, $request->file);
       // Excel::import(new EtudiantsImport, $request->file);
       return back()->with('success', 'Importation effectuée avec succès');
       
    }
}

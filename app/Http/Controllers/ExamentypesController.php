<?php

namespace App\Http\Controllers;

use App\Models\Examentypes;
use Illuminate\Http\Request;

class ExamentypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $examentypes = Examentypes::orderBy("id", "desc")->get();
        return view("backend.examentypes.index", compact("examentypes"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("backend.examentypes.create");
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
            'libelle' => 'required|unique:examentypes,libelle'
        ]);

        $user = auth()->user();
        $user_id = $user->id;

        $examentype = new Examentypes();
        $examentype->setAttribute('libelle', $request->libelle);
        $examentype->setAttribute('description', $request->description);
        $examentype->setAttribute('created_by', $user_id);
        $examentype->setAttribute('created_at', new \DateTime());
        $examentype->setAttribute('updated_by', $user_id);
        $examentype->setAttribute('statut_id', 1);
        $examentype->save();

        return redirect()->route('examentypes.index')
            ->with('success', 'Enregistrement effectué avec succès');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Examentypes  $examentypes
     * @return \Illuminate\Http\Response
     */
    public function show(Examentypes $examentypes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Examentypes  $examentype
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $examentype = Examentypes::where("id", $id)->get()->first();
        return view("backend.examentypes.edit", compact("examentype"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Examentypes  $examentype
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Examentypes $examentype)
    {
        //update requete
        $this->validate($request, [
            'libelle'  => 'required'
        ]);

        // vérifier si le examen type existe déjà
        $check_examentype = Examentypes::where("libelle",$request->libelle)->where("id","!=",$examentype->id)->exists();
        if($check_examentype){
            redirect()->back()->with("error","L'examen type existe déjà.");
        }
        // get current user id
        $user = auth()->user(); 
        $examentype->setAttribute('libelle', $request->libelle);
        $examentype->setAttribute('description', $request->description);
        $examentype->setAttribute('updated_at', new \DateTime());
        $examentype->setAttribute('updated_by', $user->id);
        $examentype->update(); 

        return redirect()->route('examentypes.index')->with('success', 'Modification effectuée avec succès');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Examentypes  $examentype
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $examentype = Examentypes::find($id);
            //Récupérer le libelle de l'élément supprimé
            $value = $examentype->libelle;
            $examentype->delete();
            // get current user id
            $user = auth()->user(); 
            return redirect()->route('examentypes.index')->with('success', 'Opération bien effectuéé');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with("error", "Vous ne pouvez pas supprimer cet élément à cause du contrôle d'intégrité.");
        }
    }
}

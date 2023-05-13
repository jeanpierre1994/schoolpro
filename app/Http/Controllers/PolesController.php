<?php

namespace App\Http\Controllers;

use App\Models\Poles;
use Illuminate\Http\Request;

class PolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $poles = Poles::orderBy("id", "desc")->get();
        return view("backend.poles.index", compact("poles"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("backend.poles.create");
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
            'libelle' => 'required|unique:poles,libelle',
            'libelle_secondaire'  => 'required'
        ]);

        $user = auth()->user();
        $user_id = $user->id;

        $pole = new Poles();
        $pole->setAttribute('libelle', $request->libelle);
        $pole->setAttribute('libelle_secondaire', $request->libelle_secondaire);
        $pole->setAttribute('description', $request->description);
        $pole->setAttribute('created_by', $user_id);
        $pole->setAttribute('created_at', new \DateTime());
        $pole->setAttribute('updated_by', $user_id);
        $pole->setAttribute('statut_id', 1);
        $pole->save();

        return redirect()->route('poles.index')
            ->with('success', 'Enregistrement effectué avec succès');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Poles  $poles
     * @return \Illuminate\Http\Response
     */
    public function show(Poles $poles)
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
        $pole = Poles::where("id", $id)->get()->first();
        return view("backend.poles.edit", compact("pole"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Poles  $pole
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Poles $pole)
    {
        //update requete
        $this->validate($request, [
            'libelle'  => 'required',
            'libelle_secondaire'  => 'required'
        ]);

        // vérifier si le pole existe déjà
        $check_pole = Poles::where("libelle",$request->libelle)->where("id","!=",$pole->id)->exists();
        if($check_pole){
            redirect()->back()->with("error","La données existe déjà.");
        }
        // get current user id
        $user = auth()->user(); 
        $pole->setAttribute('libelle', $request->libelle);
        $pole->setAttribute('libelle_secondaire', $request->libelle_secondaire);
        $pole->setAttribute('description', $request->description);
        $pole->setAttribute('updated_at', new \DateTime());
        $pole->setAttribute('updated_by', $user->id);
        $pole->update(); 

        return redirect()->route('poles.index')->with('success', 'Modification effectuée avec succès');
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
            $pole = Poles::find($id);
            //Récupérer le libelle de l'élément supprimé
            $value = $pole->libelle;
            $pole->delete();
            // get current user id
            $user = auth()->user(); 
            return redirect()->route('poles.index')->with('success', 'Opération bien effectuéé');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with("error", "Vous ne pouvez pas supprimer cet élément à cause du contrôle d'intégrité.");
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Cycles;
use Illuminate\Http\Request;

class CyclesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cycles = Cycles::orderBy("id", "desc")->get();
        return view("backend.cycles.index", compact("cycles"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("backend.cycles.create");
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
            'libelle' => 'required|unique:cycles,libelle'
        ]);

        $user = auth()->user();
        $user_id = $user->id;

        $cycle = new Cycles();
        $cycle->setAttribute('libelle', $request->libelle);
        $cycle->setAttribute('description', $request->description);
        $cycle->setAttribute('created_by', $user_id);
        $cycle->setAttribute('created_at', new \DateTime());
        $cycle->setAttribute('updated_by', $user_id);
        $cycle->setAttribute('statut_id', 1);
        $cycle->save();

        return redirect()->route('cycles.index')
            ->with('success', 'Enregistrement effectué avec succès');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cycles  $cycles
     * @return \Illuminate\Http\Response
     */
    public function show(Cycles $cycles)
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
        $cycle = Cycles::where("id", $id)->get()->first();
        return view("backend.cycles.edit", compact("cycle"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cycles  $cycle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cycles $cycle)
    {
        //update requete
        $this->validate($request, [
            'libelle'  => 'required'
        ]);

        // vérifier si le cycle existe déjà
        $check_cycle = Cycles::where("libelle",$request->libelle)->where("id","!=",$cycle->id)->exists();
        if($check_cycle){
            redirect()->back()->with("error","Le cycle existe déjà.");
        }
        // get current user id
        $user = auth()->user(); 
        $cycle->setAttribute('libelle', $request->libelle);
        $cycle->setAttribute('description', $request->description);
        $cycle->setAttribute('updated_at', new \DateTime());
        $cycle->setAttribute('updated_by', $user->id);
        $cycle->update(); 

        return redirect()->route('cycles.index')->with('success', 'Modification effectuée avec succès');
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
            $cycle = Cycles::find($id);
            //Récupérer le libelle de l'élément supprimé
            $value = $cycle->libelle;
            $cycle->delete();
            // get current user id
            $user = auth()->user(); 
            return redirect()->route('cycles.index')->with('success', 'Opération bien effectuéé');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with("error", "Vous ne pouvez pas supprimer cet élément à cause du contrôle d'intégrité.");
        }
    }
}

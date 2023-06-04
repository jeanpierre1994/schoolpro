<?php

namespace App\Http\Controllers;

use App\Models\Matiereconfig;
use Illuminate\Http\Request;

class MatiereconfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $matiereconfigs = Matiereconfig::orderBy("id", "desc")->get();
        return view("backend.matiereconfigs.index", compact("matiereconfigs"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("backend.matiereconfigs.create");
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
            'libelle' => 'required',
            'libelle_secondaire'  => 'required',
            'sigle'  => 'required'
        ]);

        $check_matiere = Matiereconfig::where("libelle",$request->libelle)->where("libelle_secondaire",$request->libelle_secondaire)->where("sigle",$request->sigle)->exists();
        if ($check_matiere) {
            # code...
            return redirect()->back()->with("error","La matière existe déjà.");
        }
        $user = auth()->user();
        $user_id = $user->id;

        $matiereconfig = new Matiereconfig();
        $matiereconfig->setAttribute('libelle', $request->libelle);
        $matiereconfig->setAttribute('sigle', $request->sigle);
        $matiereconfig->setAttribute('libelle_secondaire', $request->libelle_secondaire);
        $matiereconfig->setAttribute('description', $request->description);
        $matiereconfig->setAttribute('created_by', $user_id);
        $matiereconfig->setAttribute('created_at', new \DateTime());
        $matiereconfig->setAttribute('updated_by', $user_id);
        $matiereconfig->setAttribute('statut_id', 1);
        $matiereconfig->save();

        return redirect()->route('matiereconfigs.index')
            ->with('success', 'Enregistrement effectué avec succès');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Matiereconfigs  $matiereconfig
     * @return \Illuminate\Http\Response
     */
    public function show(Matiereconfig $matiereconfig)
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
        $matiereconfig = Matiereconfig::where("id", $id)->get()->first();
        return view("backend.matiereconfigs.edit", compact("matiereconfig"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Matiereconfigd  $matiereconfig
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Matiereconfig $matiereconfig)
    {
        //update requete
        $this->validate($request, [
            'libelle'  => 'required',
            'libelle_secondaire'  => 'required',
            'sigle' => 'required'
        ]);

        // vérifier si le matiereconfig existe déjà 
        $check_matiere = Matiereconfig::where("libelle",$request->libelle)->where("libelle_secondaire",$request->libelle_secondaire)->where("sigle",$request->sigle)->where("id","!=",$matiereconfig->id)->exists();
        if ($check_matiere) {
            # code...
            return redirect()->back()->with("error","La matière existe déjà.");
        } 
        // get current user id
        $user = auth()->user(); 
        $matiereconfig->setAttribute('libelle', $request->libelle);
        $matiereconfig->setAttribute('sigle', $request->sigle);
        $matiereconfig->setAttribute('libelle_secondaire', $request->libelle_secondaire);
        $matiereconfig->setAttribute('description', $request->description);
        $matiereconfig->setAttribute('updated_at', new \DateTime());
        $matiereconfig->setAttribute('updated_by', $user->id);
        $matiereconfig->update(); 

        return redirect()->route('matiereconfigs.index')->with('success', 'Modification effectuée avec succès');
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
            $matiereconfig = Matiereconfig::find($id);
            //Récupérer le libelle de l'élément supprimé
            $value = $matiereconfig->libelle;
            $matiereconfig->delete();
            // get current user id
            $user = auth()->user(); 
            return redirect()->route('matiereconfigs.index')->with('success', 'Opération bien effectuéé');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with("error", "Vous ne pouvez pas supprimer cet élément à cause du contrôle d'intégrité.");
        }
    }
}

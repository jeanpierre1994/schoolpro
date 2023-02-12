<?php

namespace App\Http\Controllers;

use App\Models\Profil;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Liste des profils
        $profils = Profil::orderBy("id", "desc")->get();
        return view("backend.profils.index", compact("profils"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("backend.profils.create");
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
            'libelle' => 'required|unique:profils,libelle'
        ]);

        $user = auth()->user();
        $user_id = $user->id;

        $profil = new Profil();
        $profil->setAttribute('libelle', $request->libelle);
        $profil->setAttribute('description', $request->description);
        $profil->setAttribute('created_by', $user_id);
        $profil->setAttribute('created_at', new \DateTime());
        $profil->setAttribute('updated_by', $user_id);
        $profil->setAttribute('statut_id', 1);
        $profil->save();

        return redirect()->route('profils.index')
            ->with('success', 'Enregistrement effectué avec succès');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profil  $profil
     * @return \Illuminate\Http\Response
     */
    public function show(Profil $profil)
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
        $profil = Profil::where("id", $id)->get()->first();
        return view("backend.profils.edit", compact("profil"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profil  $profil
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profil $profil)
    {
        //update requete
        $this->validate($request, [

            'libelle'  => [
                'required',
                \Illuminate\Validation\Rule::unique('profils')->where(function ($query) use ($request, $profil) {
                    return $query
                        ->whereLibelle($request->libelle)
                        ->whereNotIn('libelle', [$profil->libelle]);
                }),
            ]

        ]);
        // get current user id
        $user = auth()->user(); 
        $profil->setAttribute('libelle', $request->libelle);
        $profil->setAttribute('description', $request->description);
        $profil->setAttribute('updated_at', new \DateTime());
        $profil->setAttribute('updated_by', $user->id);
        $profil->update(); 

        return redirect()->route('profils.index')->with('success', 'Modification effectuée avec succès');
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
            $profil = Profil::find($id);
            //Récupérer le libelle de l'élément supprimé
            $value = $profil->libelle;
            $profil->delete();
            // get current user id
            $user = auth()->user(); 
            return redirect()->route('profils.index')->with('success', 'Opération bien effectuéé');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with("error", "Vous ne pouvez pas supprimer cet élément à cause du contrôle d'intégrité.");
        }
    }
}

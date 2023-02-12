<?php

namespace App\Http\Controllers;

use App\Models\Typesponsors;
use Illuminate\Http\Request;

class TypesponsorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $typesponsors = Typesponsors::orderBy("id", "desc")->get();
        return view("backend.typesponsors.index", compact("typesponsors"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("backend.typesponsors.create");
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
            'libelle' => 'required|unique:typesponsors,libelle'
        ]);

        $user = auth()->user();
        $user_id = $user->id;

        $pole = new Typesponsors();
        $pole->setAttribute('libelle', $request->libelle);
        $pole->setAttribute('description', $request->description);
        $pole->setAttribute('created_by', $user_id);
        $pole->setAttribute('created_at', new \DateTime());
        $pole->setAttribute('updated_by', $user_id);
        $pole->setAttribute('statut_id', 1);
        $pole->save();

        return redirect()->route('typesponsors.index')
            ->with('success', 'Enregistrement effectué avec succès');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Typesponsors  $typesponsors
     * @return \Illuminate\Http\Response
     */
    public function show(Typesponsors $typesponsors)
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
        $typesponsor = Typesponsors::where("id", $id)->get()->first();
        return view("backend.typesponsors.edit", compact("typesponsor"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Typesponsors  $typesponsor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Typesponsors $typesponsor)
    {
        //update requete
        $this->validate($request, [
            'libelle'  => 'required'
        ]);

        // vérifier si le pole existe déjà
        $check_typesponsor = Typesponsors::where("libelle",$request->libelle)->where("id","!=",$typesponsor->id)->exists();
        if($check_typesponsor){
            redirect()->back()->with("error","La données existe déjà.");
        }
        // get current user id
        $user = auth()->user(); 
        $typesponsor->setAttribute('libelle', $request->libelle);
        $typesponsor->setAttribute('description', $request->description);
        $typesponsor->setAttribute('updated_at', new \DateTime());
        $typesponsor->setAttribute('updated_by', $user->id);
        $typesponsor->update(); 

        return redirect()->route('typesponsors.index')->with('success', 'Modification effectuée avec succès');
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
            $typesponsor = Typesponsors::find($id);
            //Récupérer le libelle de l'élément supprimé
            $value = $typesponsor->libelle;
            $typesponsor->delete();
            // get current user id
            $user = auth()->user(); 
            return redirect()->route('typesponsors.index')->with('success', 'Opération bien effectuéé');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with("error", "Vous ne pouvez pas supprimer cet élément à cause du contrôle d'intégrité.");
        }
    }
}

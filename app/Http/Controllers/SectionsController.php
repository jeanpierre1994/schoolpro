<?php

namespace App\Http\Controllers;

use App\Models\Sections;
use Illuminate\Http\Request;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = Sections::orderBy("id", "desc")->get();
        return view("backend.sections.index", compact("sections"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("backend.sections.create");
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
            'libelle' => 'required|unique:sections,libelle',
            'libelle_secondaire'  => 'required'
        ]);

        $user = auth()->user();
        $user_id = $user->id;

        $section = new Sections();
        $section->setAttribute('libelle', $request->libelle);
        $section->setAttribute('libelle_secondaire', $request->libelle_secondaire);
        $section->setAttribute('description', $request->description);
        $section->setAttribute('created_by', $user_id);
        $section->setAttribute('created_at', new \DateTime());
        $section->setAttribute('updated_by', $user_id);
        $section->setAttribute('statut_id', 1);
        $section->save();

        return redirect()->route('sections.index')
            ->with('success', 'Enregistrement effectué avec succès');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sections  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Sections $section)
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
        $section = Sections::where("id", $id)->get()->first();
        return view("backend.sections.edit", compact("section"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sections  $section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sections $section)
    {
        //update requete
        $this->validate($request, [
            'libelle'  => 'required',
            'libelle_secondaire'  => 'required'
        ]);

        // vérifier si la section existe déjà
        $check_section = Sections::where("libelle",$request->libelle)->where("id","!=",$section->id)->exists();
        if($check_section){
            redirect()->back()->with("error","La section existe déjà.");
        }
        // get current user id
        $user = auth()->user(); 
        $section->setAttribute('libelle', $request->libelle);
        $section->setAttribute('libelle_secondaire', $request->libelle_secondaire);
        $section->setAttribute('description', $request->description);
        $section->setAttribute('updated_at', new \DateTime());
        $section->setAttribute('updated_by', $user->id);
        $section->update(); 

        return redirect()->route('sections.index')->with('success', 'Modification effectuée avec succès');
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
            $section = Sections::find($id);
            //Récupérer le libelle de l'élément supprimé
            $value = $section->libelle;
            $section->delete();
            // get current user id
            $user = auth()->user(); 
            return redirect()->route('sections.index')->with('success', 'Opération bien effectuéé');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with("error", "Vous ne pouvez pas supprimer cet élément à cause du contrôle d'intégrité.");
        }
    }
}

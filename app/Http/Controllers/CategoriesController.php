<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Categories::orderBy("id", "desc")->get();
        return view("backend.categories.index", compact("categories"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("backend.categories.create");
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
            'libelle' => 'required|unique:categories,libelle'
        ]);

        $user = auth()->user();
        $user_id = $user->id;

        $categorie = new Categories();
        $categorie->setAttribute('libelle', $request->libelle);
        $categorie->setAttribute('description', $request->description);
        $categorie->setAttribute('created_by', $user_id);
        $categorie->setAttribute('created_at', new \DateTime());
        $categorie->setAttribute('updated_by', $user_id);
        $categorie->setAttribute('statut_id', 1);
        $categorie->save();

        return redirect()->route('categories.index')
            ->with('success', 'Enregistrement effectué avec succès');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categories  $categorie
     * @return \Illuminate\Http\Response
     */
    public function show(Categories $categorie)
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
        $categorie = Categories::where("id", $id)->get()->first();
        return view("backend.categories.edit", compact("categorie"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Categories  $categorie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Categories $categorie)
    {
        //update requete
        $this->validate($request, [
            'libelle'  => 'required'
        ]);

        // vérifier si le categorie existe déjà
        $check_categorie = Categories::where("libelle",$request->libelle)->where("id","!=",$categorie->id)->exists();
        if($check_categorie){
            redirect()->back()->with("error","La categorie existe déjà.");
        }
        // get current user id
        $user = auth()->user(); 
        $categorie->setAttribute('libelle', $request->libelle);
        $categorie->setAttribute('description', $request->description);
        $categorie->setAttribute('updated_at', new \DateTime());
        $categorie->setAttribute('updated_by', $user->id);
        $categorie->update(); 

        return redirect()->route('categories.index')->with('success', 'Modification effectuée avec succès');
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
            $categorie = Categories::find($id);
            //Récupérer le libelle de l'élément supprimé
            $value = $categorie->libelle;
            $categorie->delete();
            // get current user id
            $user = auth()->user(); 
            return redirect()->route('categories.index')->with('success', 'Opération bien effectuéé');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with("error", "Vous ne pouvez pas supprimer cet élément à cause du contrôle d'intégrité.");
        }
    }
}

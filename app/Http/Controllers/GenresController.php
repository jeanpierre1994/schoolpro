<?php

namespace App\Http\Controllers;

use App\Models\Genres;
use Illuminate\Http\Request;

class GenresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $genres = Genres::orderBy("id", "desc")->get();
        return view("backend.genres.index", compact("genres"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("backend.genres.create");
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
            'libelle' => 'required|unique:genres,libelle'
        ]);

        $user = auth()->user();
        $user_id = $user->id;

        $genre = new Genres();
        $genre->setAttribute('libelle', $request->libelle);
        $genre->setAttribute('description', $request->description);
        $genre->setAttribute('created_by', $user_id);
        $genre->setAttribute('created_at', new \DateTime());
        $genre->setAttribute('updated_by', $user_id);
        $genre->setAttribute('statut_id', 1);
        $genre->save();

        return redirect()->route('genres.index')
            ->with('success', 'Enregistrement effectué avec succès');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Genres  $genres
     * @return \Illuminate\Http\Response
     */
    public function show(Genres $genres)
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
        $genre = Genres::where("id", $id)->get()->first();
        return view("backend.genres.edit", compact("genre"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Genres  $genre
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Genres $genre)
    {
        //update requete
        $this->validate($request, [

            'libelle'  => [
                'required',
                \Illuminate\Validation\Rule::unique('genres')->where(function ($query) use ($request, $genre) {
                    return $query
                        ->whereLibelle($request->libelle)
                        ->whereNotIn('libelle', [$genre->libelle]);
                }),
            ]

        ]);
        // get current user id
        $user = auth()->user(); 
        $genre->setAttribute('libelle', $request->libelle);
        $genre->setAttribute('description', $request->description);
        $genre->setAttribute('updated_at', new \DateTime());
        $genre->setAttribute('updated_by', $user->id);
        $genre->update(); 

        return redirect()->route('genres.index')->with('success', 'Modification effectuée avec succès');
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
            $genre = Genres::find($id);
            //Récupérer le libelle de l'élément supprimé
            $value = $genre->libelle;
            $genre->delete();
            // get current user id
            $user = auth()->user(); 
            return redirect()->route('genres.index')->with('success', 'Opération bien effectuéé');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with("error", "Vous ne pouvez pas supprimer cet élément à cause du contrôle d'intégrité.");
        }
    }
}

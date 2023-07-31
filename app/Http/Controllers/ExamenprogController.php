<?php

namespace App\Http\Controllers;

use App\Models\Matieres;
use App\Models\Examenprog;
use Illuminate\Http\Request;

class ExamenprogController extends Controller
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
        $this->validate($request, [
            'examen_id' => 'required',
            'matiere_id' => 'required',
            'date_debut' => 'required',
            'date_fin' => 'required', 
        ]);

        $user = auth()->user();
        $user_id = $user->id;

        $examenprog = new Examenprog();
        $examenprog->setAttribute('examen_id', $request->examen_id);
        $examenprog->setAttribute('matiere_id', $request->matiere_id);
        $examenprog->setAttribute('date_debut', $request->date_debut);
        $examenprog->setAttribute('date_fin', $request->date_fin);
        //$examenprog->setAttribute('annee_academique', $request->annee_academique);
        $examenprog->setAttribute('commentaire', $request->commentaire);
        $examenprog->setAttribute('created_by', $user_id);
        $examenprog->setAttribute('created_at', new \DateTime());
        $examenprog->setAttribute('updated_at', new \DateTime());
        $examenprog->setAttribute('updated_by', $user_id); 
        $examenprog->save();

        return redirect()->back()
            ->with('success', 'Enregistrement effectué avec succès');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Examenprog  $examenprog
     * @return \Illuminate\Http\Response
     */
    public function show(Examenprog $examenprog)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Examenprog  $examenprog
     * @return \Illuminate\Http\Response
     */
    public function edit($matiere)
    {
        $examenprog = Examenprog::where('matiere_id', $matiere)
        ->where('examen_id', \request()->examen_id)
        ->get()
        ->first();
        return view("backend.examenprog.edit", compact("examenprog"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Examenprog  $examenprog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Examenprog $examenprog)
    {
        $this->validate($request, [
            'examen_id' => 'required',
            'gp_id' => 'required',
            'date_debut' => 'required',
            'date_fin' => 'required', 
        ]);

        $examenprog->setAttribute("date_debut", $request->date_debut);
        $examenprog->setAttribute("date_fin", $request->date_fin);
        $examenprog->setAttribute("commentaire", $request->commentaire);
        $examenprog->update();

        return redirect()->route("examenprog.matiere-gp",["id"=>$request->examen_id,"gp_id"=>$request->gp_id])
            ->with('success', 'Modification effectuée avec succès');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Examenprog  $examenprog
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $examenprog = Examenprog::find($id);
            //Récupérer le libelle de l'élément supprimé 
            $examenprog->delete(); 
            return redirect()->back()->with('success', 'Opération bien effectuéé');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with("error", "Vous ne pouvez pas supprimer cet élément à cause du contrôle d'intégrité.");
        }
    }
}

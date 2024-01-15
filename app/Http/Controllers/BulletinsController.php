<?php

namespace App\Http\Controllers;

use App\Models\Bulletinprog;
use App\Models\Examens;
use App\Models\Groupepedagogiques;
use App\Models\Notes;
use App\Models\Synthesenotes;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Http\Request;

class BulletinsController extends Controller
{
    public function index()
    {
        $pdf = Pdf::loadView('frontend.bulletins.template');
        return $pdf->stream();
    }

    public function genereNote(){

        $gp = Groupepedagogiques::all();
        $bulletins = Bulletinprog::all();
        $update = false;
        return view("frontend.bulletins.generer_note",compact("gp","bulletins","update"));
    }

    public function saveNote(Request $request){
        $this->validate($request, [
            'bulletin' => 'required',
            'classe' => 'required',
        ]);

        
        $count_notes = Synthesenotes::where("groupepedagogique_id",$request->classe)->count();
        if ($count_notes > 0) {
            $gp = Groupepedagogiques::all();
            $bulletins = Bulletinprog::all();
            $get_gp = Groupepedagogiques::find($request->classe);
            $get_bulletin = Bulletinprog::where("code",$request->bulletin)->first(); 
            $liste_notes = Synthesenotes::where("groupepedagogique_id",$request->classe)->get();
            $update = true;
            return view("frontend.bulletins.generer_note",compact("gp","bulletins","update","get_bulletin","get_gp","liste_notes"));
        }
        // liste des examens
        $examens = Examens::where("code_bulletin",$request->bulletin)->get();
        if ($examens->count() == 3) {
            # code...

        } else {
            # code...
            return redirect()->route("bulletins.generer-note")->with('error', "Nombre d'examen superieur a 3, impossible de traiter la demande pour l'instant");
        
        }
        

        // enregistrement des donnees dans la premiere colonne
        $notes_one = Notes::join("examenprogs","examenprogs.id","=","notes.examen_prog_id")
        ->join("examens","examens.id","=","examenprogs.examen_id")
        ->where("notes.groupepedagogique_id",$request->classe)
        ->where("examens.colonnes",1)
        ->where("examens.code_bulletin",$request->bulletin)->get();

        if ($notes_one->count() > 0) {
            foreach ($notes_one as $key => $value) {
                # code...
                $synthese_note = new Synthesenotes();
                $synthese_note->setAttribute("examen_prog_id",$value->examen_prog_id);
                $synthese_note->setAttribute("groupepedagogique_id",$value->groupepedagogique_id);
                $synthese_note->setAttribute("etudiant_id",$value->etudiant_id);
                $synthese_note->setAttribute("note_first",$value->note_examen);
                $synthese_note->save(); 
            }
        }


       

        // enregistrement des donnees dans la premiere colonne
        $get_synthese_note = Synthesenotes::where("groupepedagogique_id",$request->classe)->get();
        $notes_two = Notes::join("examenprogs","examenprogs.id","=","notes.examen_prog_id")
        ->join("examens","examens.id","=","examenprogs.examen_id")
        ->where("notes.groupepedagogique_id",$request->classe)
        ->where("examens.colonnes",2)
        ->where("examens.code_bulletin",$request->bulletin)->get();

        if ($notes_two->count() > 0) {
            # code...
            foreach ($get_synthese_note as $key => $value) {
                # code...
                foreach ($notes_two as $key => $notes_tw) {
                    # code...
                    if ($notes_tw->etudiant_id == $value->etudiant_id && $notes_tw->groupepedagogique_id == $value->groupepedagogique_id && $notes_tw->examen_prog_id == $value->examen_prog_id  ) {
                        # code...
                        $synthese_note = Synthesenotes::find($value->id); 
                        $synthese_note->setAttribute("note_second",$notes_tw->note_examen);
                        $synthese_note->update(); 
                    }
                }
            }
        }
    

        // enregistrement des donnees dans la premiere colonne
        $notes_tree = Notes::join("examenprogs","examenprogs.id","=","notes.examen_prog_id")
        ->join("examens","examens.id","=","examenprogs.examen_id")
        ->where("notes.groupepedagogique_id",$request->classe)
        ->where("examens.colonnes",3)
        ->where("examens.code_bulletin",$request->bulletin)->get();

        if ($notes_tree->count() > 0) {
            # code...
            foreach ($get_synthese_note as $key => $value) {
                # code...
                foreach ($notes_tree as $key => $notes_tre) {
                    # code...
                    if ($notes_tre->etudiant_id == $value->etudiant_id && $notes_tre->groupepedagogique_id == $value->groupepedagogique_id && $notes_tre->examen_prog_id == $value->examen_prog_id  ) {
                        # code...
                        $synthese_note = Synthesenotes::find($value->id); 
                        $synthese_note->setAttribute("note_second",$notes_tre->note_examen);
                        $synthese_note->update(); 
                    }
                }
            }
        }
 
        $gp = Groupepedagogiques::all();
        $bulletins = Bulletinprog::all();
        $get_gp = Groupepedagogiques::find($request->classe);
        $get_bulletin = Bulletinprog::where("code",$request->bulletin)->first();
        $liste_notes = Synthesenotes::where("groupepedagogique_id",$request->classe)->get();
        $update = true;
        return view("frontend.bulletins.generer_note",compact("gp","bulletins","update","get_bulletin","get_gp","liste_notes"));
    }


}

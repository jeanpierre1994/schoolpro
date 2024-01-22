<?php

namespace App\Http\Controllers;

use App\Models\Notes;
use App\Models\Examens;
use App\Models\Matieres;
use App\Models\Etudiants;
use App\Models\Personnes;
use App\Models\Bulletinprog;

use Illuminate\Http\Request;
use App\Models\Synthesenotes;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Groupepedagogiques;

class BulletinsController extends Controller
{
    public function index($id, $codeBulletin)
    {

        $etudiant_id = \Crypt::decrypt($id);
        $etudiant = Etudiants::find($etudiant_id);
        $bulletinData = Synthesenotes::get()->where('etudiant_id', $etudiant_id)->where('code_bulletin', $codeBulletin);
        $personne = Personnes::where('id', $etudiant->getDossier->personne_id)->get()->first() ;

        $notesSectionFrench = [];
        $notesSectionEng = [];
        foreach( $bulletinData as $data )
        { 
            if (!empty($data) || !empty($data->examen_prog_id)) {
                # code...
            $matiere = Matieres::findOrFail($data->getExamenprog->matiere_id);
            if($matiere->section_id == 1)
            {
                $notesSectionFrench[] = $data;
            }else{
                $notesSectionEng[] = $data;            }

            }
        }
        $pdf = Pdf::loadView('frontend.bulletins.template', compact('etudiant', 'bulletinData', 'personne', 'notesSectionFrench', 'notesSectionEng'));
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
 
        $count_notes = Synthesenotes::where("groupepedagogique_id",$request->classe)
        ->where("code_bulletin",$request->bulletin)->count();
        if ($count_notes > 0 && isset($_POST['afficher'])) {
            $gp = Groupepedagogiques::all();
            $bulletins = Bulletinprog::all();
            $get_gp = Groupepedagogiques::find($request->classe);
            $get_bulletin = Bulletinprog::where("code",$request->bulletin)->first();
            $liste_notes = Synthesenotes::where("groupepedagogique_id",$request->classe)
            ->where("code_bulletin",$request->bulletin)
            ->get();
            $update = true; 
            return view("frontend.bulletins.generer_note",compact("gp","bulletins","update","get_bulletin","get_gp","liste_notes")); 
        }
        if ($count_notes > 0) {
            $delete = $count_notes = Synthesenotes::where("groupepedagogique_id",$request->classe)
            ->where("code_bulletin",$request->bulletin)->delete(); 
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
        $notes_one = Notes::join("sessioncorrections","sessioncorrections.id","=","notes.sessioncorrection_id")
        ->join("examenprogs","examenprogs.id","=","sessioncorrections.examen_prog_id")
        ->join("examens","examens.id","=","examenprogs.examen_id") 
        ->join("matieres","matieres.id","=","examenprogs.matiere_id") 
        ->where("notes.groupepedagogique_id",$request->classe)
        ->where("matieres.groupepedagogique_id",$request->classe)
        ->where("examens.colonnes",1)
        ->where("examens.code_bulletin",$request->bulletin)
        ->get(["notes.id","notes.etudiant_id","notes.groupepedagogique_id","notes.examen_prog_id","notes.note_examen"]);

        if ($notes_one->count() > 0) {
            foreach ($notes_one as $key => $value) {
                # code...
                $synthese_note = new Synthesenotes();
                $synthese_note->setAttribute("examen_prog_id",$value->examen_prog_id);
                $synthese_note->setAttribute("groupepedagogique_id",$value->groupepedagogique_id);
                $synthese_note->setAttribute("etudiant_id",$value->etudiant_id);
                $note = $value->note_examen ? $value->note_examen : 0;
                $synthese_note->setAttribute("note_first",$note);
                $synthese_note->setAttribute("code_bulletin",$request->bulletin);
                $synthese_note->save(); 
            }
        }


       

        // enregistrement des donnees dans la deuxieme colonne...
        $get_synthese_note = Synthesenotes::where("groupepedagogique_id",$request->classe)
        ->where("synthesenotes.code_bulletin",$request->bulletin)
        ->get();
        $notes_two = Notes::join("sessioncorrections","sessioncorrections.id","=","notes.sessioncorrection_id")
        ->join("examenprogs","examenprogs.id","=","sessioncorrections.examen_prog_id")
        ->join("examens","examens.id","=","examenprogs.examen_id") 
        ->join("matieres","matieres.id","=","examenprogs.matiere_id") 
        ->where("notes.groupepedagogique_id",$request->classe)
        ->where("matieres.groupepedagogique_id",$request->classe)
        ->where("examens.colonnes",2)
        ->where("examens.code_bulletin",$request->bulletin)
        ->get(["notes.id","notes.etudiant_id","notes.groupepedagogique_id","notes.examen_prog_id","notes.note_examen","matieres.id as matiere_id"]);

        if ($notes_two->count() > 0) {
            # code...
            foreach ($get_synthese_note as $key => $data) {
                # code...
                foreach ($notes_two as $key => $notes_tw) {
                    # code...
                    if ($notes_tw->etudiant_id == $data->etudiant_id && $notes_tw->groupepedagogique_id == $data->groupepedagogique_id && $notes_tw->matiere_id == $data->getExamenprog->matiere_id ) {
                        # code...

                        $synthese_note = Synthesenotes::find($data->id); 
                        $note = $notes_tw->note_examen ? $notes_tw->note_examen : 0;
                        $synthese_note->setAttribute("note_second",$note);
                        $synthese_note->update(); 
                    }
                }
            }
        }
    

        // enregistrement des donnees dans la premiere colonne
        $notes_tree = Notes::join("sessioncorrections","sessioncorrections.id","=","notes.sessioncorrection_id")
        ->join("examenprogs","examenprogs.id","=","sessioncorrections.examen_prog_id")
        ->join("examens","examens.id","=","examenprogs.examen_id") 
        ->join("matieres","matieres.id","=","examenprogs.matiere_id") 
        ->where("notes.groupepedagogique_id",$request->classe)
        ->where("matieres.groupepedagogique_id",$request->classe)
        ->where("examens.colonnes",3)
        ->where("examens.code_bulletin",$request->bulletin)
        ->get(["notes.id","notes.etudiant_id","notes.groupepedagogique_id","notes.examen_prog_id","notes.note_examen","matieres.id as matiere_id"]);

        if ($notes_tree->count() > 0) {
            # code...
            foreach ($get_synthese_note as $key => $value) {
                # code...
                foreach ($notes_tree as $key => $notes_tre) {
                    # code...
                    if ($notes_tre->etudiant_id == $value->etudiant_id && $notes_tre->groupepedagogique_id == $value->groupepedagogique_id && $notes_tre->matiere_id == $value->getExamenprog->matiere_id  ) {
                        # code...
                        $synthese_note = Synthesenotes::find($value->id); 
                        $note = $notes_tre->note_examen ? $notes_tre->note_examen : 0;
                        $synthese_note->setAttribute("devoir",$note);
                        $synthese_note->update(); 
                    }
                }
            }
        }
 
        $gp = Groupepedagogiques::all();
        $bulletins = Bulletinprog::all();
        $get_gp = Groupepedagogiques::find($request->classe);
        $get_bulletin = Bulletinprog::where("code",$request->bulletin)->first();
        $liste_notes = Synthesenotes::where("groupepedagogique_id",$request->classe)
        ->where("code_bulletin",$request->bulletin)
        ->get();
        $update = true; 
        return view("frontend.bulletins.generer_note",compact("gp","bulletins","update","get_bulletin","get_gp","liste_notes"));
    }


}

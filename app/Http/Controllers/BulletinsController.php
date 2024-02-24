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
use App\Models\Synthesebulletins;

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
                $notesSectionEng[] = $data;
            }

            }
        }

        $synt_bulletin = Synthesebulletins::where("code_bulletin",$codeBulletin)
        ->where("etudiant_id",$etudiant_id)
        ->first();
        $bulletin_info = Bulletinprog::where("code",$codeBulletin)->first();
        $pdf = Pdf::loadView('frontend.bulletins.template', compact('bulletin_info', 'synt_bulletin', 'etudiant', 'bulletinData', 'personne', 'notesSectionFrench', 'notesSectionEng'));
        return $pdf->stream();
    }

    public function impressionMasse($codeBulletin,$gp)
    {     
        $bulletinData = Synthesebulletins::where('code_bulletin', $codeBulletin)
        ->where('groupepedagogique_id', $gp)
        ->get();  
        $synt_bulletin = Synthesebulletins::where("code_bulletin",$codeBulletin)
        //->where("etudiant_id",$etudiant_id)
        ->get();
        $bulletin_info = Bulletinprog::where("code",$codeBulletin)->first();
        $pdf = Pdf::loadView('frontend.bulletins.impression_masse', compact('bulletin_info', 'synt_bulletin', 'bulletinData','codeBulletin','gp'));
        return $pdf->stream();  

    }

    public function genereNote(){

        $gp = Groupepedagogiques::all();
        $bulletins = Bulletinprog::all();
        $update = false;
        return view("frontend.bulletins.generer_note",compact("gp","bulletins","update"));
    }

    public function consultationNote(Request $request,$etudiant,$gp,$bulletin){

        $etudiant = \Crypt::decrypt($etudiant);
        $get_gp = Groupepedagogiques::find($gp);
        $get_bulletin = Bulletinprog::where("code",$bulletin)->first();
        $liste_notes = Synthesenotes::where("groupepedagogique_id",$gp)
        ->where("code_bulletin",$bulletin)
        ->where("etudiant_id",$etudiant)
        ->get();

        $liste_moyennes = Synthesebulletins::where("groupepedagogique_id",$gp)
        ->where("code_bulletin",$bulletin)
        ->where("etudiant_id",$etudiant)
        ->orderBy("rang","ASC")
        ->get();

        $update = true;
        $get_etudiant = Etudiants::find($etudiant);
        return view("frontend.bulletins.consultation_note",compact("get_bulletin","get_gp","liste_notes","liste_moyennes","get_etudiant"));

    }

    public function saveAppreciation(Request $request){
        /*
        $this->validate($request, [
           // 'bulletin' => 'required',
           // 'classe' => 'required',
        ]);

        $count_notes = Synthesenotes::where("groupepedagogique_id",$request->classe)
        ->where("code_bulletin",$request->bulletin)->count();


            // enregistrement
            $data = $request->bulletin_id;
            $appreciation_fr = $request->appreciation_fr;
            $appreciation_en = $request->appreciation_en;

            foreach ($data as $key => $bulletin_id) {
                # code...
                if (!empty($bulletin_id)) {
                    # code...
                $synt_bulletin = Synthesebulletins::find($bulletin_id);
                $synt_bulletin->setAttribute("appreciation_fr",$appreciation_fr[$key]);
                $synt_bulletin->setAttribute("appreciation_en",$appreciation_en[$key]);
                $synt_bulletin->save();
                }
            }

            $gp = Groupepedagogiques::all();
            $bulletins = Bulletinprog::all();
            $get_gp = Groupepedagogiques::find($request->classe);
            $get_bulletin = Bulletinprog::where("code",$request->bulletin)->first();
            $liste_notes = Synthesenotes::where("groupepedagogique_id",$request->classe)
            ->where("code_bulletin",$request->bulletin)
            ->get();
            $liste_moyennes = Synthesebulletins::where("groupepedagogique_id",$request->classe)
            ->where("code_bulletin",$request->bulletin)
            ->orderBy("rang","ASC")
            ->get();
            $update = true;

            return view("frontend.bulletins.generer_note",compact("gp","bulletins","update","get_bulletin","get_gp","liste_notes","liste_moyennes"))->with("success","Enregistrement effectue avec succes.");
        */
    }

    public function saveNote(Request $request){
        $this->validate($request, [
            'bulletin' => 'required',
            'classe' => 'required',
        ]); 

        if (isset($_POST['impression_masse']) && empty($request->bulletin) && empty($request->classes)) { 
           return redirect()->route("bulletins.impression_masse",['codeBulletin'=>$request->bulletin,'gp'=>$request->classes]);
        }


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
            $liste_moyennes = Synthesebulletins::where("groupepedagogique_id",$request->classe)
        ->where("code_bulletin",$request->bulletin)
        ->orderBy("rang","ASC")
        ->get();
            $update = true;
            return view("frontend.bulletins.generer_note",compact("gp","bulletins","update","get_bulletin","get_gp","liste_notes","liste_moyennes"));
        }
        // save appreciation
        if (isset($_POST['valider_appreciation'])) {
            // enregistrement
            $data = $request->bulletin_id;
            $appreciation_fr = $request->appreciation_fr;
            $appreciation_en = $request->appreciation_en;

            foreach ($data as $key => $bulletin_id) {
                # code...
                if (!empty($bulletin_id)) {
                    # code...
                $synt_bulletin = Synthesebulletins::find($bulletin_id);
                $synt_bulletin->setAttribute("appreciation_fr",$appreciation_fr[$key]);
                $synt_bulletin->setAttribute("appreciation_en",$appreciation_en[$key]);
                $synt_bulletin->save();
                }
            }

            $gp = Groupepedagogiques::all();
            $bulletins = Bulletinprog::all();
            $get_gp = Groupepedagogiques::find($request->classe);
            $get_bulletin = Bulletinprog::where("code",$request->bulletin)->first();
            $liste_notes = Synthesenotes::where("groupepedagogique_id",$request->classe)
            ->where("code_bulletin",$request->bulletin)
            ->get();
            $liste_moyennes = Synthesebulletins::where("groupepedagogique_id",$request->classe)
            ->where("code_bulletin",$request->bulletin)
            ->orderBy("rang","ASC")
            ->get();
            $update = true;
            return view("frontend.bulletins.generer_note",compact("gp","bulletins","update","get_bulletin","get_gp","liste_notes","liste_moyennes"))->with("success","Enregistrement effectué avec succès.");
        }

        if ($count_notes > 0) {
            $delete = $count_notes = Synthesenotes::where("groupepedagogique_id",$request->classe)
            ->where("code_bulletin",$request->bulletin)->delete();
            // delete synthese note for this class
            //$delete_bulletin = $count_notes = Synthesebulletins::where("groupepedagogique_id",$request->classe)
            //->where("code_bulletin",$request->bulletin)->delete();
        }

        // liste des examens
        $examens = Examens::where("code_bulletin",$request->bulletin)->get();
        if ($examens->count() == 3) {
            # code...

        } else {
            # code...
          //  return redirect()->route("bulletins.generer-note")->with('error', "Nombre d'examen superieur a 3, impossible de traiter la demande pour l'instant");

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

        // get eleves by class
        $liste_eleves = Etudiants::where("groupepedagogique_id",$request->classe)->get();
        // calcul des moyennes par matiere
        $get_current_liste_notes = Synthesenotes::where("groupepedagogique_id",$request->classe)
        ->where("code_bulletin",$request->bulletin)
        ->get();
        $test = 0;
        foreach ($liste_eleves as $key => $eleve) {
            # code...
            $count = 0; $somme_moyenne = 0; $somme_coef = 0;

            foreach ($get_current_liste_notes as $key => $g_note) {
                # code...
                if ($g_note->etudiant_id == $eleve->id) {
                    $test++;
                    # code... my = ( n1*coef + n2*coef + n3*coef ) / 5 / coef
                    $my = round(($g_note->note_first*$g_note->getExamenprog->getMatiere->coef + $g_note->note_second*$g_note->getExamenprog->getMatiere->coef + $g_note->devoir*$g_note->getExamenprog->getMatiere->coef)/5/$g_note->getExamenprog->getMatiere->coef,2);
                    $my_devoir = $g_note->note_first + $g_note->note_second;
                    $count = $count + 1;
                    $somme_moyenne = $somme_moyenne + $my;
                    $somme_coef = $somme_coef + $g_note->getExamenprog->getMatiere->coef;
                    $update_note = Synthesenotes::find($g_note->id);
                    $update_note->setAttribute("moyenne",$my);
                    $update_note->update();
                }

            }

            // check if eleve have the note
            if($count > 0 && $somme_moyenne > 0){
                // check if data exist
                $check_synthese_bulletin = Synthesebulletins::where("groupepedagogique_id",$request->classe)
                ->where("code_bulletin",$request->bulletin)
                ->where("etudiant_id",$eleve->id)
                ->first();

                if ($check_synthese_bulletin) {
                    # code...
                
                // update data int table synthese bulletin  
                $check_synthese_bulletin->setAttribute("moyenne",round($somme_moyenne/$somme_coef,2)); 
                $check_synthese_bulletin->update();

                } else {
                    # code...
                
                // insert data int table synthese bulletin
                $insert_synthesebulletin = new Synthesebulletins();
                $insert_synthesebulletin->setAttribute("groupepedagogique_id",$request->classe);
                $insert_synthesebulletin->setAttribute("etudiant_id",$eleve->id);
                $insert_synthesebulletin->setAttribute("moyenne",round($somme_moyenne/$somme_coef,2));
                $insert_synthesebulletin->setAttribute("code_bulletin",$request->bulletin);
                $insert_synthesebulletin->save();
                }
            }

        }

        // update rang
        $get_current_liste_notes = Synthesebulletins::where("groupepedagogique_id",$request->classe)
        ->where("code_bulletin",$request->bulletin)
        ->orderBy("moyenne","DESC")
        ->get();

        $rang = 0;
        foreach ($get_current_liste_notes as $key => $value) {
            # code...
            $rang = $rang + 1;
            $up = Synthesebulletins::find($value->id);
            $up->setAttribute("rang",$rang);
            $up->update();
        }


        $gp = Groupepedagogiques::all();
        $bulletins = Bulletinprog::all();
        $get_gp = Groupepedagogiques::find($request->classe);
        $get_bulletin = Bulletinprog::where("code",$request->bulletin)->first();
        $liste_notes = Synthesenotes::where("groupepedagogique_id",$request->classe)
        ->where("code_bulletin",$request->bulletin)
        ->get();

        $liste_moyennes = Synthesebulletins::where("groupepedagogique_id",$request->classe)
        ->where("code_bulletin",$request->bulletin)
        ->orderBy("rang","ASC")
        ->get();
        $update = true;
        return view("frontend.bulletins.generer_note",compact("gp","bulletins","update","get_bulletin","get_gp","liste_notes","liste_moyennes"));
    }

    public function synthese($id, $codeBulletin)
    {
        $etudiant_id = \Crypt::decrypt($id);
        $etudiant = Etudiants::find($etudiant_id);
        $bulletinData = Synthesenotes::get()->where('etudiant_id', $etudiant_id)->where('code_bulletin', $codeBulletin);
        $bulletinSyn = Synthesebulletins::get()->where('etudiant_id', $etudiant_id)->where('code_bulletin', $codeBulletin);
        $personne = Personnes::where('id', $etudiant->getDossier->personne_id)->get()->first() ;

        $notesSectionFrench = [];
        $notesSectionEng = [];
        $liste_etudiants = Synthesebulletins::where("groupepedagogique_id",$etudiant->groupepedagogique_id)
            ->where("code_bulletin",$codeBulletin)
            ->orderBy("rang","ASC")
            ->get();
        foreach( $bulletinData as $data )
        {
            if (!empty($data) || !empty($data->examen_prog_id)) {
                # code...
                $matiere = Matieres::findOrFail($data->getExamenprog->matiere_id);

                if($matiere->section_id == 1)
                {
                    $notesSectionFrench[] = $data;
                }else{
                    $notesSectionEng[] = $data;
                }

            }
        }

        $synt_bulletin = Synthesebulletins::where("code_bulletin",$codeBulletin)
            ->where("etudiant_id",$etudiant_id)
            ->first();
        $bulletin_info = Bulletinprog::where("code",$codeBulletin)->first();
        $pdf = Pdf::loadView('frontend.bulletins.synthese', compact('bulletin_info','etudiant', 'bulletinData', 'personne', 'notesSectionFrench', 'notesSectionEng', 'bulletinSyn', 'synt_bulletin', 'liste_etudiants'));
        return $pdf->stream();
    }

}

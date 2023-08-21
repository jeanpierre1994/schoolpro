<?php

namespace App\Http\Controllers;

use App\Models\Notes;
use App\Models\Examens;
use App\Models\Matieres;
use App\Models\Etudiants;
use App\Models\Personnes;
use App\Models\Examenprog;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke( $id, $gp_id, $etudiant_id)
    {
        $id = \Crypt::decrypt($id);
        $gp_id = \Crypt::decrypt($gp_id);
        $etudiant_id = \Crypt::decrypt($etudiant_id);
        $examen = Examens::find($id);
        $etudiant = Etudiants::find($etudiant_id);
        $examenprogs = Examenprog::where('examen_id', $examen->id)
                        ->join('matieres',"examenprogs.matiere_id","matieres.id")
                        ->where("matieres.groupepedagogique_id",$gp_id)
                        ->get();
        $notes=Notes::
            join("examenprogs","examenprogs.id","=","notes.examen_prog_id")
            ->join("matieres","matieres.id","=","examenprogs.matiere_id")
            ->where("examenprogs.examen_id",$examen->id)
            ->where("notes.groupepedagogique_id", $gp_id)
            ->where("notes.etudiant_id", $etudiant_id)
            ->get();
        $notesSectionFrench = [];
        $notesSectionEng = [];
        foreach( $notes as $note )
        { 
            if (!empty($note) || !empty($note->examen_prog_id)) {
                # code...
            $matiere = Matieres::findOrFail($note->getExamenprog->matiere_id);
            if($matiere->section_id == 1)
            {
                $notesSectionFrench[] = $note;
            }else{
                $notesSectionEng[] = $note;            }

            }
        }

        $personne = Personnes::where('id', $etudiant->getDossier->personne_id)->get()->first() ;
        $pdf = Pdf::loadView('frontend.bulletins.pdf', compact('notesSectionFrench', 'notesSectionEng', 'etudiant', 'examen', 'personne'));
        return $pdf->stream();
    }
}

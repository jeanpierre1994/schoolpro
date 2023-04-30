<?php

namespace App\Http\Controllers;

use App\Models\Etudiants;
use App\Models\Examenprog;
use App\Models\Notes;
use App\Models\Profil;
use App\Models\Sessioncorrections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessioncorrectionController extends Controller
{
    public function index()
    {
        //$sessioncorrections = Sessioncorrections::where("professeur_id", auth()->user()->id)->get();
        // vérifier le profil de l'utilisateur connecter 
        $user_profil = Profil::find(Auth()->user()->profil_id);
        if ($user_profil) {
            # code...
            switch ($user_profil->libelle) {
                case "PROFESSEUR":
                    # code...
                    $examenprog = Examenprog::join("examens", "examens.id", "=", "examenprogs.id")
                        ->join("matieres", "matieres.id", "=", "examenprogs.matiere_id")
                        ->join("groupepedagogiques", "groupepedagogiques.id", "=", "matieres.groupepedagogique_id")
                        ->join("matiereprofesseurs", "matieres.id", "=", "matiereprofesseurs.matiere_id")
                        ->where("matiereprofesseurs.professeur_id", Auth()->user()->id)
                        ->where("examens.statut_id", 1)
                        ->select(["examenprogs.id", "examens.code_examen", "examens.libelle", "groupepedagogiques.libelle_classe", "matieres.libelle as matiere"])
                        ->get();
                    break;

                case "ADMIN":
                    # code...
                    $examenprog = Examenprog::join("examens", "examens.id", "=", "examenprogs.id")
                        ->join("matieres", "matieres.id", "=", "examenprogs.matiere_id")
                        ->join("groupepedagogiques", "groupepedagogiques.id", "=", "matieres.groupepedagogique_id")
                        ->join("matiereprofesseurs", "matieres.id", "=", "matiereprofesseurs.matiere_id")
                        ->where("examens.statut_id", 1)
                        ->select(["examenprogs.id", "examens.code_examen", "examens.libelle", "groupepedagogiques.libelle_classe", "matieres.libelle as matiere"])
                        ->get();
                    break;

                default:
                    # code...
                    return redirect()->back()->with("error", "Votre profil n'est pas autorisé à accéder à cette ressource.");
                    break;
            }
        } else {
            # code...
            return redirect()->back()->with("error", "Profil de l'utilisateur inconnu.");
        }


        return view("backend.administrations.sessioncorrections.index", compact("examenprog"));
    }

    public function create(Request $request, $id)
    {
        $examenprog = Examenprog::find($id);
        $user_profil = Profil::find(Auth()->user()->profil_id);
        $prof = Auth()->user();
        if ($user_profil) {
            # code...
            switch ($user_profil->libelle) {
                case "PROFESSEUR":
                    # code...
                    // vérifier si une session de correction est ouverte ?
                    $check_data = Sessioncorrections::where("professeur_id", Auth()->user()->id)->where("examen_prog_id", $id)->exists();
                    if ($check_data) {
                        # code...
                        $session = Sessioncorrections::where("professeur_id", $prof->id)->where("examen_prog_id", $id)->first();
                        $notes_etudiants_valide = Notes::where("examen_prog_id", $id)->where("professeur_id", $prof->id)->where("statutvalidation_id", 2)->count();
                        $notes_etudiants_encours = Notes::where("examen_prog_id", $id)->where("professeur_id", $prof->id)->where("statutvalidation_id", 1)->get();
                        return view("backend.administrations.sessioncorrections.save_note", compact("session", "notes_etudiants_valide", "notes_etudiants_encours"));
                    } else {

                        // récupérer la liste des étudiants/élèves du groupe pédagogique en cours
                        $etudiants = Etudiants::where("groupepedagogique_id", $examenprog->getExamen->groupepedagogique_id)->get();
                        if ($etudiants->count() > 0) {
                            # code...
                            $session = new Sessioncorrections();
                            $session->setAttribute("examen_prog_id", $id);
                            $session->setAttribute("professeur_id", $prof->id);
                            $session->setAttribute("nbre_etudiant", 0);
                            $session->setAttribute("statutvalidation_id", 1);
                            $session->setAttribute("created_by", $prof->id);
                            $session->setAttribute("updated_by", $prof->id);
                            $session->save();

                            # code...
                            foreach ($etudiants as $etudiant) {
                                # code...
                                $note = new Notes();
                                $note->setAttribute("sessioncorrection_id", $session->id);
                                $note->setAttribute("examen_prog_id", $id);
                                $note->setAttribute("groupepedagogique_id", $examenprog->getExamen->groupepedagogique_id);
                                $note->setAttribute("etudiant_id", $etudiant->id);
                                $note->setAttribute("professeur_id", $prof->id);
                                $note->setAttribute("statutvalidation_id", 1);
                                $note->setAttribute("created_by", $prof->id);
                                $note->save();
                            }
                        } else {
                            # code...
                            return redirect()->back()->with("error", "Ce groupe pédagogique ne possède pas encore d'étudiant.");
                        }

                        $notes_etudiants_valide = 0;
                        $notes_etudiants_encours = Notes::where("examen_prog_id", $id)->where("professeur_id", $prof->id)->where("statutvalidation_id", 1)->get();
                        return view("backend.administrations.sessioncorrections.save_note", compact("session", "notes_etudiants_valide", "notes_etudiants_encours"));
                    }

                    break;

                case "ADMIN":
                    # code...
                    return redirect()->back()->with("error", "Uniquement les professeurs ont le privilège de créer des sessions de correction.");
                    break;

                default:
                    # code...
                    return redirect()->back()->with("error", "Votre profil n'est pas autorisé à accéder à cette ressource.");
                    break;
            }
        } else {
            # code...
            return redirect()->back()->with("error", "Profil de l'utilisateur inconnu.");
        }
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
            'note' => 'required',
            'note_id' => 'required'
        ]);

        try {
            $notes = $request->note;
            $notes_id = $request->note_id;
            $commentaires = $request->commentaire;
            $prof_id = Auth()->user()->id;

            foreach ($notes as $key => $note) {
                if (!empty($note)) {
                    # code...
                    // initialisation des variables
                    $note_etudiant = $notes[$key];
                    $note_id = $notes_id[$key];
                    $commentaire = $commentaires[$key];
                    // mise à jour des informations
                    $note_objet = Notes::find($note_id);
                    $note_objet->setAttribute("note_examen", $note_etudiant);
                    $note_objet->setAttribute("note", $note_etudiant);
                    $note_objet->setAttribute("commentaire", $commentaire);
                    $note_objet->setAttribute("statutvalidation_id", 2);
                    $note_objet->update();
                }
            }
            return redirect()->back()->with("success", "Note enregistré avec succès");
        } catch (\Throwable $th) {
            return redirect()->back()->with("error", "Echec lors de l'enregistrement des donnéees.");
        }
    }

    public function listeEtudiant(Request $request, $id)
    {
        $notes = Notes::where("statutvalidation_id", 2)->where("sessioncorrection_id", $id)->get();
        $session = Sessioncorrections::find($id);
        $user_profil = Profil::find(Auth()->user()->profil_id); 
        if ($user_profil) {
            # code...
            switch ($user_profil->libelle) {
                case "PROFESSEUR": 
                        return view("backend.administrations.sessioncorrections.liste_etudiants", compact("notes","session"));
                   
                    break;

                case "ADMIN":
                    # code...
                    return view("backend.administrations.sessioncorrections.liste_etudiants", compact("notes","session"));
                    break;

                default:
                    # code...
                    return redirect()->back()->with("error", "Votre profil n'est pas autorisé à accéder à cette ressource.");
                    break;
            }
        } else {
            # code...
            return redirect()->back()->with("error", "Profil de l'utilisateur inconnu.");
        }
    }
}

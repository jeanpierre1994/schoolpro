<?php

namespace App\Http\Controllers;

use App\Models\Etudiants;
use App\Models\Examenprog;
use App\Models\Examens;
use App\Models\Groupepedagogiques;
use App\Models\Matiereprofesseurs;
use App\Models\Notes;
use App\Models\Profil;
use App\Models\Sessioncorrections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

class SessioncorrectionController extends Controller
{
    public function indexOld()
    {
        //$sessioncorrections = Sessioncorrections::where("professeur_id", auth()->user()->id)->get();
        // vérifier le profil de l'utilisateur connecter 
          $user_profil = Profil::find(Auth()->user()->profil_id);
        if ($user_profil) {
            # code...
            switch ($user_profil->libelle) {
                case "PROFESSEUR":
                    # code... 
                    $examenprog = Matiereprofesseurs::
                    where("matiereprofesseurs.professeur_id", Auth()->user()->id)
                    ->join("matieres","matiereprofesseurs.matiere_id","=","matieres.id")
                    ->leftjoin("groupepedagogiques", "groupepedagogiques.id", "=", "matieres.groupepedagogique_id")
                    ->leftjoin("poles","groupepedagogiques.pole_id","=","poles.id")
                    ->leftjoin("niveaux","groupepedagogiques.niveau_id","=","niveaux.id")
                    ->leftjoin("cycles","groupepedagogiques.cycle_id","=","cycles.id")
                    ->leftjoin("filieres","groupepedagogiques.filiere_id","=","filieres.id")
                    ->join("examenprogs","matieres.id","=","examenprogs.matiere_id")
                    ->leftjoin("examens", "examens.id", "=", "examenprogs.examen_id") 
                    ->where("examens.statut_id", 1)
                    ->select(["examenprogs.id", "examens.code_examen", "examens.libelle", "groupepedagogiques.id as id_gp","groupepedagogiques.libelle_classe","groupepedagogiques.libelle_secondaire", "matieres.libelle as matiere","poles.libelle as pole","niveaux.libelle as niveau","filieres.libelle as filiere"])
                    ->get();
                       // dd(Auth()->user()->id);
                    break;

                case "ADMIN":
                    # code...
                    $examenprog = Matiereprofesseurs::
                    join("matieres","matiereprofesseurs.matiere_id","=","matieres.id")
                    ->leftjoin("groupepedagogiques", "groupepedagogiques.id", "=", "matieres.groupepedagogique_id")
                    ->leftjoin("poles","groupepedagogiques.pole_id","=","poles.id")
                    ->leftjoin("niveaux","groupepedagogiques.niveau_id","=","niveaux.id")
                    ->leftjoin("cycles","groupepedagogiques.cycle_id","=","cycles.id")
                    ->leftjoin("filieres","groupepedagogiques.filiere_id","=","filieres.id")
                    ->join("examenprogs","matieres.id","=","examenprogs.matiere_id")
                    ->leftjoin("examens", "examens.id", "=", "examenprogs.examen_id") 
                    ->where("examens.statut_id", 1)
                    ->select(["examenprogs.id", "examens.code_examen", "examens.libelle", "groupepedagogiques.id as id_gp","groupepedagogiques.libelle_classe","groupepedagogiques.libelle_secondaire", "matieres.libelle as matiere","poles.libelle as pole","niveaux.libelle as niveau","filieres.libelle as filiere"])
                    ->get(); 
                    /*$examenprog = Groupepedagogiques::
                    join("matieres", "groupepedagogiques.id", "=", "matieres.groupepedagogique_id")
                    ->get()->count();*/
                    //dd($examenprog);
                    // groupe pédagogique

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
 
        return view("backend.administrations.sessioncorrections.index_old", compact("examenprog"));
    }

    public function index()
    { 
        $gp = Groupepedagogiques::all();
        return view("backend.administrations.sessioncorrections.index", compact("gp")); 
    }



    public function listeEtudiantByGP(Request $request, $id)
    {
        $etudiants = Etudiants::where("groupepedagogique_id", $id)->orderBy("matricule", "asc")->get();
        $gp = Groupepedagogiques::find($id);
        return view("backend.administrations.sessioncorrections.gp_etudiants", compact("etudiants", "gp"));
    }
    // showNoteEtudiant
    public function showNoteEtudiant(Request $request, $id, $etudiant_id, $examen_id=null)
    {
        $examens = Examens::all(); 
        $gp = Groupepedagogiques::find($id);
        $choix_examen = false;
        $user = auth()->user();
        $notes_etudiants_encours = null;
        $examen = null;

        if (isset($_POST["examen_id"]) && !empty($_POST["examen_id"])) { // choix examen is submit
            $choix_examen = true;
            $examen_id = $_POST["examen_id"];
            # code...
        } elseif (isset($_GET["examen_id"]) && !empty($_GET["examen_id"])) {
            # code...
            $choix_examen = true;
            $examen_id = $_GET["examen_id"];
        }elseif(!empty($examen_id)){
            $choix_examen = true;
        } 

        if ($choix_examen) {
            # code...

            // vérifier si la session de correction est déjà généré
            $check_data = Sessioncorrections::
            join("examenprogs", "examenprogs.id", "=", "sessioncorrections.examen_prog_id")
            ->join("matieres", "matieres.id", "=", "examenprogs.matiere_id")
            ->where("groupepedagogique_id", $id)
            ->exists();

            if (!$check_data) { 
                $etudiants = Etudiants::where("groupepedagogique_id", $id)->get();
                if ($etudiants->count() > 0) {
                    // généré la session de correction pour toutes les matières
                    $listeExamenProg = Examenprog::join("matieres", "matieres.id", "=", "examenprogs.matiere_id")
                        ->where("examen_id", $examen_id)
                        ->where("matieres.groupepedagogique_id", $id)
                        ->get(["examenprogs.id"]);

                    foreach ($listeExamenProg as $value) {
                        # code...
                        # code...
                        $session = new Sessioncorrections();
                        $session->setAttribute("examen_prog_id", $value->id);
                        $session->setAttribute("generer_par", $user->id);
                        $session->setAttribute("nbre_etudiant", 0);
                        $session->setAttribute("statutvalidation_id", 1);
                        $session->setAttribute("created_by", $user->id);
                        $session->setAttribute("updated_by", $user->id);
                        $session->save();

                        # code...
                        foreach ($etudiants as $etudiant) {
                            # code...
                            $note = new Notes();
                            $note->setAttribute("sessioncorrection_id", $session->id);
                            $note->setAttribute("examen_prog_id", $session->examen_prog_id);
                            $note->setAttribute("groupepedagogique_id", $id);
                            $note->setAttribute("etudiant_id", $etudiant->id);
                            $note->setAttribute("enregistrer_par", $user->id);
                            $note->setAttribute("statutvalidation_id", 1);
                            $note->setAttribute("created_by", $user->id);
                            $note->save();
                        }
                    }
                }
            }

            // liste des notes par matière
            $notes_etudiants_encours = Notes::
            join("examenprogs","examenprogs.id","=","notes.examen_prog_id")
            ->join("matieres","matieres.id","=","examenprogs.matiere_id")
            ->where("examenprogs.examen_id",$examen_id)
            ->where("notes.groupepedagogique_id", $id)
            ->where("notes.etudiant_id", $etudiant_id)
            ->get(["notes.id","notes.examen_prog_id","matieres.libelle","notes.note","notes.commentaire"]); 
           
            $examen = Examens::find($examen_id);
        }

        $etudiant = Etudiants::find($etudiant_id);

        return view("backend.administrations.sessioncorrections.gp_note_etudiant", compact("etudiant", "gp", "examens","notes_etudiants_encours","choix_examen","examen"));
    }

    public function create(Request $request, $id)
    {
        $examenprog = Examenprog::find($id);
        $prof = Auth()->user();
        $gp = Groupepedagogiques::all();
        /*$user_profil = Profil::find(Auth()->user()->profil_id);
        $prof = Auth()->user();
        if ($user_profil) {
            # code...
            switch ($user_profil->libelle) {
                case "PROFESSEUR":*/
        # code...
        // vérifier si une session de correction est ouverte ?
       // $notes = Notes::where("statutvalidation_id", 1)->where("examen_prog_id", $id)->where("groupepedagogique_id",$request->id_gp)->get();

        $check_data = Sessioncorrections::where("examen_prog_id", $id)->exists();
        if ($check_data) {
            # code...
             // get note
             $get_note = Notes::where("examen_prog_id", $id)->where("groupepedagogique_id",$request->id_gp)->first();
             if($get_note){
                 $session = Sessioncorrections::find($get_note->sessioncorrection_id );

                 $notes_etudiants_valide = Notes::where("examen_prog_id", $id)->where("statutvalidation_id", 2)->where("groupepedagogique_id",$request->id_gp)->count();
                 $notes_etudiants_encours = Notes::where("examen_prog_id", $id)->where("groupepedagogique_id",$request->id_gp)->get();
                  

             }else{

                 return redirect()->back()->with("error","Pas de liste disponible.");
             }
             
            return view("backend.administrations.sessioncorrections.save_note", compact("session", "notes_etudiants_valide", "notes_etudiants_encours", "gp"));
        } else {
            //dd($examenprog->getMatiere->groupepedagogique_id);
            // récupérer la liste des étudiants/élèves du groupe pédagogique en cours
            $etudiants = Etudiants::where("groupepedagogique_id", $examenprog->getMatiere->groupepedagogique_id)->get();
            if ($etudiants->count() > 0) {
                # code...
                $session = new Sessioncorrections();
                $session->setAttribute("examen_prog_id", $id);
                //$session->setAttribute("professeur_id", $prof->id);
                $session->setAttribute("generer_par", $prof->id);
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
                    $note->setAttribute("groupepedagogique_id", $examenprog->getMatiere->groupepedagogique_id);
                    $note->setAttribute("etudiant_id", $etudiant->id);
                    //$note->setAttribute("professeur_id", $prof->id);
                    $note->setAttribute("statutvalidation_id", 1);
                    $note->setAttribute("enregistrer_par", $prof->id);
                    $note->setAttribute("created_by", $prof->id);
                    $note->save();
                }
            } else {
                # code...
                return redirect()->back()->with("error", "Ce groupe pédagogique ne possède pas encore d'étudiant.");
            }

            $notes_etudiants_valide = 0;
            $notes_etudiants_encours = Notes::where("examen_prog_id", $id)->get();
            return view("backend.administrations.sessioncorrections.save_note", compact("session", "notes_etudiants_valide", "notes_etudiants_encours", "gp"));
        }

        /*   break;

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
        }*/
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
            'note_id' => 'required',
            'gp_id' => 'required',
            'etudiant_id' => 'required',
            'examen_id' => 'required',
        ]);

        try {
            $notes = $request->note;
            $notes_id = $request->note_id;
            $commentaires = $request->commentaire; 

            foreach ($notes as $key => $note) { 
                    # code...
                    // initialisation des variables
                    $note_etudiant = $notes[$key];
                    $note_id = $notes_id[$key];
                    $commentaire = $commentaires[$key];
                    if (!empty($notes_id[$key]) && $notes_id[$key] != null  && !empty($notes[$key]) && $notes[$key] != null ) {
                        # code...
                       // dd($note_etudiant);
                        // mise à jour des informations
                    $note_objet = Notes::find($note_id);
                    $note_objet->setAttribute("note_examen", $note_etudiant);
                    $note_objet->setAttribute("note", $note_etudiant);
                    $note_objet->setAttribute("commentaire", $commentaire);
                    $note_objet->setAttribute("statutvalidation_id", 2);
                    $note_objet->update();
                    } 

                   
            }  
            return redirect()->route("sessioncorrections.show-note",['id'=> $request->gp_id, 'etudiant_id' => $request->etudiant_id, 'examen_id'=>$request->examen_id])->with("success", "Note enregistré avec succès");
        } catch (\Throwable $th) {
            
            return redirect()->route("sessioncorrections.show-note",['id'=> $request->gp_id, 'etudiant_id' => $request->etudiant_id, 'examen_id'=>$request->examen_id])->with("error", "Echec lors de l'enregistrement des donnéees. ".$th);
        }
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeOld(Request $request)
    {
        //Enrégistrements du statuts
        $this->validate($request, [
            'note' => 'required',
            'note_id' => 'required',
            'gp_id' => 'required', 
            'examen_id' => 'required',
        ]);

        try {
            $notes = $request->note;
            $notes_id = $request->note_id;
            $commentaires = $request->commentaire; 

            foreach ($notes as $key => $note) { 
                    # code...
                    // initialisation des variables
                    $note_etudiant = $notes[$key];
                    $note_id = $notes_id[$key];
                    $commentaire = $commentaires[$key];
                    if (!empty($notes_id[$key]) && $notes_id[$key] != null  && !empty($notes[$key]) && $notes[$key] != null ) {
                        # code...
                       // dd($note_etudiant);
                        // mise à jour des informations
                    $note_objet = Notes::find($note_id);
                    $note_objet->setAttribute("note_examen", $note_etudiant);
                    $note_objet->setAttribute("note", $note_etudiant);
                    $note_objet->setAttribute("commentaire", $commentaire);
                    $note_objet->setAttribute("statutvalidation_id", 2);
                    $note_objet->update();
                    } 

                   
            }  
            return redirect()->route("sessionscorrections.create",['id'=> $request->examenprog_id,'id_gp'=>$request->gp_id])->with("success", "Note enregistré avec succès");
        } catch (\Throwable $th) {
            
            return redirect()->route("sessionscorrections.create",['id'=> $request->examenprog_id,'id_gp'=>$request->gp_id])->with("error", "Echec lors de l'enregistrement des donnéees. ".$th);
        }
    }

    public function listeEtudiant(Request $request, $id)
    {
        
        $user_profil = Profil::find(Auth()->user()->profil_id);
        if ($user_profil) {
            # code...
            switch ($user_profil->libelle) {
                case "PROFESSEUR":
                    $session = Sessioncorrections::where("examen_prog_id", $id)->where("generer_par", Auth()->user()->id)->first();
                    if($session){ 
                        $notes = Notes::where("sessioncorrection_id", $session->id)->where("groupepedagogique_id",$request->id_gp)->get();
                    }else{
                        return redirect()->back()->with("error","Vous n'avez pas de liste disponible.");
                    }
                    return view("backend.administrations.sessioncorrections.liste_etudiants", compact("notes", "session"));

                    break;

                case "ADMIN":
                    # code...
                    $check_session = Sessioncorrections::where("examen_prog_id", $id)->exists();
                    if($check_session){ 
                        
                        // get note
                        $get_note = Notes::where("examen_prog_id", $id)->where("groupepedagogique_id",$request->id_gp)->first();
                        if($get_note){
                            $session = Sessioncorrections::find($get_note->sessioncorrection_id );

                            $notes = Notes::where("examen_prog_id", $id)->where("groupepedagogique_id",$request->id_gp)->get();

                        }else{

                            return redirect()->back()->with("error","Pas de liste disponible.");
                        }
                    }else{
                        return redirect()->back()->with("error","Pas de liste disponible.");
                    }
                    return view("backend.administrations.sessioncorrections.liste_etudiants", compact("notes", "session"));
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

    public function indexNew(Request $request){
        $examens = Examens::all(); 
        $send_form = false; 


        //check if form is submit 
        if( isset($_POST['examen']) && !empty($_POST['examen']) && isset($_POST['classe']) && !empty($_POST['classe']) && isset($_POST['matiere']) && !empty($_POST['matiere']) ){
          $id = $_POST['matiere'];
          $gp_id = $_POST['classe'];
            $examenprog = Examenprog::find($id);
        $prof = Auth()->user();
        $gp = Groupepedagogiques::all();
        $get_examen = Examens::find($_POST['examen']);
        $send_form = true;
       
        $check_data = Sessioncorrections::where("examen_prog_id", $id)->exists();
        if ($check_data) {
            # code...
             // get note
             $get_note = Notes::where("examen_prog_id", $id)->where("groupepedagogique_id",$gp_id)->first();
             if($get_note){
                 $session = Sessioncorrections::find($get_note->sessioncorrection_id );

                 $notes_etudiants_valide = Notes::where("examen_prog_id", $id)->where("statutvalidation_id", 2)->where("groupepedagogique_id",$gp_id)->count();
                 $notes_etudiants_encours = Notes::where("examen_prog_id", $id)->where("groupepedagogique_id",$gp_id)->get();
                  

             }else{

                 return redirect()->back()->with("error","Pas de liste disponible.");
             }
             
            return view("backend.administrations.sessioncorrections.new_index", compact("session", "notes_etudiants_valide", "notes_etudiants_encours", "gp","examens","get_examen","examenprog","send_form"));
      
        } else {
 
            // récupérer la liste des étudiants/élèves du groupe pédagogique en cours
            $etudiants = Etudiants::where("groupepedagogique_id", $examenprog->getMatiere->groupepedagogique_id)->get();
            if ($etudiants->count() > 0) {
                
                # code...
                $session = new Sessioncorrections();
                $session->setAttribute("examen_prog_id", $id);
                //$session->setAttribute("professeur_id", $prof->id);
                $session->setAttribute("generer_par", $prof->id);
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
                    $note->setAttribute("groupepedagogique_id", $examenprog->getMatiere->groupepedagogique_id);
                    $note->setAttribute("etudiant_id", $etudiant->id);
                    //$note->setAttribute("professeur_id", $prof->id);
                    $note->setAttribute("statutvalidation_id", 1);
                    $note->setAttribute("enregistrer_par", $prof->id);
                    $note->setAttribute("created_by", $prof->id);
                    $note->save();
                }
            } else {
                # code...
                return redirect()->back()->with("error", "Ce groupe pédagogique ne possède pas encore d'étudiant.");
            }

            $notes_etudiants_valide = 0;
            $notes_etudiants_encours = Notes::where("examen_prog_id", $id)->get();
            return view("backend.administrations.sessioncorrections.new_index", compact("session", "notes_etudiants_valide", "notes_etudiants_encours", "gp","examens","get_examen","examenprog","send_form"));

        } 
    }



    // if save note is submited 
        if(Session::has('examen') && Session::has('classe') && Session::has('matiere')){
            $id = Session::get('matiere');
            $gp_id = Session::get('classe');
              $examenprog = Examenprog::find($id);
          $prof = Auth()->user();
          $gp = Groupepedagogiques::all();
          $get_examen = Examens::find(Session::get('examen'));
          $send_form = true;

          // delete session variable
            Session::forget('classe'); // Removes a specific variable
            Session::forget('matiere'); // Removes a specific variable
            Session::forget('examen'); // Removes a specific variable
         
          $check_data = Sessioncorrections::where("examen_prog_id", $id)->exists();
          if ($check_data) {
              # code...
               // get note
               $get_note = Notes::where("examen_prog_id", $id)->where("groupepedagogique_id",$gp_id)->first();
               if($get_note){
                   $session = Sessioncorrections::find($get_note->sessioncorrection_id );
  
                   $notes_etudiants_valide = Notes::where("examen_prog_id", $id)->where("statutvalidation_id", 2)->where("groupepedagogique_id",$gp_id)->count();
                   $notes_etudiants_encours = Notes::where("examen_prog_id", $id)->where("groupepedagogique_id",$gp_id)->get();
                    
  
               }else{
  
                   return redirect()->back()->with("error","Pas de liste disponible.");
               }
               
              return view("backend.administrations.sessioncorrections.new_index", compact("session", "notes_etudiants_valide", "notes_etudiants_encours", "gp","examens","get_examen","examenprog","send_form"));
        
          } else {
   
              // récupérer la liste des étudiants/élèves du groupe pédagogique en cours
              $etudiants = Etudiants::where("groupepedagogique_id", $examenprog->getMatiere->groupepedagogique_id)->get();
              if ($etudiants->count() > 0) {
                  
                  # code...
                  $session = new Sessioncorrections();
                  $session->setAttribute("examen_prog_id", $id);
                  //$session->setAttribute("professeur_id", $prof->id);
                  $session->setAttribute("generer_par", $prof->id);
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
                      $note->setAttribute("groupepedagogique_id", $examenprog->getMatiere->groupepedagogique_id);
                      $note->setAttribute("etudiant_id", $etudiant->id);
                      //$note->setAttribute("professeur_id", $prof->id);
                      $note->setAttribute("statutvalidation_id", 1);
                      $note->setAttribute("enregistrer_par", $prof->id);
                      $note->setAttribute("created_by", $prof->id);
                      $note->save();
                  }
              } else {
                  # code...
                  return redirect()->back()->with("error", "Ce groupe pédagogique ne possède pas encore d'étudiant.");
              }
  
              $notes_etudiants_valide = 0;
              $notes_etudiants_encours = Notes::where("examen_prog_id", $id)->get();
              return view("backend.administrations.sessioncorrections.new_index", compact("session", "notes_etudiants_valide", "notes_etudiants_encours", "gp","examens","get_examen","examenprog","send_form"));
  
          } 
      }


    return view("backend.administrations.sessioncorrections.new_index",compact("examens","send_form"));

}


/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeNoteNew(Request $request)
    {
        //Enrégistrements du statuts
        $this->validate($request, [
            'note' => 'required',
            'note_id' => 'required',
            'gp_id' => 'required', 
            'examen_id' => 'required',
        ]);

        // enregistrement des donnees dans session
        $request->session()->put('matiere',$request->examenprog_id);
        $request->session()->put('examen',$request->examen_id);
        $request->session()->put('classe',$request->gp_id);

        try {
            $notes = $request->note;
            $notes_id = $request->note_id;
            $commentaires = $request->commentaire; 

            foreach ($notes as $key => $note) { 
                    # code...
                    // initialisation des variables
                    $note_etudiant = $notes[$key];
                    $note_id = $notes_id[$key];
                    $commentaire = $commentaires[$key];
                    if (!empty($notes_id[$key]) && $notes_id[$key] != null  && !empty($notes[$key]) && $notes[$key] != null ) {
                        # code...
                       // dd($note_etudiant);
                        // mise à jour des informations
                    $note_objet = Notes::find($note_id);
                    $note_objet->setAttribute("note_examen", $note_etudiant);
                    $note_objet->setAttribute("note", $note_etudiant);
                    $note_objet->setAttribute("commentaire", $commentaire);
                    $note_objet->setAttribute("statutvalidation_id", 2);
                    $note_objet->update();
                    } 

                   
            }  

            return redirect()->route("sessionscorrections.new-index")->with("success", "Note enregistré avec succès");
        
        } catch (\Throwable $th) {
            
            return redirect()->route("sessionscorrections.new-index")->with("error", "Echec lors de l'enregistrement des donnéees. ".$th);
        }
    }


}

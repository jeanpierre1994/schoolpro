<?php

namespace App\Http\Controllers;

use App\Models\Examenprog;
use App\Models\Examens;
use App\Models\Examentypes;
use App\Models\Groupepedagogiques;
use App\Models\Matieres;
use Illuminate\Http\Request;
use PHPUnit\TextUI\XmlConfiguration\Group;

class ExamensController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $examens = Examens::orderBy("id", "desc")->get();
        return view("backend.examens.index", compact("examens"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $gp = Groupepedagogiques::all();
        $examentypes = Examentypes::where("statut_id", 1)->get();  
        return view("backend.examens.create", compact("gp","examentypes"));
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
            //'gp_id' => 'required',
            'examentype_id' => 'required',
            'libelle' => 'required', 
            'note_max' => 'required',  
            'date_debut'=> 'required',  
            'date_fin'=> 'required',   
            'ponderation'=> 'required', 
            'min_moyenne'=> 'required', 
            'max_moyenne'=> 'required', 
            'annee_academique'=> 'required',  
        ]);

        // vérifier si le données existe déjà
        $check_data = Examens::where("libelle",$request->libelle)->where("examentype_id",$request->examentype_id)->where("date_debut",$request->date_debut)
        ->where("date_fin",$request->date_fin)->where("note_max",$request->note_max)
        ->where("ponderation",$request->ponderation)->where("min_moyenne",$request->min_moyenne)
        ->where("max_moyenne",$request->max_moyenne)->where("annee_academique",$request->annee_academique)
        ->exists();

        if($check_data){
           // if categorie exist redirect to form with error message
            return redirect()->back()->with('error', "Cet examen existe déjà.");
        } 

        $user = Auth()->user(); 
 

        //##################### générer le code  ###########################
        // procédure d'incrémentation du code
        $annee_actuelle = date('y');
        $indicatif = "EXM";
        $id_1 = "";
        // récupérer le dernier enregistrement
        $last_numero = Examens::orderBy('id', 'desc')->first();
 
        if ($last_numero == NULL) {
            $last_id = "";
        } else {
            $last_id = $last_numero->code_examen;
        }

        if (!empty($last_id)) {
            //$str = "DS11111122"; 
            // delete DS
            $delete_bu = substr($last_id, -8); 
            // delete YEAR
            $correct_code = substr($delete_bu,0, 6);
            $id_1 = $correct_code;
        } else {
            $id_1 = '000000';
        }

        // récupérer le numéro à incrémenter sur la position 2 du tableau $id_1
        if (!empty($last_id)) {
            //vérifier si nous somme dans une nouvelle année pour réinitialiser le compteur
            $get_date = substr($last_id, -2);
            if ($annee_actuelle > $get_date) {
                # code...
                $numero = '000000';
            } else {
                # code...
                //$str = "BU111111122"; 
                // delete BU
                $delete_bu = substr($last_id, -8); 
                // delete YEAR
                $correct_code = substr($delete_bu,0, 6); 
                $numero = $correct_code;
            } 
        } else {
            $numero = '000000';
        }

         

        $numero_user = $numero + 1;

        $numero_user_formatted = str_pad($numero_user, 6, "0", STR_PAD_LEFT);
        $code_examen = $indicatif.$numero_user_formatted.$annee_actuelle;
       
        //################################### end générer le code  ###################
          
        $examen = new Examens();    
        $examen->setAttribute('code_examen', trim($code_examen));
        $examen->setAttribute('libelle', trim($request->libelle));
        $examen->setAttribute('date_debut', trim($request->date_debut));
        $examen->setAttribute('date_fin', trim($request->date_fin));
        $examen->setAttribute('examentype_id', $request->examentype_id);  
        $examen->setAttribute('min_moyenne', trim($request->min_moyenne));
        $examen->setAttribute('max_moyenne', trim($request->max_moyenne)); 
        $examen->setAttribute('ponderation', trim($request->ponderation));  
        $examen->setAttribute('note_max', trim($request->note_max)); 
        $examen->setAttribute('commentaire', trim($request->commentaire)); 
        $examen->setAttribute('annee_academique', trim($request->annee_academique)); 
        $examen->setAttribute('statut_id', 1); 
        $examen->setAttribute('created_by', $user->id); 
        $examen->setAttribute('updated_by', $user->id); 
        $examen->save();

        // générer le calendrier scolaire par défaut
        // get liste matiere
        $liste_matieres = Matieres::all();
         foreach ($liste_matieres as $matiere) {
            # code...
        $examenprog = new Examenprog();
        $examenprog->setAttribute('examen_id', $examen->id);
        $examenprog->setAttribute('matiere_id', $matiere->id);
        $examenprog->setAttribute('date_debut', $examen->date_debut);
        $examenprog->setAttribute('date_fin', $examen->date_fin);
        //$examenprog->setAttribute('annee_academique', $request->annee_academique);
        $examenprog->setAttribute('commentaire', "RAS");
        $examenprog->setAttribute('created_by', $user->id);
        $examenprog->setAttribute('created_at', new \DateTime());
        $examenprog->setAttribute('updated_at', new \DateTime());
        $examenprog->setAttribute('updated_by', $user->id); 
        $examenprog->save(); 
        }
 
        return redirect()->route("examens.index") ->with('success', 'Enregistrement effectué avec succès');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Examens  $examen
     * @return \Illuminate\Http\Response
     */
    public function show(Examens $examen)
    {
        $listeGP = Groupepedagogiques::all(); 
        return view("backend.examenprog.list-gp", compact("listeGP", "examen"));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Examens  $examen
     * @return \Illuminate\Http\Response
     */
    public function showMatieres(Request $request)
    { 
        $examen = Examens::find($request->id); 
        $matieres = Matieres::all(); // where("groupepedagogique_id",$request->gp_id)->where("statut_id",1)->get();
        $gp = Groupepedagogiques::find($request->gp_id); 
        $examenprogs = Examenprog:: 
        where("examenprogs.examen_id",$examen->id)
        //join("examens","examens.id","=","examenprogs.examen_id") 
        ->join("matieres","examenprogs.matiere_id","=","matieres.id")
        ->where("matieres.groupepedagogique_id",$request->gp_id)
        ->get();
       // dd($examenprogs);
        return view("backend.examenprog.index", compact("examenprogs", "examen","matieres","gp"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Examens  $examens
     * @return \Illuminate\Http\Response
     */
    public function edit(Examens $examens)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Examens  $examens
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Examens $examens)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Examens  $examens
     * @return \Illuminate\Http\Response
     */
    public function destroy(Examens $examens)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Actions\GenereCode;
use App\Models\Rubriques;
use App\Models\Lignetarifs;
use Illuminate\Http\Request;
use App\Models\Grilletarifaires;
use App\Http\Requests\StoreLigneTarifaireRequest;
use App\Http\Requests\UpdateLigneTarifaireRequest;

class LignetarifsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ligneTarifaires = Lignetarifs::all();
        $grilleTarifaires = Grilletarifaires::orderBy("libelle","asc")->get();
        return view('backend.frais.ligneTarifaires.index', compact('ligneTarifaires','grilleTarifaires')); ;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function liste(Request $request)
    {
        $getGrille = Grilletarifaires::all();
        foreach ($getGrille as $key => $value) {
            # code...
            $listeRubrique = Rubriques::all();
            foreach ($listeRubrique as $key => $rubrique) {
                # code...
                $checkLigne = Lignetarifs::where("rubrique_id",$rubrique->id)
                ->where("grille_tarifaire_id",$value->id)
                ->exists();

                if (!$checkLigne) {
                    # code...
                    $code = (new GenereCode)->handle(LigneTarifs::class, "LT");
                    $new_ligne_tarif = new Lignetarifs();
                    $new_ligne_tarif->setAttribute("code",$code);
                    $new_ligne_tarif->setAttribute("is_required",true);
                    $new_ligne_tarif->setAttribute("rubrique_id",$rubrique->id);
                    $new_ligne_tarif->setAttribute("grille_tarifaire_id",$value->id);
                    $new_ligne_tarif->setAttribute("montant",$rubrique->montant);
                    $new_ligne_tarif->setAttribute("statut_id",1);
                    $new_ligne_tarif->setAttribute("created_by",auth()->user()->id);
                    $new_ligne_tarif->setAttribute("updated_by",auth()->user()->id);
                    $new_ligne_tarif->save();
                }
            }

        }
        if (isset($_POST["grille_tarifaire"])) {
            # code...
            $grille_id = $_POST["grille_tarifaire"];
            $ligneTarifaires = Lignetarifs::where("grille_tarifaire_id",$grille_id)->get();
            $grilleTarifaires = Grilletarifaires::orderBy("libelle","asc")->get();
            return view('backend.frais.ligneTarifaires.index', compact('ligneTarifaires','grilleTarifaires')); 
        } else {
            # code...
            $ligneTarifaires = Lignetarifs::all();
            $grilleTarifaires = Grilletarifaires::orderBy("libelle","asc")->get();
            return view('backend.frais.ligneTarifaires.index', compact('ligneTarifaires','grilleTarifaires')); 
        } 
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $grilleTarifaires = Grilletarifaires::all();
        $rubriques = Rubriques::all();
        return view('backend.frais.ligneTarifaires.create', compact('grilleTarifaires', 'rubriques'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLigneTarifaireRequest $request)
    {
        $request->is_required == "on" ? $is_required = true : $is_required = false;
        Lignetarifs::create($request->validated() + ['is_required' => $is_required]);
        return redirect()->route('admin.liste_tarif')->with('success', 'Created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lignetarifs  $lignetarif
     * @return \Illuminate\Http\Response
     */
    public function show(Lignetarifs $lignetarifs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lignetarifs  $lignetarifs
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $grilleTarifaires = Grilletarifaires::all();

        $rubriques = Rubriques::all();
        $ligneTarifaire = Lignetarifs::find($id);
        return view('backend.frais.ligneTarifaires.edit', compact('grilleTarifaires', 'rubriques', 'ligneTarifaire'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lignetarifs  $lignetarif
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLigneTarifaireRequest $request, $id)
    {
        $request->is_required == "on" ? $is_required = true : $is_required = false;
        $ligneTarifaire = Lignetarifs::find($id);
        $ligneTarifaire->update($request->validated() + ['is_required' => $is_required] );
        return redirect()->route('admin.liste_tarif')->with('success', 'Updated successfully');
    }

    
    public function supprimer(Request $request)
    {
        try {
           
            //code...
            $ligneTarifaire = Lignetarifs::find($request->id)->forceDelete();
            if ($ligneTarifaire) {
                return redirect()->route('admin.liste_tarif')->with('success', 'Deleted successfully');
            } else {
                return redirect()->route('admin.liste_tarif')->with('error', 'Echec lors de la suppression.');
            }
            

        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('admin.liste_tarif')->with('error', 'Echec lors de la suppression.');
            
        }
       
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Etablissements;
use App\Models\Sites;
use Illuminate\Http\Request;

class SitesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sites = Sites::orderBy("id", "desc")->get();
        return view("backend.sites.index", compact("sites"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $etablissements = Etablissements::where("statut_id",1)->get();
        return view("backend.sites.create", compact("etablissements"));
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
            'sigle' => 'required',
            'etablissement_id' => 'required',
            'telephone' => 'required',  
            'manager' => 'required',
            'adresse' => 'required',
            'email' => 'required'
        ]);

        $user = auth()->user();
        $user_id = $user->id;

        // vérifier si l'établissement existe déjà

        $check_site = Sites::where("sigle",$request->sigle)->where("manager",$request->manager)
        ->where("telephone",$request->telephone)->where("ets",$request->etablissement_id)
        ->where("adresse",$request->adresse)->exists();

        if ($check_site) {
            # code...
            return redirect()->back()->with("error","Le site existe déjà");
        }

        $site = new Sites();
        $site->setAttribute('sigle', $request->sigle); 
        $site->setAttribute('telephone', $request->telephone); 
        $site->setAttribute('ets', $request->etablissement_id);
        $site->setAttribute('manager', $request->manager);
        $site->setAttribute('email', $request->email);
        $site->setAttribute('adresse', $request->adresse);
        $site->setAttribute('created_by', $user_id);
        $site->setAttribute('created_at', new \DateTime());
        $site->setAttribute('updated_by', $user_id);
        $site->setAttribute('statut_id', 1);
        $site->save();

        return redirect()->route('sites.index')
            ->with('success', 'Enregistrement effectué avec succès');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sites  $sites
     * @return \Illuminate\Http\Response
     */
    public function show(Sites $sites)
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
        $etablissements = Etablissements::where("statut_id",1)->get();
        $site = Sites::find($id);
        return view("backend.sites.edit",compact("etablissements","site"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sites  $site
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sites $site)
    {
        $this->validate($request, [
            'sigle' => 'required', 
            'telephone' => 'required', 
            'etablissement_id' => 'required',
            'manager' => 'required',
            'adresse' => 'required',
            'email' => 'required'
        ]);

        $user = auth()->user();
        $user_id = $user->id;

        // vérifier si le site existe déjà

        $check_site = Sites::where("sigle",$request->sigle)
        ->where("telephone",$request->telephone)->where("ets",$request->etablissement_id)
        ->where("manager",$request->manager)->where("adresse",$request->adresse)
        ->where("id","!=",$site->id)->exists();

        if ($check_site) {
            # code...
            return redirect()->back()->with("error","Le site existe déjà");
        }
 
        $site->setAttribute('sigle', $request->sigle); 
        $site->setAttribute('telephone', $request->telephone);
        $site->setAttribute('manager', $request->manager);
        $site->setAttribute('email', $request->email);
        $site->setAttribute('ets', $request->etablissement_id);
        $site->setAttribute('adresse', $request->adresse); 
        $site->setAttribute('updated_at', new \DateTime());
        $site->setAttribute('updated_by', $user_id);
        $site->update();

        return redirect()->route('sites.index')
            ->with('success', 'Modification effectuée avec succès');
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
            $site = Sites::find($id);
            //Récupérer le sigle de l'élément supprimé
            $value = $site->sigle;
            $site->delete();
            // get current user id
            $user = auth()->user(); 
            return redirect()->route('sites.index')->with('success', 'Opération bien effectuée');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with("error", "Vous ne pouvez pas supprimer cet élément à cause du contrôle d'intégrité.");
        }
    }
}

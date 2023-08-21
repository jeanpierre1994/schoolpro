<?php

namespace App\Http\Controllers;

use App\Models\Etudiants;
use Illuminate\Http\Request;
use App\Models\Groupepedagogiques;

class TreeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke( $groupePedagogique)
    {
        $gp = Groupepedagogiques::where('id', $groupePedagogique)->get()->first();
        $etudiants = Etudiants::where('groupepedagogique_id', $gp->id)->get();

        return view('backend.administrations.etudiants.liste', compact('etudiants'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontendController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request )
    {
        return view("index");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function connexion(Request $request )
    {
        return view("login");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function inscription(Request $request )
    {
        return view("frontend.inscriptions.choix_categorie");
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function inscriptionForm(Request $request )
    { 
        
        if (isset($_POST['etudiant'])) {
            # code... 
            return view("frontend.inscriptions.etudiant");
        }else{ 
            return view("frontend.inscriptions.parent");
        }
    } 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function inscriptionParentEtudiant(Request $request )
    {  
            return view("frontend.inscriptions.parent_etudiant");
        
    } 
    
    
}

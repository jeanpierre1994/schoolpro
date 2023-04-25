<?php

namespace App\Http\Controllers;

use App\Models\Sessioncorrections;
use Illuminate\Http\Request;

class SessioncorrectionController extends Controller
{
    public function index(){
        $sessioncorrections = Sessioncorrections::where("professeur_id", auth()->user()->id)->get();
        return view("backend.administrations.sessioncorrections.index", compact("sessioncorrections"));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Notes;
use App\Models\Etudiants;
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
    public function __invoke(Request $request)
    {
        $notes = Notes::where('');
        $gp;
        $etudiant = Etudiants::where('id', 1);
        $pdf = Pdf::loadView('frontend.bulletins.pdf');

        return $pdf->stream();
    }
}

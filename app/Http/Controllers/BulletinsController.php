<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Http\Request;

class BulletinsController extends Controller
{
    public function index()
    {
        $pdf = Pdf::loadView('frontend.bulletins.template');
        return $pdf->stream();
    }
}

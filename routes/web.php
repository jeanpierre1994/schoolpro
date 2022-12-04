<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("/",[FrontendController::class,'index'])->name("index");
Route::get("/connexion",[FrontendController::class,'connexion'])->name("connexion");
Route::get("/inscription",[FrontendController::class,'inscription'])->name("inscription");
Route::post("/inscription/form",[FrontendController::class,'inscriptionForm'])->name("inscription-form"); 
Route::post("/inscription/parent/etudiant",[FrontendController::class,'inscriptionParentEtudiant'])->name("parent_etudiant"); 

Route::any('/admin/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
Route::get('/admin/parametres', [AdminController::class, 'parametres'])->name('admin.parametres');

// Lien symbolique vers dossier de stockage
Route::get('/ActiveStorage', function () {
    Artisan::call('storage:link');
    $resultat = Artisan::output();
    $search = 'already';
    $error = 'Lien symbolique existant, Bien vouloir vérifier le contenu !';


    if (strpos($resultat, $search) === false) {
        return back()->with('success', $resultat);
    } else {
        return back()->with('error', $error);
    }
})->name('active_storage');


// Purger tous les caches à une opération unique
Route::get('/ClearCache', function () {
    Artisan::call('optimize:clear');
    $resultat = Artisan::output();
    $search = 'successfully';
    $error = 'Echec de nettoyage de caches';
    if (strpos($resultat, $search) === false) {
        return back()->with('error', $error);
    } else {
        return back()->with('success', $resultat);
    }
})->name('vider_cache');


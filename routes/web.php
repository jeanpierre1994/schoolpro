<?php

use App\Models\Examenprog;
use Illuminate\Http\Request;
use App\Models\Etablissements;
use App\Models\FamilleRubrique;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\TreeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PolesController;
use App\Http\Controllers\SitesController;
use App\Http\Controllers\CyclesController;
use App\Http\Controllers\GenresController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\ExamensController;
use App\Http\Controllers\NiveauxController;
use App\Http\Controllers\ParentsController;
use App\Http\Controllers\StatutsController;
use App\Http\Controllers\DossiersController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\FilieresController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\MatieresController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\PersonnesController;
use App\Http\Controllers\RubriquesController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\ExamenprogController;
use App\Http\Controllers\ExamentypesController;
use App\Http\Controllers\LignetarifsController;
use App\Http\Controllers\ProfesseursController;
use App\Http\Controllers\TypesponsorsController;
use App\Http\Controllers\AdminEtudiantController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\EmailVerifiedController;
use App\Http\Controllers\MatiereconfigController;
use App\Http\Controllers\EtablissementsController;
use App\Http\Controllers\EtudiantsController;
use App\Http\Controllers\FamilleRubriqueController;
use App\Http\Controllers\GrilletarifairesController;
use App\Http\Controllers\StatutjuridiquesController;
use App\Http\Controllers\SessioncorrectionController;
use App\Http\Controllers\GroupepedagogiquesController;
use App\Http\Controllers\PortefeuillesController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

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
// ajax requetes
Route::post('ajax_requete', [AdminController::class, 'ajaxRequete'])->name('ajax_requete');

Route::get("/",[FrontendController::class,'index'])->name("index");
Route::get("/connexion",[FrontendController::class,'connexion'])->name("connexion");
Route::get("/inscription",[FrontendController::class,'inscription'])->name("inscription");
Route::post("/inscription/form",[FrontendController::class,'inscriptionForm'])->name("inscription-form"); 
Route::get("/inscription/parent/{id}/etudiant",[FrontendController::class,'inscriptionParentEtudiant'])->name("parent_etudiant"); 

Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('dashboard')->middleware("auth");
Route::get('/admin/parametres', [AdminController::class, 'parametres'])->name('admin.parametres')->middleware("auth");
// dashboard étudiant 
Route::get('/admin/dashboard/etudiant', [AdminController::class, 'dashboardEtudiant'])->name('dashboard_etudiant')->middleware("auth");
// dashboard parent 
Route::get('/admin/dashboard/parent', [AdminController::class, 'dashboardParent'])->name('dashboard_parent')->middleware("auth");
 
// authentification routes 
Route::get('/authentification', [CustomAuthController::class, 'login'])->name('authentification');
Route::post('custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom'); 
Route::get('registration', [CustomAuthController::class, 'registration'])->name('register-user');
Route::post('custom-registration', [CustomAuthController::class, 'customRegistration'])->name('register.custom'); 
Route::get('signout', [CustomAuthController::class, 'signOut'])->name('signout'); 

Auth::routes(['verified' => true]);

Route::get('/email/verify', [EmailVerifiedController::class, 'notice'])->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', [EmailVerifiedController::class, 'verify'])->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerifiedController::class, 'send'])->middleware(['auth', 'throttle:6,1'])->name('verification.send');


// check code activation compte 
Route::get('/activation/compte/user/{code_activation}', [CustomAuthController::class, 'checkmailConfirmation'])->name('tojumi.checkmailActivation');

// route activation & desactivation
Route::get('/admin/update/{id}/{table}/{statut}', [AdminController::class, 'newUpdate'])->name('admin.update-parametre')->middleware('auth');

//import excel

Route::get('import-personnes', [PersonnesController::class,'importPersonnes'])->name('import-personnes');
Route::post('uploadPersonnes', [PersonnesController::class,'uploadPersonnes'])->name('upload-personnes');

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


Route::any('admin/ligne_tarifaires/index', [LignetarifsController::class, 'liste'])->name('admin.liste_tarif')->middleware("auth");
Route::post('admin/ligne_tarifaires/supprimer', [LignetarifsController::class, 'supprimer'])->name('liste_tarif.supprimer')->middleware("auth");

Route::group(['prefix' => "admin", 'middleware' => ['auth']], function () {
    Route::resource('statuts', StatutsController::class);
    Route::resource('profils', ProfilController::class);
    Route::resource('genres', GenresController::class);
    Route::resource('etablissements', EtablissementsController::class);
    Route::resource('statutjuridiques', StatutjuridiquesController::class);
    Route::resource('sites', SitesController::class); 
    Route::resource('niveaux', NiveauxController::class); 
    Route::resource('filieres', FilieresController::class); 
    Route::resource('poles', PolesController::class); 
    Route::resource('cycles', CyclesController::class); 
    Route::resource('typesponsors', TypesponsorsController::class); 
    Route::resource('categories', CategoriesController::class); 
    Route::resource('sections', SectionsController::class); 
    Route::resource('groupepedagogiques', GroupepedagogiquesController::class); 
    Route::resource('matieres', MatieresController::class); 
    Route::resource('examentypes', ExamentypesController::class); 
    Route::resource('examens', ExamensController::class);
    Route::resource('examenprog', ExamenprogController::class);
    Route::resource('matiereconfigs', MatiereconfigController::class);

    Route::resource('famille_rubriques', FamilleRubriqueController::class);
    Route::resource('rubriques', RubriquesController::class);
    Route::resource('grille_tarifaires', GrilletarifairesController::class);
    Route::resource('ligne_tarifaires', LignetarifsController::class);
    Route::resource('users', UserController::class);
    // ajax requête
 });

 Route::get('pdf/{id}/{gp_id}/{etudiant_id}', PdfController::class)->name('pdf');

 // check_dashboard
Route::get('admin/check/dashboard', [AdminController::class, 'checkDashboard'])->name('check_dashboard'); 

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// store inscription
Route::post('inscription/store', [FrontendController::class, 'store'])->name('inscription.store'); 

// enregistrement des étudiants 
Route::post('inscription/store/etudiant', [FrontendController::class, 'storeEtudiant'])->name('inscription.store_etudiant'); 
// enregistrement des parents
Route::post('inscription/store/parent', [FrontendController::class, 'storeParent'])->name('inscription.store_parent'); 
// 
Route::post('inscription/store/parent/etudiant', [FrontendController::class, 'storeParentEtudiant'])->name('inscription.store_parent_etudiant'); 
// profil
Route::get('profil', [FrontendController::class, 'profil'])->name('profil'); 
// ajouter étudiant
Route::get('parent/ajouter/etudiant', [FrontendController::class, 'ajouterEtudiant'])->name('ajouter-etudiant'); 
// store ajouter étudiant
Route::post('parent/enregistrer/etudiant', [FrontendController::class, 'saveEtudiant'])->name('save-etudiant'); 
 
//route etudiant
Route::get('admin/etudiant/identite', [EtudiantController::class, 'identite'])->name('etudiant.identite')->middleware("auth");
// route parent identite
Route::get('admin/parent/identite', [ParentsController::class, 'identite'])->name('parent.identite')->middleware("auth");
// edit profil etudiant
Route::get('admin/etudiant/edit/{id}/profil', [EtudiantController::class, 'editProfil'])->name('etudiant.edit_profil')->middleware("auth");
// store edit profil
Route::post('admin/etudiant/edit/profil/store', [EtudiantController::class, 'editProfilStore'])->name('etudiant.edit_profil-store')->middleware("auth");
// edit profil parent
Route::get('admin/parent/edit/{id}/profil', [ParentsController::class, 'editProfil'])->name('parent.edit_profil')->middleware("auth");
// parent store edit profil
Route::post('admin/parent/edit/profil/store', [ParentsController::class, 'editProfilStore'])->name('parent.edit_profil-store')->middleware("auth");
// parent etudiant 
Route::get('admin/parent/etudiants', [ParentsController::class, 'etudiants'])->name('parent.etudiants')->middleware("auth");
// parent ajouter etudiant 
Route::get('admin/parent/add/etudiant', [ParentsController::class, 'addEtudiant'])->name('parent.add-etudiant')->middleware("auth");
// store etudiant 
Route::post('admin/parent/store/etudiant', [ParentsController::class, 'storeEtudiant'])->name('parent.etudiant-store')->middleware("auth");
// parent add dossier 
Route::get('admin/parent/nouveau/{id}/dossier/etudiant', [ParentsController::class, 'newDossier'])->name('parent.new-dossier-etudiant')->middleware("auth");
// parent store dossier 
Route::post('admin/parent/store/dossier/etudiant', [ParentsController::class, 'storeDossier'])->name('parent.dossier-store')->middleware("auth");
// parent dossiers 
Route::get('admin/parent/dossiers/etudiants', [ParentsController::class, 'dossiers'])->name('parent.dossiers')->middleware("auth");
// parent inscriptions 
Route::get('admin/parent/inscriptions/etudiants', [ParentsController::class, 'inscriptions'])->name('parents.inscriptions')->middleware("auth");


Route::get('admin/etudiant/dossiers', [EtudiantController::class, 'dossiers'])->name('etudiant.dossiers')->middleware("auth");
//nouveau dossier
Route::get('admin/etudiant/nouveau/dossiers', [EtudiantController::class, 'newDossier'])->name('etudiant.new-dossier')->middleware("auth");
// save dossier 
Route::post('admin/etudiant/store/dossiers', [EtudiantController::class, 'saveDossier'])->name('etudiant.dossier-store')->middleware("auth");
// dossier valide : inscription
Route::get('admin/etudiant/inscriptions', [EtudiantController::class, 'dossierValide'])->name('etudiant.dossiers-valide')->middleware("auth");

//********** gestion des professeurs */ 
Route::get('admin/professeurs/liste', [ProfesseursController::class, 'index'])->name('professeurs.index')->middleware("auth");
// professeurs.edit
Route::get('admin/professeurs/create', [ProfesseursController::class, 'create'])->name('professeurs.create')->middleware("auth");
Route::post('admin/professeurs/store', [ProfesseursController::class, 'store'])->name('professeurs.store')->middleware("auth");
Route::get('admin/professeurs/{id}/edite', [ProfesseursController::class, 'edit'])->name('professeurs.edit')->middleware("auth");
Route::put('admin/professeurs/{id}/update', [ProfesseursController::class, 'update'])->name('professeurs.update')->middleware("auth");
// professeurs.store-matiere
Route::get('admin/professeurs/matiere', [ProfesseursController::class, 'matieres'])->name('professeurs.matieres')->middleware("auth");
Route::post('admin/professeurs/store/matiere', [ProfesseursController::class, 'matiereStore'])->name('professeurs.store-matiere')->middleware("auth");
Route::post('admin/professeurs/delete/matiere', [ProfesseursController::class, 'matiereDelete'])->name('professeurs.delete-matiere')->middleware("auth");

// gestion des sessions de correction
Route::get('admin/sessions/corrections', [SessioncorrectionController::class, 'index'])->name('admin.sessioncorrections')->middleware("auth");
// 
Route::get('admin/sessions/corrections/{id}/create', [SessioncorrectionController::class, 'create'])->name('sessionscorrections.create')->middleware("auth");
// 
Route::post('admin/sessions/corrections/store', [SessioncorrectionController::class, 'store'])->name('sessionscorrections.store')->middleware("auth");
// sessionscorrections.liste
Route::get('admin/sessions/corrections/{id}/liste', [SessioncorrectionController::class, 'listeEtudiant'])->name('sessionscorrections.liste')->middleware("auth");

// traitement des dossiers 
// dossiers en attente
Route::get('admin/dossiers/en_attente', [DossiersController::class, 'enAttente'])->name('dossiers.en_attente')->middleware("auth");
// dossiers.traitement
Route::get('admin/traitement/dossiers/{id}/en_attente', [DossiersController::class, 'traitement'])->name('dossiers.traitement')->middleware("auth");
// dossiers.store_traitement
Route::post('admin/traitement/dossiers/store', [DossiersController::class, 'storeTraitement'])->name('dossiers.store_traitement')->middleware("auth");

// dossiers valides
Route::get('admin/dossiers/valide', [DossiersController::class, 'valide'])->name('dossiers.valide')->middleware("auth");

// dossiers rejetes
Route::get('admin/dossiers/rejete', [DossiersController::class, 'rejete'])->name('dossiers.rejete')->middleware("auth");

// add gp
Route::post('matieres/add/gp', [MatiereconfigController::class, 'addGP'])->name('matiereconfigs.store-gp')->middleware("auth");

// groupepedagogiques.association 
Route::get('admin/association/{id}/gp', [GroupepedagogiquesController::class, 'association'])->name('groupepedagogiques.association')->middleware("auth");
Route::post('admin/association/store/gp', [GroupepedagogiquesController::class, 'associationStore'])->name('groupepedagogiques.association-store')->middleware("auth");
Route::post('admin/association/delete/data', [GroupepedagogiquesController::class, 'deleteMatiereProf'])->name('groupepedagogiques.delete-data')->middleware("auth");
Route::post('admin/association/delete/data-GpProf', [GroupepedagogiquesController::class, 'deleteGpProf'])->name('groupepedagogiques.delete-data-GpProf')->middleware("auth");
// examenprog.matiere-gp
Route::get('admin/examenprogs/gp/{id}/{gp_id}/matieres', [ExamensController::class, 'showMatieres'])->name('examenprog.matiere-gp')->middleware("auth");
// updateMatiereProf
Route::post('admin/association/update/prof-matiere', [GroupepedagogiquesController::class, 'updateMatiereProf'])->name('groupepedagogiques.update-profmatiere')->middleware("auth");

// add etudiant admin.add-etudiant
Route::get('admin/add/etudiant', [AdminEtudiantController::class, 'addEtudiant'])->name('admin.add-etudiant')->middleware("auth");
//liste etudiant 
Route::get('admin/etudiants', [AdminEtudiantController::class, 'index'])->name('admin.etudiants')->middleware('auth');
Route::get('admin/etudiant/edit/{id}', [AdminEtudiantController::class, 'edit'])->name('admin.etudiant.edit')->middleware('auth');
Route::get('admin/etudiant/releve/{id}', [AdminEtudiantController::class, 'releve'])->name('admin.etudiant.releve');
Route::get('admin/etudiant/mail/{id}', [AdminEtudiantController::class,'sendMail'])->name('admin.etudiant.mail');
Route::put('admin/etudiant/update/{id}', [AdminEtudiantController::class, 'update'])->name('admin.etudiant.update');
// liste etudiant groupe pedagogique
Route::get('admin/gp/{id}/etudiant', [GroupepedagogiquesController::class, 'listeEtudiant'])->name('groupepedagogiques.etudiants')->middleware("auth");
// liste examen par gp groupepedagogiques.examens
Route::get('admin/examen/gp/{id}/{etudiant_id}/etudiant', [GroupepedagogiquesController::class, 'listeExamen'])->name('groupepedagogiques.examens')->middleware("auth");

Route::get('/load-students/{groupePedagogique}', TreeController::class);
 // Lien symbolique vers dossier de stockage
 Route::get('/ActiveStorage', function () {
    Artisan::call('storage:link');
    $resultat = Artisan::output();
     $search = 'already';
     $error = 'Lien symbolique existant, Bien vouloir vérifier le contenu !';
  
  
    if(strpos($resultat, $search) === false) {
        return redirect()->back()->with('success', $resultat);
  
    }else{
       return redirect()->back()->with('error', $error);
    }
  
  
  })->name('active_storage');
  
  
  // Purger tous les caches à une opération unique
  Route::get('/ClearCache', function()  {
    Artisan::call('optimize:clear');
    $resultat = Artisan::output();
    $search = 'successfully';
    $error = 'Echec de nettoyage de caches';
  
  
    if(strpos($resultat, $search) === false) {
      return redirect()->back()->with('success', $resultat);
      
  }else{
     return redirect()->back()->with('error', $error);
  }
  
  })->name('vider_cache'); 
  

  // add etudiant admin.add-etudiant
Route::get('admin/add/etudiant', [AdminEtudiantController::class, 'addEtudiant'])->name('admin.add-etudiant')->middleware("auth");
//
Route::post('admin/store/etudiant/express', [EtudiantController::class, 'storeEtudiant'])->name('etudiant.dossierExpress-store')->middleware("auth");
//
Route::post('admin/store/dossier/etudiant/express', [EtudiantController::class, 'storeDossierSansInscription'])->name('etudiant.dossierExpress-sansInscription')->middleware("auth");

// 
Route::get('admin/sessions/corrections/{id}/etudiant', [SessioncorrectionController::class, 'listeEtudiantByGP'])->name('sessioncorrections.gp-etudiants')->middleware("auth");
// 
Route::any('admin/note/{id}/{etudiant_id}/etudiant/{examen_id?}', [SessioncorrectionController::class, 'showNoteEtudiant'])->name('sessioncorrections.show-note')->middleware("auth");
// paiement.kkiapay
Route::get('admin/{reference}/paiement', [PaiementController::class, 'paiementKkiapay'])->name('paiement.kkiapay')->middleware("auth");
// 
Route::get('admin/{reference}/paiement/store', [PaiementController::class, 'paiementKkiapayStore'])->name('paiement.kkiapay-store')->middleware("auth");
// 
Route::get('admin/{reference}/paiement/express', [PaiementController::class, 'paiementKkiapayExpress'])->name('paiement-express.kkiapay')->middleware("auth");
// 
Route::get('admin/{reference}/paiement/express/store', [PaiementController::class, 'paiementKkiapayExpressStore'])->name('paiement-express.kkiapay-store')->middleware("auth");

// route parent compte
Route::get('admin/parent/compte', [ParentsController::class, 'compte'])->name('parent.compte')->middleware("auth");
// route etudiant compte
Route::get('admin/etudiant/compte', [EtudiantController::class, 'compte'])->name('etudiant.compte')->middleware("auth");

Route::get('admin/dossier/{id}/choix_rubrique', [PaiementController::class, 'choixRubrique'])->name('paiements.choix_rubrique')->middleware("auth");
Route::get('admin/retirer/{id}/rubrique', [PaiementController::class, 'retirerRubrique'])->name('paiement.retirer-rubrique')->middleware("auth");
// 
Route::post('admin/recharge/portefeuille', [PaiementController::class, 'rechargePortefeuille'])->name('paiements.rechargePortefeuille')->middleware("auth");

Route::get('admin/recharge/portefeuille/{id}/{reference}/kkiapay', [PortefeuillesController::class, 'rechargePortefeuilleParent'])->name('recharge-portefeuille-parent.kkiapay')->middleware("auth");
Route::get('admin/recharge/portefeuille/etudiant/{id}/{reference}/kkiapay', [PortefeuillesController::class, 'rechargePortefeuilleEtudiant'])->name('recharge-portefeuille-etudiant.kkiapay')->middleware("auth");

//
Route::get('admin/recharge/portefeuille/parent/{id}/{reference}/kkiapay', [PortefeuillesController::class, 'rechargePortefeuilleParentStore'])->name('paiement_portefeuille_parent.kkiapay-store')->middleware("auth");
Route::get('admin/recharge/portefeuille/etudiant/{id}/{reference}/kkiapay', [PortefeuillesController::class, 'rechargePortefeuilleEtudiantStore'])->name('paiement_portefeuille_etudiant.kkiapay-store')->middleware("auth");

// rechargerPortefeuilleParent
Route::post('admin/recharge/portefeuille/parent', [ParentsController::class, 'rechargerPortefeuilleParent'])->name('recharge.portefeuille-parent')->middleware("auth");
Route::post('admin/recharge/portefeuille/etudiant', [EtudiantsController::class, 'rechargerPortefeuilleEtudiant'])->name('recharge.portefeuille-etudiant')->middleware("auth");

// ajax recharge
Route::post('admin/recharge/portefeuille/ajax', [AjaxController::class, 'crediterPortefeuille'])->name('crediter-portefeuille')->middleware("auth");
// 
Route::post('admin/recharge/portefeuille/kkiapay', [AjaxController::class, 'paiementKkiapayStore'])->name('update-kkiapay-transaction')->middleware("auth");
// 
Route::post('admin/ventilation/echeancier', [AjaxController::class, 'ventilationEcheancier'])->name('ventilation_echeancier')->middleware("auth");

Route::get('admin/{reference}/telechargement/recu', [PdfController::class, 'infoImpressionRecu'])->name('info.impression-recu')->middleware("auth");
//
Route::get('admin/impression/{reference}/recu', [PdfController::class, 'recuPaiement'])->name('impression-recu')->middleware("auth");



// Détails sur les paiements
Route::get('admin/paiements', [PaiementController::class, 'index'])->name('admin.paiements');
Route::get('admin/paiements/{dossier:id}/list', [PaiementController::class, 'listePaiements'])->name('admin.paiements.list');
Route::get('comptable/paiements/dossier/list', [PaiementController::class, 'historiquePaiements'])->name('admin.comptable.paiements-dossier');
Route::get('comptable/paiements/portefeuilles', [PaiementController::class, 'historiquePaiementsPortefeuilles'])->name('admin.comptable.paiements-portefeuille');
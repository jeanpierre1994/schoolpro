@extends('backend/include/layout')
<!-- title -->
@section('title')
    Dashboard || {{ env('APP_NAME') }}
@endsection

@section('fil-arial')
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Accueil</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div>
@endsection

@section('contenu')
    @php
        //Variable pour facilement récupérer le role du user
        // $user = Auth()->user();
    @endphp
    <section class="section dashboard">
        <div class="row">
            <!-- Utilisateurs Card -->
            <!-- Roles Card -->
            @if (auth()->user()->profil_id == 1)
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex flex-nowrap justify-content-between align-items-center  p-3">
                            <span class="mb-0">Paramètres Généraux</span>
                            <hr class="flex-grow-1 ml-3">
                        </div>
                    </div>
                </div>

                {{-- Profils --}}
                <div class="col-xxl-4 col-md-4">
                    <div class="card info-card sales-card">
                        <a href="{{ route('profils.index') }}" style="text-decoration: none;">
                            <div class="card-body">
                                <h5 class="card-title">Profils <span></span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-hand-index-thumb"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $nbre_profil }}</h6>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                {{-- End Profils --}}

                {{-- Genres --}}
                <div class="col-xxl-4 col-md-4">
                    <div class="card info-card sales-card">
                        <a href="{{ route('genres.index') }}" style="text-decoration: none;">
                            <div class="card-body">
                                <h5 class="card-title">Genres <span></span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-hr"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $nbre_site }}</h6>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                {{-- End Genres --}}

                {{-- Type Sponsors --}}
                <div class="col-xxl-4 col-md-4">
                    <div class="card info-card sales-card">
                        <a href="{{ route('typesponsors.index') }}" style="text-decoration: none;">
                            <div class="card-body">
                                <h5 class="card-title">Types sponsors <span></span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-heptagon"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $nbre_typesponsor }}</h6>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                {{-- End type sponsors --}}

                {{-- Type Examens --}}
                <div class="col-xxl-4 col-md-4">
                    <div class="card info-card sales-card">
                        <a href="{{ route('examentypes.index') }}" style="text-decoration: none;">
                            <div class="card-body">
                                <h5 class="card-title">Types Examens <span></span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-heptagon"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $nbre_examentype }}</h6>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                {{-- End Type Examens --}}

                <div class="col-xxl-4 col-md-4">
                    <div class="card info-card sales-card">
                        <a href="{{ route('statuts.index') }}" style="text-decoration: none;">
                            <div class="card-body">
                                <h5 class="card-title">Statuts <span></span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-playstation"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $nbre_statut }}</h6>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div><!-- End Roles Card -->


                <div class="col-xxl-4 col-md-4">
                    <div class="card info-card sales-card">
                        <a href="{{ route('statutjuridiques.index') }}" style="text-decoration: none;">
                            <div class="card-body">
                                <h5 class="card-title">Statut juridique <span></span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-book-half"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $nbre_statutjuridique }}</h6>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <!-- End Utilisateurs Card -->
            @endif

            @if (auth()->user()->profil_id == 5 || auth()->user()->profil_id == 1)
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex flex-nowrap justify-content-between align-items-center  p-3">
                            <span class="mb-0">Paramètres Etablissements</span>
                            <hr class="flex-grow-1 ml-3">
                        </div>
                    </div>
                </div>

                <div class="col-xxl-4 col-md-4">
                    <div class="card info-card sales-card">
                        <a href="{{ route('etablissements.index') }}" style="text-decoration: none;">
                            <div class="card-body">
                                <h5 class="card-title">Etablissement <span></span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $nbre_etablissement }}</h6>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <!-- End Utilisateurs Card -->

                <!--  -->

                <div class="col-xxl-4 col-md-4">
                    <div class="card info-card sales-card">
                        <a href="{{ route('sites.index') }}" style="text-decoration: none;">
                            <div class="card-body">
                                <h5 class="card-title">Sites <span></span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-house-door"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $nbre_site }}</h6>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- end  -->

                <!--  -->

                <div class="col-xxl-4 col-md-4">
                    <div class="card info-card sales-card">
                        <a href="{{ route('poles.index') }}" style="text-decoration: none;">
                            <div class="card-body">
                                <h5 class="card-title">Poles <span></span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-heptagon"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $nbre_pole }}</h6>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- end  -->


                <!--  -->

                <div class="col-xxl-4 col-md-4">
                    <div class="card info-card sales-card">
                        <a href="{{ route('filieres.index') }}" style="text-decoration: none;">
                            <div class="card-body">
                                <h5 class="card-title">Filière <span></span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-card-checklist"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $nbre_filiere }}</h6>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- end  -->

                <!--  -->

                <div class="col-xxl-4 col-md-4">
                    <div class="card info-card sales-card">
                        <a href="{{ route('niveaux.index') }}" style="text-decoration: none;">
                            <div class="card-body">
                                <h5 class="card-title">Niveaux <span></span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-hourglass-bottom"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $nbre_niveau }}</h6>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- end  -->

                <!--  -->

                <div class="col-xxl-4 col-md-4">
                    <div class="card info-card sales-card">
                        <a href="{{ route('cycles.index') }}" style="text-decoration: none;">
                            <div class="card-body">
                                <h5 class="card-title">Cycles <span></span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-recycle"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $nbre_cycle }}</h6>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- end  -->

                <!--  -->

                <div class="col-xxl-4 col-md-4">
                    <div class="card info-card sales-card">
                        <a href="{{ route('sections.index') }}" style="text-decoration: none;">
                            <div class="card-body">
                                <h5 class="card-title">Sections <span></span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-heptagon"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $nbre_section }}</h6>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>


                <!-- end  -->


                <!--  -->

                <div class="col-xxl-4 col-md-4">
                    <div class="card info-card sales-card">
                        <a href="{{ route('matieres.index') }}" style="text-decoration: none;">
                            <div class="card-body">
                                <h5 class="card-title">Matières GP<span></span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-heptagon"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $nbre_matiere }}</h6>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- end  -->


                <!-- categories -->

                <div class="col-xxl-4 col-md-4">
                    <div class="card info-card sales-card">
                        <a href="{{ route('categories.index') }}" style="text-decoration: none;">
                            <div class="card-body">
                                <h5 class="card-title">Catégories <span></span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-heptagon"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $nbre_categorie }}</h6>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            @endif

            <!-- end  -->
            @if (auth()->user()->profil_id != 2 && auth()->user()->profil_id != 3)
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex flex-nowrap justify-content-between align-items-center  p-3">
                            <span class="mb-0">Configuration Classes</span>
                            <hr class="flex-grow-1 ml-3">
                        </div>
                    </div>
                </div>
                @if (auth()->user()->profil_id == 1 || auth()->user()->profil_id == 5)
                    <div class="col-xxl-4 col-md-4">
                        <div class="card info-card sales-card">
                            <a href="{{ route('groupepedagogiques.index') }}" style="text-decoration: none;">
                                <div class="card-body">
                                    <h5 class="card-title">Groupe pédagogique<span></span></h5>
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-grip-horizontal"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{ $nbre_gp }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endif


                <div class="col-xxl-4 col-md-4">
                    <div class="card info-card sales-card">
                        <a href="{{ route('admin.etudiants') }}" style="text-decoration: none;">
                            <div class="card-body">
                                <h5 class="card-title">Liste Etudiants<span></span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-grip-horizontal"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $nbre_gp }}</h6>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- professeurs -->
                @if (auth()->user()->profil_id == 1 || auth()->user()->profil_id == 5)
                    <div class="col-xxl-4 col-md-4">
                        <div class="card info-card sales-card">
                            <a href="{{ route('matiereconfigs.index') }}" style="text-decoration: none;">
                                <div class="card-body">
                                    <h5 class="card-title">Matières <span></span></h5>
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-heptagon"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{ $nbre_matiere }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- end  -->
                    <!-- professeurs -->

                    <div class="col-xxl-4 col-md-4">
                        <div class="card info-card sales-card">
                            <a href="{{ route('professeurs.index') }}" style="text-decoration: none;">
                                <div class="card-body">
                                    <h5 class="card-title">Professeurs <span></span></h5>
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-heptagon"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{ $nbre_professeur }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- end  -->

                    <!-- professeurs -->

                    <div class="col-xxl-4 col-md-4">
                        <div class="card info-card sales-card">
                            <a href="{{ route('professeurs.matieres') }}" style="text-decoration: none;">
                                <div class="card-body">
                                    <h5 class="card-title">Professeurs Matières<span></span></h5>
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-heptagon"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{ $nbre_matiere_prof }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endif
                @if (auth()->user()->profil_id != 6)
                    <div class="col-xxl-4 col-md-4">
                        <div class="card info-card sales-card">
                            <a href="" style="text-decoration: none;">
                                <div class="card-body">
                                    <h5 class="card-title">Emploi de temps<span></span></h5>
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-heptagon"></i>
                                        </div>
                                        {{-- <div class="ps-3">
                                        <h6>{{ $nbre_matiere_prof }}</h6>
                                    </div> --}}
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endif

                @if (auth()->user()->profil_id != 6 && auth()->user()->profil_id != 7 && auth()->user()->profil_id != 8)
                    <div class="col-xxl-4 col-md-4">
                        <div class="card info-card sales-card">
                            <a href="" style="text-decoration: none;">
                                <div class="card-body">
                                    <h5 class="card-title">Programme Scolaire<span></span></h5>
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-heptagon"></i>
                                        </div>
                                        {{-- <div class="ps-3">
                                        <h6>{{ $nbre_matiere_prof }}</h6>
                                    </div> --}}
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endif
                <!-- end  -->
                @if (auth()->user()->profil_id != 8 && auth()->user()->profil_id != 6)
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex flex-nowrap justify-content-between align-items-center  p-3">
                                <span class="mb-0">Examens</span>
                                <hr class="flex-grow-1 ml-3">
                            </div>
                        </div>
                    </div>
                    @if (auth()->user()->profil_id == 1 || auth()->user()->profil_id == 5)
                        <div class="col-xxl-4 col-md-4">
                            <div class="card info-card sales-card">
                                <a href="{{ route('examens.index') }}" style="text-decoration: none;">
                                    <div class="card-body">
                                        <h5 class="card-title">Examens Programmation <span></span></h5>
                                        <div class="d-flex align-items-center">
                                            <div
                                                class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-heptagon"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h6>{{ $nbre_examen }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endif


                    <div class="col-xxl-4 col-md-4">
                        <div class="card info-card sales-card">
                            <a href="" style="text-decoration: none;">
                                <div class="card-body">
                                    <h5 class="card-title"> Résultat par classe<span></span></h5>
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-heptagon"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @if (auth()->user()->profil_id == 1 || auth()->user()->profil_id == 5)
                        <div class="col-xxl-4 col-md-4">
                            <div class="card info-card sales-card">
                                <a href="" style="text-decoration: none;">
                                    <div class="card-body">
                                        <h5 class="card-title">Résultat par dossiers<span></span></h5>
                                        <div class="d-flex align-items-center">
                                            <div
                                                class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-heptagon"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endif
                    @if (auth()->user()->profil_id == 1 || auth()->user()->profil_id == 5 || auth()->user()->profil_id == 4)
                        <div class="col-xxl-4 col-md-4">
                            <div class="card info-card sales-card">
                                <a href="{{ route('admin.sessioncorrections') }}" style="text-decoration: none;">
                                    <div class="card-body">
                                        <h5 class="card-title">Sessions corrections <span></span></h5>
                                        <div class="d-flex align-items-center">
                                            <div
                                                class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-heptagon"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h6>{{ $sessionCorrection }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="col-xxl-4 col-md-4">
                            <div class="card info-card sales-card">
                                <a href="" style="text-decoration: none;">
                                    <div class="card-body">
                                        <h5 class="card-title">Devoir de maison<span></span></h5>
                                        <div class="d-flex align-items-center">
                                            <div
                                                class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-heptagon"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endif
                @endif

                @if (auth()->user()->profil_id == 1 ||
                        auth()->user()->profil_id == 5 ||
                        auth()->user()->profil_id == 6 ||
                        auth()->user()->profil_id == 7)
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex flex-nowrap justify-content-between align-items-center  p-3">
                                <span class="mb-0">Finances</span>
                                <hr class="flex-grow-1 ml-3">
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-md-4">
                        <div class="card info-card sales-card">
                            <a href="{{ route('admin.add-etudiant') }}" style="text-decoration: none;">
                                <div class="card-body">
                                    <h5 class="card-title">Inscription Express <span></span></h5>
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-heptagon"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-md-4">
                        <div class="card info-card sales-card">
                            <a href="{{ route('inscription') }}" style="text-decoration: none;">
                                <div class="card-body">
                                    <h5 class="card-title">Liste des inscriptions <span></span></h5>
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-heptagon"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex flex-nowrap justify-content-between align-items-center  p-3">
                                <span class="mb-0">Dossiers</span>
                                <hr class="flex-grow-1 ml-3">
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-md-3">
                        <a href="#" style="text-decoration: none;">
                            <div class="card info-card sales-card">
                                <div class="card-body">
                                    <h5 class="card-title">Dossiers en attente <span></span></h5>
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="ri-user-3-fill"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{ $dossierEnAttente }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <!-- End Sales Card -->

                    <!-- total Card -->
                    <div class="col-xxl-4 col-md-3">
                        <a href="#" style="text-decoration: none;">
                            <div class="card info-card revenue-card">
                                <div class="card-body">
                                    <h5 class="card-title">Dossiers validé <span></span></h5>
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="ri-user-3-fill text-dark"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{ $dossierValide }}</h6>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </a>
                    </div>
                @endif
                
                <div class="row">
                        <div class="col-12">
                            <div class="d-flex flex-nowrap justify-content-between align-items-center  p-3">
                                <span class="mb-0">Annonces</span>
                                <hr class="flex-grow-1 ml-3">
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-md-4">
                        <div class="card info-card sales-card">
                            <a href="" style="text-decoration: none;">
                                <div class="card-body">
                                    <h5 class="card-title">Calendrier <span></span></h5>
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-heptagon"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-xxl-4 col-md-4">
                        <div class="card info-card sales-card">
                            <a href="" style="text-decoration: none;">
                                <div class="card-body">
                                    <h5 class="card-title">Evènements <span></span></h5>
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-heptagon"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                <!-- end  -->
            @endif
        </div>
    </section>
@endsection

<!-- jsScript -->
@section('script-js')
    <script>
        // remove menu active
        $("ul").removeClass('show');
        $("ul li a").removeClass('active');
        // active menu 
        $("#dashboard").removeClass('collapsed');



        function ConvertMonth($month) {
            switch ($month) {
                case "01":
                    return "Janvier";
                    break;

                case "02":
                    return "Février";
                    break;
                case "03":
                    return "Mars";
                    break;
                case "04":
                    return "Avril";
                    break;
                case "05":
                    return "Mai";
                    break;
                case "06":
                    return "Juin";
                    break;
                case "07":
                    return "Juillet";
                    break;
                case "08":
                    return "Août";
                    break;
                case "09":
                    return "Septembre";
                    break;
                case "10":
                    return "Octobre";
                    break;
                case "11":
                    return "Novembre";
                    break;
                case "12":
                    return "Décembre";
                    break;

                default:
                    break;
            }
        }
    </script>
    <!-- End Area Chart -->
@endsection

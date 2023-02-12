@extends('backend.include.layout')
<!-- title -->
@section('title')
    Paramètres || {{env('APP_NAME')}}
@endsection
@section('fil-arial')
    <div class="pagetitle">
        <h1>Paramètres</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" style="text-decoration: none;">Accueil</a></li>
                <li class="breadcrumb-item active">Paramètres</li>
            </ol>
        </nav>
    </div>
@endsection

@section('contenu')
    <section class="section dashboard">  
        <div class="row">  
            <!-- Utilisateurs Card -->   
            <!-- Roles Card -->
            <div class="col-xxl-4 col-md-4">
                <div class="card info-card sales-card">
                    <a href="{{route('statuts.index')}}" style="text-decoration: none;">
                        <div class="card-body">
                            <h5 class="card-title">Statuts <span></span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-playstation"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{$nbre_statut}}</h6>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div><!-- End Roles Card -->

                <!-- Roles Card -->
                <div class="col-xxl-4 col-md-4">
                    <div class="card info-card sales-card">
                        <a href="{{route('profils.index')}}" style="text-decoration: none;">
                            <div class="card-body">
                                <h5 class="card-title">Profil <span></span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-hand-index-thumb"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{$nbre_profil}}</h6>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div><!-- End Roles Card -->

                <div class="col-xxl-4 col-md-4">
                    <div class="card info-card sales-card">
                        <a href="{{route('statutjuridiques.index')}}" style="text-decoration: none;">
                            <div class="card-body">
                                <h5 class="card-title">Statut juridique <span></span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-book-half"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{$nbre_statutjuridique}}</h6>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div> 
            <!-- End Utilisateurs Card --> 


            <div class="col-xxl-4 col-md-4">
                <div class="card info-card sales-card">
                    <a href="{{route('etablissements.index')}}" style="text-decoration: none;">
                        <div class="card-body">
                            <h5 class="card-title">Etablissement <span></span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{$nbre_etablissement}}</h6>
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
                <a href="#" style="text-decoration: none;">
                    <div class="card-body">
                        <h5 class="card-title">Groupe pédagogique<span></span></h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-grip-horizontal"></i>
                            </div>
                            <div class="ps-3">
                                <h6>0</h6>
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
                <a href="{{route('sites.index')}}" style="text-decoration: none;">
                    <div class="card-body">
                        <h5 class="card-title">Sites <span></span></h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-house-door"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{$nbre_site}}</h6>
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
                <a href="{{route('genres.index')}}" style="text-decoration: none;">
                    <div class="card-body">
                        <h5 class="card-title">Genres <span></span></h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-hr"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{$nbre_site}}</h6>
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
                <a href="{{route('niveaux.index')}}" style="text-decoration: none;">
                    <div class="card-body">
                        <h5 class="card-title">Niveaux <span></span></h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-hourglass-bottom"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{$nbre_niveau}}</h6>
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
                <a href="{{route('filieres.index')}}" style="text-decoration: none;">
                    <div class="card-body">
                        <h5 class="card-title">Filière <span></span></h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-card-checklist"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{$nbre_filiere}}</h6>
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
                <a href="{{route('cycles.index')}}" style="text-decoration: none;">
                    <div class="card-body">
                        <h5 class="card-title">Cycles <span></span></h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-recycle"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{$nbre_cycle}}</h6>
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
                <a href="{{route('poles.index')}}" style="text-decoration: none;">
                    <div class="card-body">
                        <h5 class="card-title">Poles <span></span></h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-heptagon"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{$nbre_pole}}</h6>
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
                <a href="{{route('typesponsors.index')}}" style="text-decoration: none;">
                    <div class="card-body">
                        <h5 class="card-title">Type sponsor <span></span></h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-heptagon"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{$nbre_typesponsor}}</h6>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div> 

        <!-- end  -->
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
        $("#parametres").removeClass('collapsed');
    </script>
@endsection

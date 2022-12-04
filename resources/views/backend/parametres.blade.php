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
                    <a href="#" style="text-decoration: none;">
                        <div class="card-body">
                            <h5 class="card-title">Statuts <span></span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-hr"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>0</h6>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div><!-- End Roles Card -->

                <!-- Roles Card -->
                <div class="col-xxl-4 col-md-4">
                    <div class="card info-card sales-card">
                        <a href="#" style="text-decoration: none;">
                            <div class="card-body">
                                <h5 class="card-title">Profil <span></span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-hr"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>0</h6>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div><!-- End Roles Card -->

                <div class="col-xxl-4 col-md-4">
                    <div class="card info-card sales-card">
                        <a href="#" style="text-decoration: none;">
                            <div class="card-body">
                                <h5 class="card-title">Staff <span></span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>0</h6>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div> 
            <!-- End Utilisateurs Card --> 


            <div class="col-xxl-4 col-md-4">
                <div class="card info-card sales-card">
                    <a href="0" style="text-decoration: none;">
                        <div class="card-body">
                            <h5 class="card-title">Historique des actions <span></span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>0</h6>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div> 
        <!-- End Utilisateurs Card --> 

        <!-- siege cironscription -->

        <div class="col-xxl-4 col-md-4">
            <div class="card info-card sales-card">
                <a href="#" style="text-decoration: none;">
                    <div class="card-body">
                        <h5 class="card-title">Groupe pédagogique<span></span></h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="ps-3">
                                <h6>0</h6>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div> 

        <!-- end siege corconscription -->


        <!-- candidat cironscription -->

        <div class="col-xxl-4 col-md-4">
            <div class="card info-card sales-card">
                <a href="#" style="text-decoration: none;">
                    <div class="card-body">
                        <h5 class="card-title">Sites <span></span></h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="ps-3">
                                <h6>0</h6>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div> 

        <!-- end candidat corconscription -->
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

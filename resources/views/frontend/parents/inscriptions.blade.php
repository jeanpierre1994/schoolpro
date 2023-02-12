@extends('frontend.inc.user_layout')

@section('title')
    Inscriptions Etudiants || {{ env('APP_NAME') }}
@endsection

@section('contenu')
    <section style="background-color: #eee;">
        <div class="container py-1">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard_parent') }}">Accueil</a></li> 
                            <li class="breadcrumb-item active" aria-current="page">Dossiers</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-4">
                        <h5 class="card-header">LISTE DES INSCRIPTIONS 
                        </h5>
                        <div class="card-body text-center">
                            <div class="table-responsive">
                                <table class="table align-middle mb-0 data-tables bg-white">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>N°</th>
                                            <th>Dossier N°</th> 
                                            <th>Matricule</th>
                                            <th>Année base</th>
                                            <th>Filière</th>
                                            <th>Groupe pédagogique</th>
                                            <th>Paiement</th> 
                                            <th>Statut</th>
                                        </tr>
                                    </thead>
                                    <tbody class="">
                                        @php
                                            $i = 1
                                        @endphp 
                                        <tr>
                                            <td class="scol text-center">
                                                 <b></b>
                                            </td>
                                            <td>
                                                
                                            </td>
                                            <td>
                                                <p class="fw-normal mb-1"><!-- identité --></p>
                                                <p class="text-muted mb-0"><!-- matricule --></p>
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td> 
                                        </tr>  
                                    </tbody>
                                </table>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js-script')
    <script>
        $(document).ready(function() {
            // remove menu active 
            $("div a").removeClass('active');
            // active menu   
            $("#inscriptions").addClass('active');
        });
    </script>
@endsection

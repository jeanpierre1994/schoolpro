@extends('frontend.inc.user_layout')

@section('title')
    Dossiers Etudiants || {{ env('APP_NAME') }}
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
                        <h5 class="card-header">LISTE DES DOSSIERS 
                        </h5>
                        <div class="card-body text-center">
                            <div class="table-responsive">
                                <table class="table align-middle mb-0 data-tables bg-white">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>N°</th>
                                            <th>Photo</th>
                                            <th>Identité</th>
                                            <th>Etablissement</th>
                                            <th>Pôle</th>
                                            <th>Filière</th>
                                            <th>Cycle</th>
                                            <th>Niveau</th>
                                            <th>Année</th>
                                            <th>Sponsor</th>
                                            <th>Statut</th>
                                        </tr>
                                    </thead>
                                    <tbody class="">
                                        @php
                                            $i = 1
                                        @endphp
                                        @foreach ( $dossiers as $item )
                                        <tr>
                                            <td class="scol text-center">
                                                 <b>{{$item->code}}</b>
                                            </td>
                                            <td>
                                                @if ($item->photo)
                                                <img
                                                    src="{{ asset('storage/photos/'.$item->photo) }}"
                                                    alt=""
                                                    style="width: 45px; height: 45px"
                                                    class="rounded-circle"
                                                    />

                                                @else
                                                <img
                                                    src="https://mdbootstrap.com/img/new/avatars/8.jpg"
                                                    alt=""
                                                    style="width: 45px; height: 45px"
                                                    class="rounded-circle"
                                                    />

                                                @endif
                                            </td>
                                            <td>
                                                {{$item->getPersonne->nom}} {{$item->getPersonne->prenoms}}
                                            </td>
                                            <td>
                                                <p class="fw-normal mb-1">{{$item->getSite->getEtablissement->sigle}}</p>
                                                <p class="text-muted mb-0">Site : {{$item->getSite->sigle}}</p>
                                            </td>
                                            <td>
                                                {{$item->getPole->libelle}}
                                            </td>
                                            <td>{{$item->getFiliere->libelle}}</td>
                                            <td>{{$item->getCycle->libelle}}</td>
                                            <td>{{$item->getNiveau->libelle}}</td>
                                            <td>{{$item->annee}}</td>
                                            <td>
                                                <p class="fw-normal mb-1">{{$item->getTypesponsor->libelle}}</p>
                                                <p class="text-muted mb-0">{{$item->sponsor}}</p>
                                            </td>
                                            <td>
                                                @if ($item->getStatuttraitement->libelle == "EN ATTENTE")
                                                <span class="badge badge-warning rounded-pill d-inline">{{$item->getStatuttraitement->libelle}}</span>
                                                @else
                                                <span class="badge badge-danger rounded-pill d-inline">{{$item->getStatuttraitement->libelle}}</span>
                                                @endif 
                                            </td> 
                                        </tr> 
                                        @endforeach 
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
            $("#dossiers").addClass('active');
        });
    </script>
@endsection

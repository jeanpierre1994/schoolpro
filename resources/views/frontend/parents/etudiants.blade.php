@extends('frontend.inc.user_layout')

@section('title')
    Liste Etudiant || {{ env('APP_NAME') }}
@endsection

@section('contenu')
    <section style="background-color: #eee;">
        <div class="container py-1">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard_parent') }}">Accueil</a></li> 
                            <li class="breadcrumb-item active" aria-current="page">Liste étudiants</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-4">
                        <h5 class="card-header">LISTE DES ETUDIANTS
                        <a href="{{route('parent.add-etudiant')}}" data-mdb-toggle="tooltip" data-mdb-placement="right" title="Nouveau dossier" class="btn btn-primary btn-floating btn-sm">
                            <i class="fas fa-plus"></i>
                        </a>
                        </h5>
                        <div class="card-body text-center">
                            <div class="table-responsive">
                                <table class="table align-middle mb-0 data-tables bg-white">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>N°</th>
                                            <th>Photo</th>
                                            <th>Nom</th>
                                            <th>Prénoms</th>
                                            <th>Téléphone</th>
                                            <th>E-mail</th> 
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="">
                                        @php
                                            $i = 1
                                        @endphp
                                        @foreach ( $etudiants as $item )
                                        <tr>
                                            <td class="scol text-center">
                                                 <b>{{$i++}}</b>
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
                                                {{$item->nom}}
                                            </td>
                                            <td>{{$item->prenoms}}</td>
                                            <td>{{$item->tel}}</td>
                                            <td>{{$item->email}}</td> 
                                            <td>
                                                <a href="#" data-mdb-toggle="tooltip" data-mdb-placement="right" title="Détails" class="btn btn-primary btn-floating btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{route('parent.new-dossier-etudiant',$item->id)}}" data-mdb-toggle="tooltip" data-mdb-placement="right" title="Créer dossier" class="btn btn-primary btn-floating btn-sm">
                                                    <i class="fas fa-folder"></i>
                                                </a>
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
            $("#etudiants").addClass('active');
        });
    </script>
@endsection

@extends('backend/include/layout')
<!-- title -->
@section('title')
    Liste étudiants || {{ env('APP_NAME') }}
@endsection

@section('fil-arial')
    <div class="pagetitle">
        <h1>Dossiers en attente</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" style="text-decoration: none;">Accueil</a></li>
                <li class="breadcrumb-item active"><a href="{{ url()->previous() }}">Groupe pédagogique</a> </li>
                <li class="breadcrumb-item active">Liste des étudiants </li>
            </ol>
        </nav>
    </div>
@endsection

@section('contenu')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Liste des étudiants <br> 
                            Groupe pédagogique : {{$gp->getPole->libelle}} {{$gp->getFiliere->libelle}} {{$gp->libelle_classe}} {{$gp->libelle_secondaire}}
                        </h5>
                        <!-- Bordered Table -->
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-bordered data-tables">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Matricule</th>
                                        <th>Photo</th>
                                        <th>Nom</th>
                                        <th>Prénoms</th>   
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($etudiants as $item)
                                        <tr>
                                            <td class="scol text-center">
                                                <b>{{ $i++ }}</b>
                                            </td>
                                            <td class="scol text-center">
                                                <b>{{ $item->matricule }}</b>
                                            </td>
                                            <td>
                                                @if ($item->getDossier->getPersonne->photo)
                                                    <img src="{{ asset('storage/photos/' . $item->getDossier->getPersonne->photo) }}" alt=""
                                                        style="width: 45px; height: 45px" class="rounded-circle" />
                                                @else
                                                    <img src="https://mdbootstrap.com/img/new/avatars/8.jpg" alt=""
                                                        style="width: 45px; height: 45px" class="rounded-circle" />
                                                @endif
                                            </td>
                                            <td>
                                                {{ $item->getDossier->getPersonne->nom }}
                                            </td>
                                            <td>
                                                {{ $item->getDossier->getPersonne->prenoms }}
                                            </td>  
                                            <td class="text-center">
                                                <a href="{{route('sessioncorrections.show-note',['id'=> $gp->id, 'etudiant_id' => $item->id])}}" title="Notes"><button
                                                    type="button" class="btn btn-sm btn-primary"><i
                                                        class="bi bi-hand-index-thumb" style="color: white"
                                                        aria-hidden="true"></i></button></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- End Bordered Table -->


                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

<!-- jsScript -->
@section('script-js')
    <script>
        $(document).ready(function() {

            // remove menu active
            $("ul").removeClass('show');
            $("ul li a").removeClass('active');
            // active menu
            $("#parametres").removeClass('collapsed');

            //Pour gérer l'activation et la désactivation d'un élément
            // desactivation
            $('a.confirmation-desactivation').confirm({
                title: "",
                content: "<div style='border-bottom: 1px solid #ddd;' class='text-center'><img width='100px' src='{{ asset('front-design/images/logo-white.svg') }}' alt='logo'></div> <br> " +
                    "<div class='text-center'><p class='text-danger'>Désactivation de l'élément ?</p> <span class='text-center'>Cette action est irréversible.</span> </div>",
                type: 'red',
                typeAnimated: true,
                draggable: true,
                dragWindowBorder: false,
                fermer: function() {

                }
            });

            $('a.confirmation-desactivation').confirm({
                buttons: {
                    hey: function() {
                        location.href = this.$target.attr('href');
                    }
                }
            });

            // activation
            $('a.confirmation-activation').confirm({
                title: "",
                content: "<div style='border-bottom: 1px solid #ddd;' class='text-center'><img width='100px' src='{{ asset('front-design/images/logo-white.svg') }}' alt='logo'></div> <br> " +
                    "<div class='text-center'><p class='text-danger'>Activation de l'élément ?</p> <span class='text-center'>Cette action est irréversible.</span> </div>",
                type: 'red',
                typeAnimated: true,
                draggable: true,
                dragWindowBorder: false,
                fermer: function() {

                }
            });
            $('a.confirmation-activation').confirm({
                buttons: {
                    hey: function() {
                        location.href = this.$target.attr('href');
                    }
                }
            });

        });
    </script>
@endsection

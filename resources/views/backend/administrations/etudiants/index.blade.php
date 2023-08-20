@extends('backend/include/layout')
<!-- title -->
@section('title')
    Liste || {{ env('APP_NAME') }}
@endsection

@section('fil-arial')
    <div class="pagetitle">
        <h1>Liste Etudiant</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" style="text-decoration: none;">Accueil</a></li>
                <li class="breadcrumb-item active">Etudiants </li>
                <li class="breadcrumb-item active">Liste </li>
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
                        <h5 class="card-title">Liste des étudiants enregistrés</h5>
                        <!-- Bordered Table -->
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-bordered data-tables">
                                <thead>
                                    <tr>
                                        <th>Etablissement</th>
                                        <th>N° Dossier</th>
                                        <th>Photo</th>
                                        <th>Nom</th>
                                        <th>Prénoms</th>
                                        <th>Groupe Pédagogique</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($etudiants as $etudiant)
                                        <tr>
                                            <td class="scol text-center">
                                                <b>{{ $etudiant->getDossier->getSite->sigle }}</b>
                                            </td>
                                            <td class="scol text-center">
                                                <b>{{ $etudiant->matricule }}</b>
                                            </td>
                                            <td>
                                                @if ($etudiant->getDossier->getPersonne->photo)
                                                    <img src="{{ asset('storage/photos/' . $item->photo) }}" alt=""
                                                        style="width: 45px; height: 45px" class="rounded-circle" />
                                                @else
                                                    <img src="https://mdbootstrap.com/img/new/avatars/8.jpg" alt=""
                                                        style="width: 45px; height: 45px" class="rounded-circle" />
                                                @endif
                                            </td>
                                            <td>
                                                {{ $etudiant->getDossier->getPersonne->nom }} 
                                            </td>
                                            <td>
                                                {{ $etudiant->getDossier->getPersonne->prenoms }} 

                                            </td>
                                            <td>
                                                {{ $etudiant->getGp->libelle_classe . " | " . $etudiant->getGp->libelle_secondaire }} 

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

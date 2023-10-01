@extends('backend/include/layout')
<!-- title -->
@section('title')
    Dossier validé || {{ env('APP_NAME') }}
@endsection

@section('fil-arial')
    <div class="pagetitle">
        <h1>Dossiers validé</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" style="text-decoration: none;">Accueil</a></li>
                <li class="breadcrumb-item active">Dossiers validé </li>
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
                        <h5 class="card-title">Liste des dossiers validés</h5>
                        <!-- Bordered Table -->
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-bordered data-tables">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Photo</th>
                                        <th>Identité</th>
                                        <th>Etablissement</th>
                                        <th>Pôle</th>
                                        <th>Filière</th>
                                        <th>Cycle</th>
                                        <th>Groupe Péda.</th>
                                        <th>Niveau</th>
                                        <th>Année</th>
                                        <th>Sponsor</th>
                                        <th>Statut</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($dossiers as $item)
                                        <tr>
                                            <td class="scol text-center">
                                                <b>{{ $item->matricule }}</b>
                                            </td>
                                            <td>
                                                @if ($item->getDossier->photo)
                                                    <img src="{{ asset('storage/photos/' . $item->getDossier->photo) }}"
                                                        alt="" style="width: 45px; height: 45px"
                                                        class="rounded-circle" />
                                                @else
                                                    <img src="https://mdbootstrap.com/img/new/avatars/8.jpg" alt=""
                                                        style="width: 45px; height: 45px" class="rounded-circle" />
                                                @endif
                                            </td>
                                            <td>
                                                {{ $item->getDossier->getPersonne->nom }}
                                                {{ $item->getDossier->getPersonne->prenoms }}
                                            </td>
                                            <td>
                                                <p class="fw-normal mb-1">
                                                    {{ $item->getDossier->getSite->getEtablissement->sigle }}</p>
                                                <p class="text-muted mb-0">Site : {{ $item->getDossier->getSite->sigle }}
                                                </p>
                                            </td>
                                            <td>
                                                {{ $item->getDossier->getPole->libelle }}
                                            </td>
                                            <td>{{ $item->getDossier->getFiliere->libelle }}</td>
                                            <td>{{ $item->getDossier->getCycle->libelle }}</td>
                                            <td>{{ $item->getGp->libelle_classe }} {{ $item->getGp->libelle_secondaire }}
                                            </td>
                                            <td>{{ $item->getDossier->getNiveau->libelle }}</td>
                                            <td>{{ $item->getDossier->annee }}</td>
                                            <td>
                                                <p class="fw-normal mb-1">{{ $item->getDossier->getTypesponsor->libelle }}
                                                </p>
                                                <p class="text-muted mb-0">{{ $item->getDossier->sponsor }}</p>
                                            </td>
                                            <td>
                                                @if ($item->getDossier->getStatuttraitement->libelle == 'EN ATTENTE')
                                                    <span
                                                        class="badge badge-warning rounded-pill d-inline">{{ $item->getDossier->getStatuttraitement->libelle }}</span>
                                                @else
                                                    <span
                                                        class="badge badge-success rounded-pill d-inline">{{ $item->getDossier->getStatuttraitement->libelle }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-evenly">
                                                    <a href="{{ route('admin.paiements.list', \Crypt::encrypt($item->id)) }}" class="page-constructionv" >
                                                        <button type="button" title="Historique des paiements"
                                                            class="btn btn-sm btn-primary"><i class="bi  bi-clock"
                                                                style="color: white" aria-hidden="true"></i></button>
                                                    </a>
                                                    <a title="Ajouter un paiement" href="{{route('admin.reglement-paiement',$item->getDossier->id)}}" class="btn btn-sm btn-success">
                                                        <i class="bi bi-credit-card" style="color: white" aria-hidden="true"></i>
                                                    </a>
                                                </div>
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

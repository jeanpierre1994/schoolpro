@extends('backend/include/layout')
<!-- title -->
@section('title')
    Dossier validé || {{ env('APP_NAME') }}
@endsection

@section('fil-arial')
    <div class="pagetitle">
        <h1>Détails des Grilles Tarifaires</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" style="text-decoration: none;">Accueil</a></li>
                <li class="breadcrumb-item active">Détails des Grilles Tarifaires</li>
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
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <h5 class="card-title">Détails des Grilles Tarifaires
                                    <a href="{{ route('ligne_tarifaires.create') }}" data-mdb-toggle="tooltip"
                                        data-mdb-placement="right" title="Ajouter" class="btn btn-primary btn-floating btn-sm">
                                        Ajouter
                                    </a>
                                </h5>
                            </div>
                            <div class="col-md-4">  
                                    <form action="{{route('admin.liste_tarif')}}" method="post">
                                        @csrf
                                        <select class="form-select form-select-lg" name="grille_tarifaire" id="grille_tarifaire">
                                            <option selected>--- Grille traifaire ---</option>
                                            @foreach ($grilleTarifaires as $item)
                                                <option value="{{$item->id}}">{{$item->libelle}} / {{$item->libelle_secondaire}}</option>
                                            @endforeach
                                        </select> 
                                        <button type="submit" class="d-none" id="valider">Valider</button>
                                    </form>
                            </div>
                        </div>
                        <!-- Bordered Table -->
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-bordered data-tables">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Code</th>
                                        <th>Rubrique</th>
                                        <th>Grille Tarifaire</th>
                                        <th>Montant</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($ligneTarifaires as $ligneTarifaire)
                                        <tr>
                                            <td class="scol text-center">
                                                <b>{{ $i++ }}</b>
                                            </td>
                                            <td class="scol text-center">
                                                <b>{{ $ligneTarifaire->code }}</b>
                                            </td>
                                            <td>
                                                {{ $ligneTarifaire->rubrique->libelle }}
                                            </td>
                                            <td>
                                                {{ $ligneTarifaire->grilleTarifaire->libelle }}
                                            </td>

                                            <td>
                                                {{ $ligneTarifaire->montant }}
                                            </td>
                                            <td>

                                                <a href="{{ route('ligne_tarifaires.edit', $ligneTarifaire->id) }}"
                                                    title="Modifier"><button type="button"
                                                        class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"
                                                            style="color: white" aria-hidden="true"></i></button></a>

                                                <a href="#" class="page-constructionv" data-bs-toggle="modal"
                                                    data-bs-target="#myModal_{{ $ligneTarifaire->id }}">
                                                    <button type="button" title="Supprimer"
                                                        class="btn btn-sm btn-danger"><i class="bi bi-trash"
                                                            style="color: white" aria-hidden="true"></i></button>
                                                </a>

                                                <!-- The Modal -->
                                                <div class="modal text-center" id="myModal_{{ $ligneTarifaire->id }}">
                                                    <div class="modal-dialog modal-md modal-dialog-centered">
                                                        <div class="modal-content text-center">

                                                            <!-- Modal Header -->
                                                            <div class="modal-header">
                                                                <h4 class="modal-title text-center"
                                                                    style="text-align: center;">Confirmer l'action <i
                                                                        class="bi bi-trash text-danger"></i></h4>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"></button>
                                                            </div>

                                                            <!-- Modal body -->
                                                            <div class="modal-body">
                                                                <div class="row mt-2 mb-2">
                                                                    <div
                                                                        class="col-md-12 text-center font-weight-bold font-height-10">
                                                                        Voulez-vous vraiment supprimer cet élément ?
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Modal footer -->
                                                            <div class="modal-footer">

                                                                <form
                                                                    action="{{ route('liste_tarif.supprimer') }}"
                                                                    method="post"> 
                                                                    @csrf
                                                                    <input type="hidden" name="id" value="{{$ligneTarifaire->id}}">
                                                                    <button type="submit" class="btn btn-danger btn-md"
                                                                        id="" value="">OUI
                                                                    </button>
                                                                    <button type="button" class="btn btn-md btn-secondary"
                                                                        data-bs-dismiss="modal">NON</button>
                                                                </form>
                                                            </div>

                                                        </div>
                                                    </div>
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

            $('#grille_tarifaire').on('change', function() {  
            var grille_id = parseInt($(this).val()); 

            if (grille_id != null) {
                $("#valider").trigger("click");
            }
 });

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

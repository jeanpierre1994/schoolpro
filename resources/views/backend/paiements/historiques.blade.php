@extends('backend/include/layout')
<!-- title -->
@section('title')
    Paiements || {{ env('APP_NAME') }}
@endsection

@section('fil-arial')
    <div class="pagetitle">
        <h1>Liste des Paiements</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" style="text-decoration: none;">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" style="text-decoration: none;">Dashboard</a>
                </li> 
                <li class="breadcrumb-item active">Liste des Paiements </li>
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
                        <h5 class="card-title">Liste des paiements des dossiers <code>Montant total : <b id="update_montant"></b></code> </h5>
                        <!-- Bordered Table -->
                        <div class="table-responsive">
                            <table id="tableHead" class="table table-striped table-hover table-bordered data-tables">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Filière</th>
                                        <th scope="col">Cycle</th>
                                        <th scope="col">Pôle</th>
                                        <th scope="col">Groupe péda</th>
                                        <th scope="col">Référence</th>
                                        <th scope="col">Rubrique</th>
                                        <th scope="col">Montant Rubrique</th>
                                        <th scope="col">Montant Payé</th>
                                        <th scope="col">Restant</th>
                                        <!--<th scope="col">Réglé par</th>-->
                                        <th scope="col">Date du paiement</th>
                                        <!--<th scope="col">Action</th>-->
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                        $somme = 0;
                                    @endphp
                                    @foreach ($echeanciers as $echeance)
                                        @foreach (getHistoriquePaiement($echeance->id) as $item)
                                        @php
                                            $somme += $item->montant_payer;
                                        @endphp
                                        <tr> 
                                            <td class="text-center"><b>{{ $i++ }}</b></td>
                                            <td class=""><b>{{ $item->getEcheancier->dossier_id ? $item->getEcheancier->getDossier->getGp->getFiliere->libelle : '' }}</b></td>
                                            <td class=""><b>{{ $item->getEcheancier->dossier_id ? $item->getEcheancier->getDossier->getGp->getCycle->libelle : '' }}</b></td>
                                            <td class=""><b>{{ $item->getEcheancier->dossier_id ? $item->getEcheancier->getDossier->getGp->getPole->libelle : '' }}</b></td>
                                            <td class=""><b>{{ $item->getEcheancier->dossier_id ? $item->getEcheancier->getDossier->getGp->libelle_classe : '' }} {{ $item->getEcheancier->dossier_id ? $item->getEcheancier->getDossier->getGp->libelle_secondaire : '' }}</b></td>
                                            <td><b>{{ $item->getPaiement->reference }}</b> </td>
                                            <td><b>{{ $item->getEcheancier->getLignetarif->grilleTarifaire->libelle }} <br> {{ $item->getEcheancier->getLignetarif->rubrique->libelle }}</b>
                                            </td>
                                            <td>
                                                {{ $item->getEcheancier->montant_rubrique }}
                                            </td>
                                            <td>
                                                {{ number_format($item->montant_payer, 0, ',', '.') }}
                                            </td>
                                            <td> 
                                                {{ number_format($item->getEcheancier->montant_restant, 0, ',', '.') }}
                                            </td>
                                            {{-- <td>
                                                {{ $dossier->created_by }}
                                            </td>--}}

                                            <td>
                                                {{ \Carbon\Carbon::parse($item->date_paiement)->format('d-m-Y') }}
                                            </td>
                                            <div class="d-flex justify-content-evenly">
                                                <!--<a href="#" title="Modifier"><button type="button"
                                                                                    class="btn btn-sm btn-warning"><i
                                                                                        class="bi bi-pencil-square" style="color: white"
                                                                                        aria-hidden="true"></i></button></a>-->
{{--                                                <a href="#" title="Supprimer"><button type="button"
                                                        class="btn btn-sm btn-danger show-delete-modal"><i
                                                            class="bi bi-trash" style="color: white"
                                                            aria-hidden="true"></i></button></a>--}}
                                            </div>
                                            </td>

                                        </tr>
                                        @endforeach
                                        
                                    @endforeach

                                </tbody>
                            </table>
                            @php
                                $montant_total = number_format($somme, 0, ',', '.');
                            @endphp
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
            $("#update_montant").text("{{$montant_total}}"+"F CFA")

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

            // show delete modal
            $(".show-delete-modal").on("click", function() {
                $("#libelle_matiere").val($(this).attr("data-libelle-matiere"));
                $("#gp_id").val($(this).attr("data-gp"));
                $("#matiere_delete_id").val($(this).attr("data-matiere"));
                $("#prof_sup_id").val($("#prof_delete_id").val())
                $('#modalDeleteMatiere').modal('show')
            });

            // show modal
            $(".show-modal").on("click", function() {
                $('#modalMatiere').modal('show')
            });

        });
        (() => {
            'use strict';

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            const forms = document.querySelectorAll('.needs-validation');

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms).forEach((form) => {
                form.addEventListener('submit', (event) => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        });
    </script>
@endsection

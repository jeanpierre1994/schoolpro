@extends('backend/include/layout')
<!-- title -->
@section('title')
    Matière || {{ env('APP_NAME') }}
@endsection

@section('fil-arial')
    <div class="pagetitle">
        <h1>Détails des Paiements</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" style="text-decoration: none;">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" style="text-decoration: none;">Dashboard</a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('dossiers.valide') }}">Dossiers Validés</a> </li>
                <li class="breadcrumb-item active">Détails de Paiements </li>
            </ol>
        </nav>
    </div>
@endsection

@section('contenu')
    <section class="section">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="" class="form-label"><u>N° Dossier</u> :</label>
                <span><b>{{ $dossier->code }}</b></span>
            </div>
            <div class="col-md-6 mb-3">
                <label for="" class="form-label"><u>Etudiant </u> :</label>
                <b><span>{{ $dossier->getPersonne->nom . ' ' . $dossier->getPersonne->prenoms }}</span></b>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Etat des paiements du dossiers </h5>
                        <!-- Bordered Table -->
                        <div class="table-responsive">
                            <table id="tableHead" class="table table-striped table-hover table-bordered data-tables">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Code</th>
                                        <th scope="col">Rubrique</th>
                                        <th scope="col">Montant Rubrique</th>
                                        <th scope="col">Montant Payé</th>
                                        <th scope="col">Restant</th>
                                        <th scope="col">Réglé par</th>
                                        <th scope="col">Date du paiement</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($dossier->getEcheancier->getPaiement as $paiement)
                                        <tr>
                                            <td class="text-center"><b>{{ $i++ }}</b></td>
                                            <td><b>{{ $paiement->code }}</b> </td>
                                            <td><b>{{ $dossier->getEcheancier->getLignetarif->rubrique->libelle . ' ' . $paiement->getEcheancier->getLignetarif->rubrique->libelle_secondaire }}</b>
                                            </td>
                                            <td>
                                                {{ $dossier->getEcheancier->montant_rubrique }}
                                            </td>
                                            <td>
                                                {{ $dossier->getEcheancier->montant_payer }}
                                            </td>
                                            <td>
                                                {{ $dossier->getEcheancier->montant_restant }}
                                            </td>
                                            <td>
                                                {{ $dossier->created_by }}
                                            </td>
                                            <td>
                                                {{ $paiement->date_paiement }}
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

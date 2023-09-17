@extends('backend/include/layout')
<!-- title -->
@section('title')
    Rubriques || {{ env('APP_NAME') }}
@endsection

@section('fil-arial')
    <div class="pagetitle">
        <h1>Paiements</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" style="text-decoration: none;">Accueil</a></li>
                <li class="breadcrumb-item active">Paiements </li>
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
                        <h5 class="card-title">Etat des paiements
                        </h5>
                        <!-- Bordered Table -->
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-bordered data-tables">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Code</th>
                                        <th>Payeur</th>
                                        <th>Montant Payé</th>
                                        <th>Montant Restant</th>
                                        <th>Date Paiement</th>
                                        <th>Dossier</th>
                                        <th>Statut</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($paiements as $paiement)
                                        <tr>
                                            <td class="scol text-center">
                                                <b>{{ $i }}</b>
                                            </td>
                                            <td class="scol text-center">
                                                <b>{{ $paiement->code }}</b>
                                            </td>
                                            <td>
                                                <b>Nom Payeur</b>
                                            </td>
                                            <td>
                                                {{ $paiement->montant_paye }}
                                            </td>
                                            <td>
                                                {{ $paiement->montant_restant }}
                                            </td>
                                            <td>
                                                {{ $paiement->date_paiement }}
                                            </td>                                            <td>

                                                @if ($i)
                                                    <span class="badge badge-warning rounded-pill d-inline">Attente</span>
                                                @else
                                                    <span class="badge badge-success rounded-pill d-inline"></span>
                                                @endif
                                            </td>
                                        </tr>
                                        @php
                                            $i++;
                                        @endphp
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

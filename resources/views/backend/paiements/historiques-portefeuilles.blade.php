@extends('backend/include/layout')
<!-- title -->
@section('title')
    Paiements || {{ env('APP_NAME') }}
@endsection

@section('fil-arial')
    <div class="pagetitle">
        <h1>Liste des Paiements (Recharge portefeuille)</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" style="text-decoration: none;">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" style="text-decoration: none;">Dashboard</a>
                </li> 
                <li class="breadcrumb-item active">Liste des Paiements (Recharge portefeuille) </li>
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
                        <h5 class="card-title">Liste des paiements (Recharge portefeuille) <code>Montant total : <b>{{number_format($montant_total, 0, ',', '.')}}F CFA</b></code> </h5>
                        <!-- Bordered Table -->
                        <div class="table-responsive">
                            <table id="tableHead" class="table table-striped table-hover table-bordered data-tables">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Portefeuille de</th> 
                                        <th scope="col">Montant rechargé (F CFA)</th> 
                                        <th scope="col">Date du paiement</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($portefeuilles as $item) 
                                        <tr> 
                                            <td class="text-center"><b>{{ $i++ }}</b></td>  
                                            <td>
                                                {{ $item->getPortefeuille->getPersonne->nom }} {{ $item->getPortefeuille->getPersonne->prenoms }}
                                            </td>
                                            <td>
                                                {{ number_format($item->new_montant, 0, ',', '.') }}
                                            </td> 

                                            <td>
                                                {{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i:s') }}
                                            </td> 
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

@extends('backend/include/layout')
<!-- title -->
@section('title')
    Edition de l'échéancier || {{ env('APP_NAME') }}
@endsection


@section('fil-arial')
    <div class="pagetitle">
        <h1>Edition de l'échéancier</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" style="text-decoration: none;">Accueil</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('dossiers.valide') }}">Dossiers validés</a> </li>
                <li class="breadcrumb-item active">Edition de l'échéancier </li>
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
                        <div class="card-title" style="margin: 0px;">
                            <div class="row">

                                <div class="col-md-3">
                                    <pre>Solde portefeuille : <span class="badge rounded-pill text-bg-primary"> <i class="fa fa-credit-card" aria-hidden="true"></i> <b id="update_portefeuille">{{ number_format($dossier->getPortefeuille->montant, 0, ',', '.') }} F CFA</b> </span> </pre>
                                </div>
                                <div class="col-md-3">
                                    <pre>Apprenant : <b>{{ $dossier->getPersonne->nom }} {{ $dossier->getPersonne->prenoms }}</b> </pre>
                                </div>
                                <div class="col-md-3">
                                    <pre>Groupe péda.: <b>{{ $dossier->getGp->libelle_classe }} {{ $dossier->getGp->libelle_secondaire }}</b></pre>
                                </div>
                                <div class="col-md-3">
                                    <pre>Parent : {{ $dossier->parent_id ? $dossier->getParent->getParentInfo($dossier->parent_id)->nom . ' ' . $dossier->getParent->getParentInfo($dossier->parent_id)->prenoms : '' }} </pre>
                                </div>

                            </div>
                            <hr>
                             
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edition de l'échéancier</h5>
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Error!</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <form action="{{ route('store.update_echeancier') }}" method="post">
                            @csrf
                            @method('post')
                            <!-- Bordered Table -->
                            <div class="table-responsive">
                                <div class=" float-right mb-3">
                                    Total montant négocié : <b id="total_montant_negocie">0 FCFA</b> &nbsp;&nbsp; Total
                                    <div class="d-none">montant réglé : <b id="total_montant_regle">0F CFA</b> &nbsp;</div>
                                    <input type="hidden" name="get_montant_total_negocier" id="get_montant_total_negocier">
                                    <input type="hidden" name="get_montant_total_regler" id="get_montant_total_regler">

                                    <input type="hidden" id="dossier_id" name="dossier_id" value="{{ $dossier->id }}" required>
                                    <input type="hidden" id="montant_portefeuille" name="montant_portefeuille"
                                        value="{{ $dossier->getPortefeuille->montant }}" required>
                                    <button type="submit" id="valider_echeancierx" class="btn btn-primary">Valider
                                        l'édition</button>
                                </div>
                                <table class="table table-striped table-hover table-bordered data-tables">
                                    <thead>
                                        <tr class="text-center">
                                            <th scope="col">#</th>
                                            <th scope="col">Dossier</th>
                                            <th scope="col">Famille / Rubrique</th>
                                            <th scope="col">Montant rubrique</th>
                                            <th scope="col">Remise</th>
                                            <th scope="col">Montant négocié</th>
                                            <th scope="col">Montant restant</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                            $net_a_payer = 0;
                                        @endphp
                                        @foreach ($echeanciers as $item)
                                        <div class="d-none">
                                            <input type="text" name="echeancier_id[]" value="{{$item->id}}" required>
                                        </div>
                                            @php
                                                $net_a_payer = $net_a_payer + $item->montant_rubrique;
                                            @endphp

                                            <tr> 
                                                <td class="text-center"><b>{{ $i++ }}</b></td>
                                                <td>{{ $item->dossier_id ? $item->getDossier->code : '' }}</td>
                                                <td>{{ $item->lignetarif_id ? $item->famille : '' }}
                                                    <br>
                                                    <b>{{ $item->lignetarif_id ? $item->rubrique : '' }}</b>
                                                </td>
                                                <td>{{ number_format($item->montant_rubrique, 0, ',', '.') }}</td>
                                                <td><input class="remise" value="0" type="number" width="50px"
                                                        name="remise[]" data-remise="remise_{{ $item->id }}"
                                                        id="remise_{{ $item->id }}" max="{{ $item->montant_restant }}" min="0"></td>
                                                <td><input class="montant_negocier" value="{{ $item->montant_payer }}"
                                                        data-montantnegocier="montant_negocier_{{ $item->id }}"
                                                        id="montant_negocier_{{ $item->id }}" readonly type="number"
                                                        width="50px" name="montant_negocier[]" min="0"></td>
                                                        <td><input class="montant_restant" value="{{ $item->montant_restant }}"
                                                            data-montantrestant="montant_restant_{{ $item->id }}"
                                                            id="montant_restant_{{ $item->id }}" readonly type="number"
                                                            width="50px" name="montant_restant[]" min="0"></td>
                                                <td class="text-center">
                                                    <div class="d-flex justify-content-evenly">
                                                        <a href="#" class="page-constructionv" data-bs-toggle="modal"
                                                            data-bs-target="#myModal_{{ $item->id }}">
                                                            <button type="button" title="Retirer"
                                                                class="btn btn-sm btn-danger"><i class="bi bi-trash"
                                                                    style="color: white" aria-hidden="true"></i></button>
                                                        </a>

                                                        <!-- The Modal -->
                                                        <div class="modal text-center" id="myModal_{{ $item->id }}">
                                                            <div class="modal-dialog modal-md modal-dialog-centered">
                                                                <div class="modal-content text-center">

                                                                    <!-- Modal Header -->
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title text-center"
                                                                            style="text-align: center;">Confirmer l'action
                                                                            <i class="bi bi-trash text-danger"></i></h4>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"></button>
                                                                    </div>

                                                                    <!-- Modal body -->
                                                                    <div class="modal-body">
                                                                        <div class="row mt-2 mb-2">
                                                                            <div
                                                                                class="col-md-12 text-center font-weight-bold font-height-10">
                                                                                Voulez-vous vraiment retirer cet élément ?
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Modal footer -->
                                                                    <div class="modal-footer">
 
                                                                            <a href="{{ route('paiement.edition-retirerRubrique', $item->id) }}">
                                                                                <button type="button"
                                                                                class="btn btn-danger btn-md"
                                                                                id="" value="">OUI
                                                                            </button>
                                                                            </a>
                                                                            <button type="button"
                                                                                class="btn btn-md btn-secondary"
                                                                                data-bs-dismiss="modal">NON</button> 
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- End modal -->
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach

                        </form>
                        </tbody>
                        </table>
                    </div>
                    <!-- End Bordered Table -->


                </div>
            </div>
        </div>

        {{-- <div class="col-lg-4">
                <div class="card">
                    <div class="card-body"> 
                        <!-- Bordered Table -->
                        <div class="table-responsivex">
                            <div class="rowx">
                                <form id="form" action="{{route('paiements.rechargePortefeuille')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" value="{{ $dossier->id }}" name="dossier_id">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label for="label">Net à payer <i class="text-danger"></i></label>
                                                <input type="number" readonly min="0" name="note_max" id="note_max"
                                                    class="form-control" value="{{ number_format($net_a_payer, 0, ',', '.') }}">
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="label">Montant à recharger <i
                                                        class="text-danger">*</i></label>
                                                <input type="number" min="0" name="montant" id="montant"
                                                    class="form-control" value="" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="label">Mode de paiement <i class="text-danger">*</i></label>
                                                <select class="form-select" name="modepaiement" id="modepaiement" required>
                                                    <option selected value="">Sélectionnez une option</option>
                                                    <option value="MoMo">MoMo</option>
                                                    <option value="Virement">Virement</option>
                                                    <option value="Chèque">Chèque</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="label">Preuve de paiement<i class="text-danger"></i></label>
                                                <input type="file" min="0" name="preuve" id="preuve"
                                                    class="form-control" value="">
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="label">Référence de paiement <i
                                                        class="text-danger"></i></label>
                                                <input type="text" min="0" name="reference" id="reference"
                                                    class="form-control" placeholder="AZ2817281" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="{{ route("dashboard") }}">
                                            <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Retour</button>
                                        </a> 
                                            <button type="submit" id="valider" class="btn btn-primary">Procéder au
                                                paiement</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                        <!-- End Bordered Table -->


                    </div>
                </div>
            </div> --}}


        <!-- modal -->

        <div class="modal fade" id="modalCrediter" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="modale" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary w-100 text-center text-white">
                        <h5 class="modal-title text-white" id="modalDelete"><i class="fa fa-credit-card"
                                aria-hidden="true"></i> Crédité portefeuille</h5>
                        <button type="button" class="btn-close hide-modal" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form id="form" action="" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="{{ $dossier->getPortefeuille->id }}" name="portefeuille_id">
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="label">Solde actuel <i class="text-danger">*</i></label>
                                    <input type="number" min="0" name="solde" id="solde"
                                        class="form-control" value="{{ $dossier->getPortefeuille->montant }}" readonly
                                        required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="label">Montant à recharger <i class="text-danger">*</i></label>
                                    <input type="number" min="0" name="montant" id="montant"
                                        class="form-control" value="" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="label">Mode de paiement <i class="text-danger">*</i></label>
                                    <select class="form-select" name="modepaiement" id="modepaiement" required>
                                        <option selected value="">Sélectionnez une option</option>
                                        <option value="MoMo">MoMo</option>
                                        <option value="Virement">Virement</option>
                                        <option value="Chèque">Chèque</option>
                                        <option value="Cash">Cash</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="label">Preuve de paiement<i class="text-danger"></i></label>
                                    <input type="file" min="0" name="preuve" id="preuve"
                                        class="form-control" value="">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="label">Référence de paiement <i class="text-danger"></i></label>
                                    <input type="text" min="0" name="reference" id="reference"
                                        class="form-control" placeholder="AZ2817281" value="">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary hide-modal"
                                data-dismiss="modal">Fermer</button>
                            <button type="btn" id="paiement" class="btn btn-primary">Procéder au
                                paiement</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- end modal export -->

        </div>
    </section>
    <script src="https://cdn.kkiapay.me/k.js"></script>
    <script>
        $(document).ready(function() {
            // désactiver le bouton valider l'échéancier
            $("#valider_echeancier").prop('disabled', true);
            getTotalMontantNegocie();
            getTotalMontantRegle();

            // changement de remise
            $(".remise").on('change', function() {
                var montant_remise = parseInt($(this).val())
                var id_rubrique = $(this).attr("data-remise").split('_')[1]
                var montant_negocier = $("#montant_negocier_" + id_rubrique).val()
                var montant_restant = $("#montant_restant_" + id_rubrique).val()

                if (montant_remise <= montant_restant) {
                    montant_negocier = montant_negocier - montant_remise;
                    $("#montant_negocier_" + id_rubrique).val(montant_negocier)
                    //$("#montant_regle_" + id_rubrique).val(montant_negocier)
                } else {
                    swal({
                        title: "Attention!!!",
                        text: "Le montant de la remise ne doit pas être supérieur au motant restant.",
                        buttons: true,
                        closeOnClickOutside: false,
                        timer: 3000,
                        icon: "error"
                    });
                    $(this).val(0)
                }
                checkMontantRegle("{{ $dossier->getPortefeuille->montant }}")
                getTotalMontantNegocie();
                getTotalMontantRegle();
            })

            // changement montant réglé
            $(".montant_regle").on('change', function() {
                var montant_regle = parseInt($(this).val())
                var id_rubrique = parseInt($(this).attr("data-montantregle").split('_')[2])
                var montant_negocier = parseInt($("#montant_negocier_" + id_rubrique).val())
                
                if (montant_regle > montant_negocier) {
                    swal({
                        title: "Attention!!!",
                        text: "Le montant réglé ne peut pas être supérieur au montant négocié.",
                        buttons: true,
                        closeOnClickOutside: false,
                        timer: 3000,
                        icon: "error"
                    });
                    $(this).val(0)
                }
                checkMontantRegle("{{ $dossier->getPortefeuille->montant }}")
                getTotalMontantRegle();
            })


            checkMontantRegle("{{ $dossier->getPortefeuille->montant }}")

            function checkMontantRegle(montant_portefeuille) {
                var all_montant = document.querySelectorAll(".montant_regle")
                var somme = 0
                for (let index = 0; index < all_montant.length; index++) {
                    var inputValue = parseFloat(all_montant[index]
                        .value); // Convertissez la valeur en nombre (en cas de chaîne)
                    if (!isNaN(inputValue)) {
                        somme += inputValue; // Ajoutez la valeur à la somme si c'est un nombre valide
                    }
                }

                if (somme > parseInt(montant_portefeuille)) {
                    /*swal({
                        title: "Attention!!!",
                        text: "Le portefeuille ne peut pas couvrir la somme des montants à régler.",
                        buttons: true,
                        closeOnClickOutside: false,
                        timer: 3000,
                        icon: "error"
                    });*/
                    $("#valider_echeancier").prop('disabled', true);
                    return false;
                } else {
                    $("#valider_echeancier").prop('disabled', false);
                    return true;
                }
            }

            // return montant négocié 
            function getTotalMontantNegocie(montant_portefeuille) {
                var all_montant = document.querySelectorAll(".montant_negocier")
                var somme = 0
                for (let index = 0; index < all_montant.length; index++) {
                    var inputValue = parseFloat(all_montant[index]
                        .value); // Convertissez la valeur en nombre (en cas de chaîne)
                    if (!isNaN(inputValue)) {
                        somme += inputValue; // Ajoutez la valeur à la somme si c'est un nombre valide
                    }
                }
                $("#total_montant_negocie").text(formatNumber(somme) + " F CFA");
                $("#get_montant_total_negocier").val(somme)
                return true;
            }
            // return montant réglé
            function getTotalMontantRegle(montant_portefeuille) {
                var all_montant = document.querySelectorAll(".montant_regle")
                var somme = 0
                for (let index = 0; index < all_montant.length; index++) {
                    var inputValue = parseFloat(all_montant[index]
                        .value); // Convertissez la valeur en nombre (en cas de chaîne)
                    if (!isNaN(inputValue)) {
                        somme += inputValue; // Ajoutez la valeur à la somme si c'est un nombre valide
                    }
                }
                $("#total_montant_regle").text(formatNumber(somme) + " F CFA");
                $("#get_montant_total_regler").val(somme)
                return true;
            }
            // show modal
            $(".show-modal").on("click", function() {
                $('#modalCrediter').modal('show')
            });
            $(".hide-modal").on("click", function() {
                $('#modalCrediter').modal('hide')
            });

            // paiement par kkiapay
            function showKkiapay(montant, reference, nom_client, status_sandbox, key) {
                openKkiapayWidget({
                    amount: montant,
                    position: "center",
                    data: reference,
                    name: nom_client,
                    //callback:
                    theme: "blue",
                    sandbox: status_sandbox,
                    key: key,
                    //paymentmethod: mode
                });
            }

            // save paiement by kkiapay

            function savePaiementKkiapay(idTransaction, reference_paiement) {
                $.ajax({
                    url: "{{ route('update-kkiapay-transaction') }}",
                    data: {
                        reference: reference_paiement,
                        id_transaction: idTransaction,
                        portefeuille_id: parseInt("{{ $dossier->getPortefeuille->id }}"),
                        _token: '{{ csrf_token() }}'
                    },
                    type: 'POST',
                    dataType: 'json',
                    beforeSend: function() {
                        swal({
                            title: "Veuillez patienter",
                            text: "Traitement des données en cours ...",
                            icon: "https://www.boasnotas.com/img/loading2.gif",
                            buttons: false,
                            closeOnClickOutside: false,
                            //timer: 3000,
                            //icon: "success"
                        });
                    },

                    success: function(data, status) {
                        swal.close();
                        $("#update_portefeuille").text(formatNumber(data
                            .montant_portefeuille) + " F CFA");
                        $("#montant_portefeuille").val(data.montant_portefeuille)
                        $("#solde").val(data.montant_portefeuille);
                        checkMontantRegle(data.montant_portefeuille);
                        swal({
                            title: "Succès!!!",
                            text: "Opération effectuée avec succès.",
                            buttons: true,
                            closeOnClickOutside: false,
                            timer: 3000,
                            icon: "success"
                        });
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        swal.close();
                        console.log(xhr);
                        console.log(textStatus);
                        console.log(errorThrown);
                    }
                });
            }

            addSuccessListener(response => {
                //console.log(response)
                savePaiementKkiapay(response.transactionId, response.data)
                /*swal({
                                  title:"Merci de ne pas quitter cette page.", 
                                  text:"traitement des données...",
                                  icon: "https://www.boasnotas.com/img/loading2.gif",
                                  buttons: false,      
                                  closeOnClickOutside: false,
                                  //timer: 3000,
                                  //icon: "success"
                    });*/

            });
            // validation recharge portefeuille
            $('#paiement').click(function(e) {
                e.preventDefault(); // Empêche le formulaire de se soumettre normalement
                // vérifier si le mode de paiement et le montant à payer est disponible
                if ($("#modepaiement").val() === "" || $("#montant").val() === "") {
                    swal({
                        title: "Attention!!!",
                        text: "Merci de renseigner les champs obligatoires.",
                        buttons: true,
                        closeOnClickOutside: false,
                        timer: 3000,
                        icon: "error"
                    });
                    return;
                }
                // Récupérez les données du formulaire
                var formData = new FormData($('#form')[0]);
                $.ajax({
                    type: 'POST',
                    url: '{{ route('crediter-portefeuille') }}', // Remplacez par l'URL de votre route de traitement
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        swal({
                            title: "Veuillez patienter",
                            text: "Traitement des données en cours ...",
                            icon: "https://www.boasnotas.com/img/loading2.gif",
                            buttons: false,
                            closeOnClickOutside: false,
                            //timer: 3000,
                            //icon: "success"
                        });
                    },
                    success: function(response) {
                        swal.close();
                        $("#modepaiement").val("")
                        $("#montant").val("")
                        $("#preuve").val("")
                        $("#reference").val("")
                        $('#modalCrediter').modal('hide')
                        $("#update_portefeuille").text(formatNumber(response.montant_portefeuille) + " F CFA");
                        $("#montant_portefeuille").val(response.montant_portefeuille)
                        $("#solde").val(response.montant_portefeuille)
                        checkMontantRegle(response.montant_portefeuille)
                        if (response.kkiapay) {
                            //console.log(response)
                            var status_sandbox = "true";
                            var key = '{{ env('KKIAPAY_SANDBOX_PUBLIC_KEY') }}';
                            // afficher le formulaire de kkiapay pour le paiement
                            showKkiapay(response.montant_portefeuille, response.reference,response.nom_client, status_sandbox, key)

                        } else {
                            swal({
                                title: "Succès!!!",
                                text: "Opération effectuée avec succès.",
                                buttons: true,
                                closeOnClickOutside: false,
                                timer: 3000,
                                icon: "success"
                            });
                        }
                        // Le traitement a réussi, vous pouvez gérer la réponse ici
                        //console.log(response);
                        // Vous pouvez ajouter ici des actions en fonction de la réponse (par exemple, rediriger l'utilisateur)
                    },
                    error: function(xhr, status, error) {
                        swal.close();
                        // Le traitement a échoué, vous pouvez gérer l'erreur ici
                        console.error(xhr.responseText);
                    }
                });
            });

            function formatNumber(num) {
                return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.")
            }



        });
    </script>

    <!-- jquery -->
@endsection

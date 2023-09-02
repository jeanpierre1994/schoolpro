@extends('backend/include/layout')
<!-- title -->
@section('title')
    Choix Rubrique Paiement || {{ env('APP_NAME') }}
@endsection


@section('fil-arial')
    <div class="pagetitle">
        <h1>Choix Rubrique Paiement</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" style="text-decoration: none;">Accueil</a></li>
                <li class="breadcrumb-item active">Choix Rubrique Paiement </li>
            </ol>
        </nav>
    </div>
@endsection

@section('contenu')
    <section class="section">
        <div class="row"> 
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Liste des échéanciers</h5>
                        <!-- Bordered Table -->
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-bordered data-tables">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Dossier</th>
                                        <th scope="col">Famille Rubrique</th>
                                        <th scope="col">Rubrique</th>
                                        <th scope="col">Montant</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1; $net_a_payer = 0;
                                    @endphp
                                    @foreach ($echeanciers as $item)
                                    @php
                                        $net_a_payer = $net_a_payer + $item->montant_rubrique;
                                    @endphp
                                        <tr>
                                            <td class="text-center"><b>{{ $i++ }}</b></td>
                                            <td>{{ $item->dossier_id ? $item->getDossier->code : '' }}</td>
                                            <td>{{ $item->lignetarif_id ? $item->getLignetarif->rubrique->familleRubrique->libelle : '' }}
                                            </td>
                                            <td>{{ $item->lignetarif_id ? $item->getLignetarif->rubrique->libelle : '' }}
                                            </td>
                                            <td>{{ number_format($item->montant_rubrique, 0, ',', '.') }}</td>
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
                                                                            Voulez-vous vraiment retirer cet élément ?
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- Modal footer -->
                                                                <div class="modal-footer">

                                                                    <form
                                                                        action="{{ route('paiement.retirer-rubrique', $item->id) }}"
                                                                        method="post" enctype="multipart/form-data">
                                                                        @method('DELETE')
                                                                        @csrf
                                                                        <button type="submit"
                                                                            class="btn btn-danger btn-md" id=""
                                                                            value="">OUI
                                                                        </button>
                                                                        <button type="button"
                                                                            class="btn btn-md btn-secondary"
                                                                            data-bs-dismiss="modal">NON</button>
                                                                    </form>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End modal -->
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

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title" style="margin: 0px;">
                            <pre>Solde portefeuille : <span class="badge rounded-pill text-bg-primary"> <i class="fa fa-credit-card" aria-hidden="true"></i> {{ number_format($dossier->getPortefeuille->montant, 0, ',', '.') }} F CFA</span> </pre>
                            <pre>Apprenant : <b>{{ $dossier->getPersonne->nom }} {{ $dossier->getPersonne->prenoms }}</b> </pre>
                            <pre>Groupe péda.: <b>{{ $dossier->getGp->libelle_classe }} {{ $dossier->getGp->libelle_secondaire }}</b></pre>
                            <pre>Parent : {{ $dossier->parent_id ? $dossier->getParent->getParentInfo($dossier->parent_id)->nom.' '.$dossier->getParent->getParentInfo($dossier->parent_id)->prenoms : '' }} </pre>
                          
                            <hr>
                        </div>
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
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function() {

        });
    </script>

    <!-- jquery -->
@endsection

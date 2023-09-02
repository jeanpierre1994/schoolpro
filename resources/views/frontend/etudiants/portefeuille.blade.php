@extends('frontend.inc.user_layout')

@section('title')
    Portefeuille Etudiant || {{ env('APP_NAME') }}
@endsection

<style>
    label{ font-weight: bold;}
</style>
@section('contenu') 
<section style="background-color: #eee;">
    <div class="container py-1">
      <div class="row">
        <div class="col">
          <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-4">
            <ol class="breadcrumb mb-0">
              <li class="breadcrumb-item"><a href="{{route('dashboard_etudiant')}}">Accueil</a></li> 
              <li class="breadcrumb-item active" aria-current="page">Portefeuille</li>
            </ol>
          </nav>
        </div>
      </div>
  
      <div class="row">
        <div class="col-lg-4">
          <div class="card mb-4">
            <div class="card-body text-center">
              @if ($personne->photo)
              <img src="{{ asset('storage/photos/'.$personne->photo) }}" alt="avatar"
              class="rounded-circle img-fluid" style="width: 150px;">
              @else
              <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp" alt="avatar"
              class="rounded-circle img-fluid" style="width: 150px;">
              @endif
              
              <h5 class="my-3">{{auth()->user()->name}}</h5>
              <p class="text-muted mb-1">{{auth()->user()->getProfil->libelle}}</p>
              <!--<p class="text-muted mb-4">Bay Area, San Francisco, CA</p>-->
              <div class="d-flex justify-content-center mb-2">
                <!--<button type="button" class="btn btn-primary">Editer Profil</button>-->
                <a href="{{route('parent.edit_profil',$personne->id)}}" class="btn btn-outline-primary ms-1">Editer Profil</a>
              </div>
            </div>
          </div>
          <div class="card mb-4 mb-lg-0">
             
          </div>
        </div>
        <div class="col-lg-8">
          <div class="card mb-4">
            <div class="card-body">
              <div class="row">
                <div class="col-sm-3">
                  <p class="mb-0">Solde Portefeuille :</p>
                </div>
                <div class="col-sm-5">
                  <p class="text-muted mb-0"><b>{{ number_format($portefeuille->montant, 0, ',', '.') }} F CFA</b></p>
                </div>
                <div class="col-sm-4">
                  <a class="btn btn-primary show-modal" href="#" role="button"><i class="fa fa-credit-card" aria-hidden="true"></i> Crédité</a>
                </div>
              </div>   
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card mb-4 mb-md-0">
                <div class="card-body">
                  <p class="mb-4"><span class="text-primary font-italic me-1">Historique des transactions </span>
                  </p>
                    <div class="table-responsive">
                        <table class="table table-striped
                        table-hover	
                        table-borderless
                        table-primary
                        align-middle">
                        <thead class="table-light">
                          <caption>Historiques</caption>
                          <tr>
                              <th>N°</th>
                              <th>Montant</th>
                              <th>Type</th>
                              <th>Date opération</th>
                          </tr>
                          </thead>
                          <tbody class="table-group-divider">
                              @php
                                  $i=1;
                              @endphp
                              @foreach ($historiques as $data)
                              <tr class="table-primary">
                                  <td scope="row text-center">{{$i++}}</td>
                                  <td scope="row">{{ number_format($data->new_montant, 0, ',', '.') }} F CFA</td>
                                  <td>{{$data->type}}</td>
                                  <td>{{ $data->updated_at->format('d-m-Y à H:i:s') }}</td>
                              </tr>                                        
                              @endforeach
                          </tbody>
                                <tfoot>
                                    
                                </tfoot>
                        </table>
                    </div>
                     
                </div>
              </div>
            </div> 
          </div>
        </div>
      </div>
    </div> 
  </section>



    <!-- modal -->

    <div class="modal fade" id="modalCrediter" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="modale" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary w-100 text-center text-white">
                    <h5 class="modal-title text-white" id="modalDelete"><i class="fa fa-credit-card" aria-hidden="true"></i> Crédité portefeuille</h5>
                    <button type="button" class="btn-close hide-modal" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form" action="{{route('recharge.portefeuille-etudiant')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{ $portefeuille->id }}" name="portefeuille_id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="label">Solde actuel <i class="text-danger">*</i></label>
                                <input type="number" min="0" name="solde" id="solde"
                                class="form-control" value="{{$portefeuille->montant}}" readonly required>
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
                        <button type="button" class="btn btn-secondary hide-modal" data-dismiss="modal">Fermer</button>
                        <button type="submit" id="valider" class="btn btn-primary">Procéder au paiement</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end modal export -->

@endsection

@section('js-script')
    <script>
        $(document).ready(function() { 
             // remove menu active 
             $("div a").removeClass('active');
            // active menu   
            $("#parent-portefeuille").addClass('active'); 

            // show modal
            $(".show-modal").on("click", function() {
                $('#modalCrediter').modal('show')
            });
            $(".hide-modal").on("click", function() {
                $('#modalCrediter').modal('hide')
            });

        });

        // validate form
        // Example starter JavaScript for disabling form submissions if there are invalid fields
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
        })();
    </script>
@endsection

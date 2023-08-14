@extends('frontend.inc.user_layout')

@section('title')
    Dashboard Parent || {{ env('APP_NAME') }}
@endsection

@section('contenu') 
<section style="background-color: #eee;">
    <div class="container py-1">
      <div class="row">
        <div class="col">
          <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-4">
            <ol class="breadcrumb mb-0">
              <li class="breadcrumb-item"><a href="{{route('dashboard_parent')}}">Accueil</a></li> 
              <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
          </nav>
        </div>
      </div>
  
      <div class="row">
        <div class="col-lg-4">
          <div class="card mb-4">
            <div class="card-body text-center"> 
              @php
                  $personne = getPersonne(auth()->user()->id);
              @endphp
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
                <a href="{{route('parent.identite')}}"><button type="button" class="btn btn-primary">Identité</button></a> 
              </div>
            </div>
          </div> 
        </div>
        <div class="col-lg-8">
            <div class="row">

                <div class="col-xl-12 col-md-12 mb-4">
                    <div class="card">
                      <div class="card-body">
                        <div class="d-flex justify-content-between p-md-1">
                          <div class="d-flex flex-row">
                            <div class="align-self-center">
                              <i class="fas fa-folder-open text-warning fa-3x me-4"></i>
                            </div>
                            <div>
                              <h4>Total</h4>
                              <p class="mb-0">Dossier en attente</p>
                            </div>
                          </div>
                          <div class="align-self-center">
                            <h2 class="h1 mb-0">{{ $dossierEnAttente }}</h2>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-xl-12 col-md-12 mb-4">
                      <div class="card">
                        <div class="card-body">
                          <div class="d-flex justify-content-between p-md-1">
                            <div class="d-flex flex-row">
                              <div class="align-self-center">
                                <i class="fas fa-folder-plus text-success fa-3x me-4"></i>
                              </div>
                              <div>
                                <h4>Total</h4>
                                <p class="mb-0">Dossier validé</p>
                              </div>
                            </div>
                            <div class="align-self-center">
                              <h2 class="h1 mb-0">{{ $dossierValide }}</h2>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-xl-12 col-md-12 mb-4">
                        <div class="card">
                          <div class="card-body">
                            <div class="d-flex justify-content-between p-md-1">
                              <div class="d-flex flex-row">
                                <div class="align-self-center">
                                  <i class="fas fa-folder-minus text-danger fa-3x me-4"></i>
                                </div>
                                <div>
                                  <h4>Total</h4>
                                  <p class="mb-0">Dossier rejeté</p>
                                </div>
                              </div>
                              <div class="align-self-center">
                                <h2 class="h1 mb-0">{{ $dossierRejete }}</h2>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
            </div>  
        </div>
      </div>
    </div>
  </section>
@endsection

@section('js-script')
    <script>
        $(document).ready(function() {
            // remove menu active 
      $("div a").removeClass('active');
      // active menu   
      $("#dashboard").addClass('active'); 
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

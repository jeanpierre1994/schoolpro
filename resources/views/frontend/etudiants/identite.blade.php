@extends('frontend.inc.user_layout')

@section('title')
    Identité Etudiant || {{ env('APP_NAME') }}
@endsection

@section('contenu') 
<section style="background-color: #eee;">
    <div class="container py-1">
      <div class="row">
        <div class="col">
          <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-4">
            <ol class="breadcrumb mb-0">
              <li class="breadcrumb-item"><a href="{{route('dashboard_etudiant')}}">Accueil</a></li> 
              <li class="breadcrumb-item active" aria-current="page">Identité</li>
            </ol>
          </nav>
        </div>
      </div>
  
      <div class="row">
        <div class="col-lg-4">
          <div class="card mb-4">
            <div class="card-body text-center">
              @if ($etudiant->photo)
              <img src="{{ asset('storage/photos/'.$etudiant->photo) }}" alt="avatar"
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
                <a href="{{route('etudiant.edit_profil',$etudiant->id)}}" class="btn btn-outline-primary ms-1">Editer Profil</a>
              </div>
            </div>
          </div>
          <div class="card mb-4 mb-lg-0">
            <div class="card-body p-0">
              <ul class="list-group list-group-flush rounded-3">
                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                  <i class="fas fa-globe fa-lg text-warning"></i>
                  <p class="mb-0">{{$etudiant->site_web ? $etudiant->site_web : "Non renseigné"}}</p>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                  <i class="fab fa-github fa-lg" style="color: #333333;"></i>
                  <p class="mb-0">{{$etudiant->lien_github ? $etudiant->lien_github : "Non renseigné"}}</p>
                </li> 
                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                  <i class="fab fa-linkedin fa-lg" style="color: #ac2bac;"></i>
                  <p class="mb-0">{{$etudiant->lien_linkedin ? $etudiant->lien_linkedin : "Non renseigné"}}</p>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                  <i class="fab fa-facebook-f fa-lg" style="color: #3b5998;"></i>
                  <p class="mb-0">{{$etudiant->lien_facebook ? $etudiant->lien_facebook : "Non renseigné"}}</p>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-lg-8">
          <div class="card mb-4">
            <div class="card-body">
              <div class="row">
                <div class="col-sm-3">
                  <p class="mb-0">Nom complet</p>
                </div>
                <div class="col-sm-9">
                  <p class="text-muted mb-0">{{auth()->user()->name}}</p>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-3">
                  <p class="mb-0">Nom jeune fille</p>
                </div>
                <div class="col-sm-9">
                  <p class="text-muted mb-0">{{$etudiant->nomjeunefille ? $etudiant->nomjeunefille : "Non renseigné"}}</p>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-3">
                  <p class="mb-0">Date de naissance</p>
                </div>
                <div class="col-sm-9">
                  <p class="text-muted mb-0">{{$etudiant->ddn ? \Carbon\Carbon::parse($etudiant->ddn)->format('d-m-Y') : "Non renseigné"}}</p>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-3">
                  <p class="mb-0">Lieu de naissance</p>
                </div>
                <div class="col-sm-9">
                  <p class="text-muted mb-0">{{$etudiant->lieunais ? $etudiant->lieunais : "Non renseigné"}}</p>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-3">
                  <p class="mb-0">E-mail</p>
                </div>
                <div class="col-sm-9">
                  <p class="text-muted mb-0">{{auth()->user()->email}}</p>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-3">
                  <p class="mb-0">Téléphone</p>
                </div>
                <div class="col-sm-9">
                  <p class="text-muted mb-0">{{$etudiant->tel ? $etudiant->tel : "Non renseigné"}}</p>
                </div>
              </div> 
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card mb-4 mb-md-0">
                <div class="card-body">
                  <p class="mb-4"><span class="text-primary font-italic me-1">Autre informations</span>
                  </p>
                  <p class="mt-4 mb-1" style="font-size: .77rem;">Genre : <b>{{$etudiant->genre ? $etudiant->getGenre->libelle : "Non renseigné"}}</b></p>
                  <div class="progress rounded" style="height: 5px;">
                    <div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="72"
                      aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <p class="mt-4 mb-1" style="font-size: .77rem;">Adresse :  <b>{{$etudiant->adresse ? $etudiant->adresse : "Non renseigné"}}</b></p>
                  <div class="progress rounded" style="height: 5px;">
                    <div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="89"
                      aria-valuemin="0" aria-valuemax="100"></div>
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
            $("#identite").addClass('active'); 
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

@extends('frontend.inc.user_layout')

@section('title')
    Edition Profil Etudiant || {{ env('APP_NAME') }}
@endsection

@section('contenu') 
<section style="background-color: #eee;">
    <div class="container py-1">
      <div class="row">
        <div class="col">
          <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-4">
            <ol class="breadcrumb mb-0">
              <li class="breadcrumb-item"><a href="{{route('dashboard_etudiant')}}">Accueil</a></li> 
              <li class="breadcrumb-item"><a href="{{route('etudiant.identite')}}">Identité</a></li> 
              <li class="breadcrumb-item active" aria-current="page">Edition profil</li>
            </ol>
          </nav>
        </div>
      </div>
  
      <div class="row">
        <div class="col-lg-12">
          <div class="card mb-4">
            <h5 class="card-header">FORMULAIRE D'EDTION DE PROFIL</h5>
            <div class="card-body text-center">
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
      <form action="{{route('etudiant.edit_profil-store')}}" method="POST" class="row g-3 needs-validation" novalidate enctype="multipart/form-data"> 
        @csrf
        <input type="hidden" name="etudiant_id" id="etudiant_id" class="form-control" value="{{$etudiant->id}}">
         
        <div class="form-row">
              <div class="col-md-6 mb-2">
                  <div class="input-group form-outline">
                      <span class="input-group-text" id="inputGroupPrepend"><i class="fas fa-user-alt fa-fw me-3"></i></span>
                      <input type="text" class="form-control" id="nom" value="{{ $etudiant->nom }}" required aria-describedby="inputGroupPrepend"
                          required name="nom" minlength="2" maxlength="150"/>
                      <label for="nom" class="form-label">Nom <i class="text-danger">*</i></label>
                      <div class="invalid-feedback">Champ obligatoire.</div>
                      <div class="valid-feedback"></div>
                  </div>
              </div>
              <div class="col-md-6 mb-2">
                  <div class="input-group form-outline">
                      <span class="input-group-text" id="inputGroupPrepend"><i class="fas fa-user-alt fa-fw me-3"></i></span>
                      <input type="text" class="form-control" id="prenoms" required aria-describedby="inputGroupPrepend"
                          required name="prenoms" minlength="2" maxlength="150" value="{{ $etudiant->prenoms }}"/>
                      <label for="prenoms" class="form-label">Prénoms <i class="text-danger">*</i></label>
                      <div class="invalid-feedback">Champ obligatoire.</div>
                  </div>
              </div>
          </div>
          <div class="form-row">
              <div class="col-md-6 mb-2">
                  <div class="input-group form-outline">
                      <span class="input-group-text" id="inputGroupPrepend"><i class="fas fa-user-alt fa-fw me-3"></i></span>
                      <input type="text" class="form-control" id="nom_jeune_fille" value="{{ $etudiant->nomjeunefille }}" aria-describedby="inputGroupPrepend"
                           name="nom_jeune_fille" minlength="2" maxlength="150"/>
                      <label for="nom_jeune_fille" class="form-label">Nom jeune fille</label>
                      <div class="invalid-feedback"></div>
                      <div class="valid-feedback"></div>
                  </div>
              </div>
              <div class="col-md-6 mb-2">
                  <div class="input-group form-outline">
                      <span class="input-group-text" id="inputGroupPrepend"><i class="fas fa-calendar-alt fa-fw me-3"></i></span>
                      <input type="date" class="form-control" id="ddn" required aria-describedby="inputGroupPrepend"
                           name="ddn" max="{{date("Y-m-d")}}" value="{{ $etudiant->ddn }}" required/>
                      <label for="ddn" class="form-label">Date de naissance <i class="text-danger">*</i></label>
                      <div class="invalid-feedback"></div>
                  </div>
              </div>
          </div>
          <div class="form-row">
              <div class="col-md-6 mb-2">
                  <div class="input-group form-outline">
                      <span class="input-group-text" id="inputGroupPrepend"><i class="fas fa-map-marker-alt fa-fw me-3"></i></span>
                      <input type="text" class="form-control" id="lieu_naissance" value="{{ $etudiant->lieunais }}" required aria-describedby="inputGroupPrepend"
                           name="lieu_naissance" minlength="2" maxlength="150" required/>
                      <label for="lieu_naissance" class="form-label">Lieu naissance <i class="text-danger">*</i></label>
                      <div class="invalid-feedback"></div>
                      <div class="valid-feedback"></div>
                  </div>
              </div>
              <div class="col-md-6 mb-2">
                  <div class="input-group form-outline">
                      <span class="input-group-text" id="inputGroupPrepend"><i class="fas fa-house-damage fa-fw me-3"></i></span>
                      <input type="text" class="form-control" id="adresse" required aria-describedby="inputGroupPrepend"
                           name="adresse" minlength="2" maxlength="150" value="{{ $etudiant->adresse }}"/>
                      <label for="adresse" class="form-label">Adresse <i class="text-danger">*</i></label>
                      <div class="invalid-feedback"></div>
                  </div>
              </div>
          </div>
          <div class="form-row">
              <div class="col-md-6 mb-2">
                  <div class="input-group form-outline">
                      <span class="input-group-text" id="inputGroupPrepend"><i class="fas fa-mobile-alt fa-fw me-3"></i></span>
                      <input type="text" class="form-control" id="telephone" required aria-describedby="inputGroupPrepend"
                          required name="telephone" maxlength="20" value="{{ $etudiant->tel }}"/>
                      <label for="telephone" class="form-label">Téléphone <i class="text-danger">*</i></label>
                      <div class="invalid-feedback">Champ obligatoire.</div>
                  </div>
              </div>
              <div class="col-md-6 mb-2">
                  <div class="input-group form-outline">
                      <span class="input-group-text" id="inputGroupPrepend"><i class="fas fa-envelope fa-fw me-3"></i></span>
                      <input type="text" class="form-control" id="email" value="{{ $etudiant->email }}" required aria-describedby="inputGroupPrepend"
                          required name="email" minlength="2" maxlength="150"/>
                      <label for="email" class="form-label">E-mail <i class="text-danger">*</i></label>
                      <div class="invalid-feedback">Champ obligatoire.</div>
                  </div>
              </div>
          </div>
          <div class="form-row"> 
              <div class="col-md-6 mb-2">
                  <select class="browser-default custom-select" name="genre_id" id="genre_id" required>
                    <option value="" selected>Choisissez votre genre</option>
                    <optgroup label="Valeur par défaut">
                        <option selected value="{{$etudiant->genre ? $etudiant->getGenre->id : ''}}">{{$etudiant->genre ? $etudiant->getGenre->libelle : ''}}</option>
                    </optgroup>
                    <optgroup label="Liste disponible">
                        @foreach ($genres as $item)
                          <option value="{{$item->id}}">{{$item->libelle}}</option>
                        @endforeach
                    </optgroup>
                  </select>                         
              </div>
              <div class="col-md-6 mb-2">
                  <div class="input-group form-outline">
                      <span class="input-group-text" id="inputGroupPrepend"><i class="fas fa-images fa-fw me-3"></i></span>
                      <input type="file" class="form-control" id="photo" aria-describedby="inputGroupPrepend"
                           name="photo"/>
                      <label for="photo" class="form-label"></label>
                      <!--<div class="invalid-feedback">Champ obligatoire.</div>-->
                  </div>
              </div>
          </div> 
          <div class="form-row"> 
              <div class="col-md-6 mb-2">
                  <div class="input-group form-outline">
                      <span class="input-group-text" id="inputGroupPrepend"><i class="fab fa-internet-explorer fa-fw me-3"></i></span>
                      <input type="text" class="form-control" id="site_web" aria-describedby="inputGroupPrepend"
                           name="site_web" maxlength="150" value="{{ $etudiant->site_web }}"/>
                      <label for="site_web" class="form-label">Site web</label>
                      <div class="invalid-feedback"></div>
                  </div>
              </div>
              <div class="col-md-6 mb-2">
                  <div class="input-group form-outline">
                      <span class="input-group-text" id="inputGroupPrepend"><i class="fab fa-linkedin fa-fw me-3"></i></span>
                      <input type="text" class="form-control" id="lien_linkedin" value="{{ $etudiant->lien_linkedin }}" aria-describedby="inputGroupPrepend"
                           name="lien_linkedin" minlength="2" maxlength="150"/>
                      <label for="lien_linkedin" class="form-label">Profil LinkedIn</label>
                      <div class="invalid-feedback"></div>
                  </div>
              </div>
          </div>
          <div class="form-row"> 
              <div class="col-md-6 mb-2">
                  <div class="input-group form-outline">
                      <span class="input-group-text" id="inputGroupPrepend"><i class="fab fa-facebook fa-fw me-3"></i></span>
                      <input type="text" class="form-control" id="lien_facebook" aria-describedby="inputGroupPrepend"
                           name="lien_facebook" maxlength="150" value="{{ $etudiant->lien_facebook }}"/>
                      <label for="lien_facebook" class="form-label">Profil Facebook</label>
                      <div class="invalid-feedback"></div>
                  </div>
              </div>
              <div class="col-md-6 mb-2">
                  <div class="input-group form-outline">
                      <span class="input-group-text" id="inputGroupPrepend"><i class="fab fa-github fa-fw me-3"></i></span>
                      <input type="text" class="form-control" id="lien_github" value="{{ $etudiant->lien_github }}" aria-describedby="inputGroupPrepend"
                           name="lien_github" minlength="2" maxlength="150"/>
                      <label for="lien_github" class="form-label">Profil Github</label>
                      <div class="invalid-feedback"></div>
                  </div>
              </div>
          </div>
          <div class="col-12">
              <button class="btn btn-primary" type="submit">Valider</button>
          </div>
      </form> 
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

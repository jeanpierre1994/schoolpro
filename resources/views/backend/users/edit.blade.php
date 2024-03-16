
@extends('backend/include/layout')
<!-- title -->
@section('title') Modification Utilisateur || {{env("APP_NAME")}} @endsection

@section('fil-arial')
<div class="pagetitle">
    <h1>Utilisateur</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#" style="text-decoration: none;">Home</a></li>
        <li class="breadcrumb-item"><a href="{{route('admin.parametres')}}" style="text-decoration: none;">Paramètres</a></li>
        <li class="breadcrumb-item"><a href="{{route('users.index')}}" style="text-decoration: none;">Utilisateurs</a> </li>
        <li class="breadcrumb-item active">Enregistrement </li>
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
        <h5 class="card-title">Modification</h5>
          <!-- General Form Elements -->
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
          <form action="{{ route('users.update',$user->id) }}" method="post">
            @csrf
            @method("put")

            <div class="row mb-3">
              <div class="col-md-6">
                <label for="inputText" class=" col-form-label">Nom <i class="text-danger">*</i></label>
                <div>
                  <input type="text" class="form-control" value="{{$user->nom}}" required name="nom" id="nom" minlength="3" maxlength="100">
                </div>
              </div>
              <div class="col-md-6">
                <label for="inputText" class=" col-form-label">Prénoms <i class="text-danger">*</i></label>
                <div>
                  <input type="text" value="{{$user->prenoms}}" class="form-control" required name="prenoms" id="prenoms" minlength="3" maxlength="100">
                </div>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <label for="inputText" class=" col-form-label">Téléphone <i class="text-danger">*</i></label>
                <div>
                  <input type="number" value="{{$user->tel}}" class="form-control" required name="telephone" id="telephone" maxlength="20" >
                </div>
              </div>
              <div class="col-md-6">
                <label for="inputText" class=" col-form-label">E-mail <i class="text-danger">*</i></label>
                <div>
                  <input type="text" value="{{$user->email}}" class="form-control" required name="email" id="email" minlength="1" maxlength="100" >
                </div>
              </div>
              <div class="col-md-6">
                <label for="inputText" class=" col-form-label">Profil <i class="text-danger">*</i></label>
                <div>
                    <select class="form-select" name="profil_id" id="profil_id" required>
                      <optgroup label="Valeur par défaut">
                        <option value="{{ $user->getCompte->getProfil->id ? $user->getCompte->getProfil->id : ''}}">{{ $user->getCompte->getProfil->libelle ? $user->getCompte->getProfil->libelle : ''}}</option>
                      </optgroup>
                      <optgroup label="Liste disponible">
                        @foreach ($profils as $item)
                        <option value="{{$item->id}}">{{$item->libelle}}</option>
                        @endforeach
                      </optgroup>
                    </select>
                </div>
              </div>
              <div class="col-md-6">
                <label for="inputText" class=" col-form-label">Genre<i class="text-danger">*</i></label>
                <div>
                    <select class="form-select" name="genre_id" id="genre_id" required>
                      <optgroup label="Valeur par défaut">
                        <option value="{{ $user->genre ? $user->genre : ''}}">{{ $user->genre ? $user->getGenre->libelle : ''}}</option>
                      </optgroup>
                      <optgroup label="Liste disponible">
                        @foreach ($genres as $item)
                        <option value="{{$item->id}}">{{$item->libelle}}</option>
                        @endforeach
                      </optgroup>
                    </select>
                </div>
              </div>
{{--              <div class="col-md-6">--}}
{{--                <label for="inputText" class=" col-form-label">Actuel Mot de passe <i class="text-danger"></i></label>--}}
{{--                <div>--}}
{{--                  <input type="password" maxlength="100"  minlength="8" name="current_password" class="form-control" id="password" pattern="^(?=.{8,32}$)(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).*">--}}
{{--                </div>--}}
{{--              </div>--}}

              <div class="col-md-6">
                <label for="inputText" class=" col-form-label">Nouveau Mot de passe <i class="text-danger"></i></label>
                <div>
                  <input type="password" maxlength="100"  minlength="8" name="new_password" class="form-control" id="password" pattern="^(?=.{8,32}$)(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).*">
                </div>
                <div class="invalid-feedbackx">
                  Le mot de passe doit contenir :
                   <li>au moins 1 lettre majuscule</li>
                   <li>au moins 1 lettre miniscule</li>
                   <li>au moins 1 numéro</li>
                   <li>Minimum 8 caractères</li>
               </div>
              </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                  <button type="submit" class="btn btn-primary">Modifier</button>
                </div>
            </div>
          </form><!-- End General Form Elements -->
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
    } );
</script>
@endsection

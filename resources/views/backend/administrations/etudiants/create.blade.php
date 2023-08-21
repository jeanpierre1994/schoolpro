@extends('backend/include/layout')
<!-- title -->
@section('title')
    Enregistrement Etudiant|| {{ env('APP_NAME') }}
@endsection
<style>
    .cacher {
        display: none;
    }
</style>
@section('fil-arial')
    <div class="pagetitle">
        <h1>Paramètres</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" style="text-decoration: none;">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.parametres') }}"
                        style="text-decoration: none;">Paramètres</a></li>
                <li class="breadcrumb-item"><a href="#" style="text-decoration: none;">Etudiants</a> </li>
                <li class="breadcrumb-item active">Enregistrement </li>
            </ol>
        </nav>
    </div>
@endsection

<style>
    .wrong .fa-check {
        display: none;
    }

    .good .fa-times {
        display: none;
    }

    .valid-feedback,
    .invalid-feedback {
        margin-left: calc(2em + 0.25rem + 1.5rem);
    }
</style>

@section('contenu')
    <section class="section">
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                        aria-expanded="true" aria-controls="collapseOne">
                        Création dossier étudiant avec inscription
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">

                        <!-- onglet one -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Enregistrement étudiant</h5>
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
                                        <form action="{{ route('etudiant.dossierExpress-store') }}" method="post"  enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-row">
                                                <div class="col-md-4 mb-2">
                                                    <label for="form-label">Nom <i class="text-danger">*</i></label>
                                                    <input type="text" class="form-control" id="nom"
                                                        value="{{ old('nom') }}" required
                                                        aria-describedby="inputGroupPrepend" required name="nom"
                                                        minlength="2" maxlength="150" />
                                                    <div class="invalid-feedback">Champ obligatoire.</div>
                                                    <div class="valid-feedback"></div>
                                                </div>
                                                <div class="col-md-4 mb-2">
                                                    <label for="form-label">Prénoms <i class="text-danger">*</i></label>
                                                    <input type="text" class="form-control" id="prenoms" required
                                                        aria-describedby="inputGroupPrepend" required name="prenoms"
                                                        minlength="2" maxlength="150" value="{{ old('prenoms') }}" />
                                                    <div class="invalid-feedback">Champ obligatoire.</div>
                                                </div>
                                                <div class="col-md-4 mb-2">
                                                    <label for="form-label">Téléphone <i class="text-danger">*</i></label>
                                                    <input type="text" class="form-control" id="telephone" required
                                                        aria-describedby="inputGroupPrepend" required name="telephone"
                                                        maxlength="20" value="{{ old('telephone') }}" />
                                                </div>
                                                <div class="col-md-4 mb-2">
                                                    <label for="form-label">E-mail <i class="text-danger">*</i></label>
                                                    <input type="text" class="form-control" id="email"
                                                        value="{{ old('email') }}" required
                                                        aria-describedby="inputGroupPrepend" required name="email"
                                                        minlength="2" maxlength="150" />
                                                </div>

                                                <div class="col-md-4 mb-2">
                                                    <label for="form-label">Profil <i class="text-danger">*</i></label>
                                                    <select class="browser-default custom-select" name="profil_id"
                                                        id="profil_id" required>
                                                        <option value="" selected>Choisissez votre type</option>
                                                        @foreach ($profils as $item)
                                                            <option value="{{ $item->id }}">{{ $item->libelle }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4 mb-2">
                                                    <label for="form-label">Genre <i class="text-danger">*</i></label>
                                                    <select class="browser-default custom-select" name="genre_id"
                                                        id="genre_id" required>
                                                        <option value="" selected>Choisissez votre genre</option>
                                                        @foreach ($genres as $item)
                                                            <option value="{{ $item->id }}">{{ $item->libelle }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4 mb-2">
                                                    <label for="form-label">Groupe péda. <i
                                                            class="text-danger">*</i></label>
                                                    <select class="form-select custom-select" name="gp_id"
                                                        id="gp_id" required>
                                                        <option value="" selected>Choisissez une option</option>
                                                        @foreach ($gp as $item)
                                                            <option value="{{ $item->id }}">
                                                                {{ $item->getPole->libelle }}
                                                                {{ $item->getFiliere->libelle }}
                                                                {{ $item->libelle_classe }}
                                                                {{ $item->libelle_secondaire }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-md-4 mb-2">
                                                    <label for="form-label">Année académique<i
                                                            class="text-danger">*</i></label>
                                                    <select class="form-select custom-select" name="annee"
                                                        id="annee" required>
                                                        <optgroup label="Valeur par défaut">
                                                            <option selected value="{{ date('Y') }}">
                                                                {{ date('Y') }}</option>
                                                        </optgroup>
                                                        <optgroup label="Liste disponible">
                                                            <option value="2023">2023</option>
                                                            <option value="2024">2024</option>
                                                            <option value="2025">2025</option>
                                                            <option value="2026">2026</option>
                                                            <option value="2027">2027</option>
                                                            <option value="2028">2028</option>
                                                        </optgroup>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 mb-2">
                                                    <label for="form-label">Date Nais. <i
                                                            class="text-danger">*</i></label>
                                                    <input type="date" class="form-control" id="ddn"
                                                        value="" required required
                                                        aria-describedby="inputGroupPrepend" required name="ddn" />
                                                </div>

                                            </div>

                                            <div class="form-row">
                                                <div class="col-md-4 mb-2">
                                                    <label for="form-label">Nationalité <i
                                                            class="text-danger">*</i></label>
                                                            <select name="nationalite" id="nationalite" class="form-control" required>
                                                                <option value=""></option>
                                                                @foreach ($pays as $item)
                                                                    <option value="{{$item->nationalite}}">{{$item->nationalite}}</option>
                                                                @endforeach
                                                            </select>
                                                </div>
                                                <div class="col-md-4 mb-2">
                                                    <label for="form-label">Type sponsor <i
                                                            class="text-danger">*</i></label>
                                                    <select class="browser-default custom-select" name="sponsor_id"
                                                        id="sponsor_id" required>
                                                        <option value="" selected></option>
                                                        @foreach ($typesponsors as $item)
                                                            <option value="{{ $item->id }}">{{ $item->libelle }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4 mb-2">
                                                    <label for="form-label">Mot de passe <i
                                                            class="text-danger">*</i></label>
                                                    <input type="password" class="form-control" 
                                                        id="password-input" required aria-describedby="inputGroupPrepend"
                                                        required name="password" minlength="2" maxlength="150" />
                                                </div>

                                                <div class="col-md-6 mb-2">
                                                    <div class="d-none" id="show_sponsor">
                                                        <label for="form-label">Sponsor <i
                                                                class="text-danger">*</i></label>
                                                        <input type="text" class="form-control" id="sponsor"
                                                            value="{{ old('sponsor') }}"
                                                            aria-describedby="inputGroupPrepend" name="sponsor"
                                                            minlength="2" maxlength="150" />
                                                        <div class="invalid-feedback"></div>
                                                        <div class="valid-feedback"></div>
                                                    </div>
                                                </div>

                                                <div class="col-12 mt-4 mt-xxl-0 w-auto h-auto">

                                                    <div class="alert px-4 py-3 mb-0 d-none" role="alert"
                                                        data-mdb-color="warning" id="password-alert">
                                                        <ul class="list-unstyled mb-0">
                                                            <li class="requirements leng">
                                                                <i class="fas fa-check text-success me-2"></i>
                                                                <i class="fas fa-times text-danger me-3"></i>
                                                                Votre mot de passe doit contenir au moins 8 caractères
                                                            </li>
                                                            <li class="requirements big-letter">
                                                                <i class="fas fa-check text-success me-2"></i>
                                                                <i class="fas fa-times text-danger me-3"></i>
                                                                Votre mot de passe doit comporter au moins un caractère
                                                                majuscule.
                                                            </li>
                                                            <li class="requirements num">
                                                                <i class="fas fa-check text-success me-2"></i>
                                                                <i class="fas fa-times text-danger me-3"></i>
                                                                Votre mot de passe doit contenir au moins 1 chiffre.
                                                            </li>
                                                            <li class="requirements special-char">
                                                                <i class="fas fa-check text-success me-2"></i>
                                                                <i class="fas fa-times text-danger me-3"></i>
                                                                Votre mot de passe doit contenir au moins un caractère
                                                                spécial &_@}-!%£
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                                <div class="form-row">
                                                    <hr>
                                                    Voulez-vous ajouter un parent ?
                                                    <hr class="mt-2">
                                                    <div class="col-md-12">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check_parent" type="radio"
                                                                name="ajout_parent" id="choix_one" value="1">
                                                            <label class="form-check-label" for="">Non</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check_parent" type="radio"
                                                                name="ajout_parent" id="choix_two" value="2">
                                                            <label class="form-check-label" for="">Non le parent
                                                                existe déjà</label>
                                                        </div>
                                                        {{--<div class="form-check form-check-inline">
                                                            <input class="form-check-input check_parent" type="radio"
                                                                name="ajout_parent" id="choix_tree" value="3">
                                                            <label class="form-check-label" for="">Oui je veux
                                                                ajouter</label>
                                                        </div>--}}
                                                    </div>
                                                </div>


                                                <div class="form-row mt-2  d-none" id="step_one_add_parent">
                                                   <div class="bg-light" >
                                                    <div class="col-md-12 text-primary p-3">Ajouter un parent</div>
                                                    <div class="row">
                                                        <div class="col-md-4 mb-2">
                                                            <label for="form-label">Nom <i class="text-danger">*</i></label>
                                                            <input type="text" class="form-control" id="nom_parent"
                                                                value="{{ old('nom_parent') }}" 
                                                                aria-describedby="inputGroupPrepend" 
                                                                name="nom_parent" minlength="2" maxlength="150" />
                                                            <div class="invalid-feedback">Champ obligatoire.</div>
                                                            <div class="valid-feedback"></div>
                                                        </div>
                                                        <div class="col-md-4 mb-2">
                                                            <label for="form-label">Prénoms <i
                                                                    class="text-danger">*</i></label>
                                                            <input type="text" class="form-control" id="prenoms_parent"
                                                                 aria-describedby="inputGroupPrepend" 
                                                                name="prenoms_parent" minlength="2" maxlength="150"
                                                                value="{{ old('prenoms_parent') }}" />
                                                            <div class="invalid-feedback">Champ obligatoire.</div>
                                                        </div>
                                                        <div class="col-md-4 mb-2">
                                                            <label for="form-label">Téléphone <i
                                                                    class="text-danger">*</i></label>
                                                            <input type="number" class="form-control" id="telephone_parent"
                                                                 aria-describedby="inputGroupPrepend" 
                                                                name="telephone_parent" min="0"
                                                                value="{{ old('telephone_parent') }}" />
                                                            <div class="invalid-feedback">Champ obligatoire.</div>
                                                        </div>
                                                        <div class="col-md-6 mb-2">
                                                            <label for="form-label">Email <i class="text-danger">*</i></label>
                                                            <input type="email" class="form-control" id="email_parent"
                                                                 aria-describedby="inputGroupPrepend" 
                                                                name="email_parent" minlength="2" maxlength="150"
                                                                value="{{ old('email_parent') }}" />
                                                            <div class="invalid-feedback">Champ obligatoire.</div>
                                                        </div>
    
                                                        <div class="col-md-6 mb-2">
                                                            <label for="form-label">Genre <i class="text-danger">*</i></label>
                                                            <select class="browser-default custom-select"
                                                                name="genre_parent_id" id="genre_parent_id">
                                                                <option value="" selected>Choisissez votre genre</option>
                                                                @foreach ($genres as $item)
                                                                    <option value="{{ $item->id }}">{{ $item->libelle }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
    
                                                    </div>
                                                   </div>
                                                </div>

                                                <div class="form-row mt-2 d-none" id="setp_one_choix_parent">
                                                    <div class="bg-light">
                                                        <div class="row">
                                                            <div class="col-md-12 text-primary p-3">Choisissez un parent</div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="col-md-12 mb-2">
                                                                <label for="form-label">Choix parent <i class="text-danger">*</i></label>
                                                                <select class="browser-default custom-select"
                                                                    name="choix_parent_id" id="choix_parent_id">
                                                                    <option value="" selected>Choisissez un parent
                                                                    </option>
                                                                    @foreach ($parents as $data)
                                                                        <option value="{{ $data->id }}">
                                                                            {{ $data->nom }} {{ $data->prenoms }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="valid-feedback"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="form-group col-md-6 mb-3">
                                                    <label for="inputText" class="col-form-label">montant à payer<i class="text-danger"></i></label> 
                                                      <input type="text" class="form-control" value="98000" name="montant_a_payer" id="montant_a_payer" >
                                                 </div>
                                                 <div class="form-group col-md-6 mb-3">
                                                     <label for="inputText" class="col-form-label">montant payé<i class="text-danger">*</i></label> 
                                                       <input type="number" class="form-control" value="0" name="montant_payer" id="montant_payer" required>
                                                  </div>
                                            </div>


                            <div class="row"> 
                                <div class="form-group col-md-6 mb-3">
                                    <label for="inputText" class="col-form-label">Mode de paiement <i
                                            class="text-danger"></i></label>
                                    <select class="form-select" name="mode_paiement" id="mode_paiement" required>
                                        <option value="" selected>Choisissez une option</option>
                                        <option value="Manuel">Manuel</option>
                                        <option value="Virement">Virement</option>
                                        <option value="MoMo">MoMo</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-4 mb-3">
                                    <label for="inputText" class="col-form-label">Preuve (image)<i
                                            class="text-danger"></i></label>
                                    <input type="file" class="form-control" name="preuve" id="preuve">
                                </div>
                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-6"> 
                                                  <label class="col-form-label"></label>
                                                  <div class=""> 
                                                    <input type="submit" value="Procéder au paiement" id="paiement" class="btn btn-primary" name="paiement">
                                                  </div> 
                                                </div>
                                                <div class="col-md-6"> 
                                                  <label class="col-form-label"></label>
                                                  <div class=""> 
                                                    <input type="submit" class="btn btn-warning" value="Valider sans payer" id="no_paiement" name="no_paiement"/>
                                                  </div>
                                                </div>
                                              </div>
                                        </form><!-- End General Form Elements -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end onglet one -->
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Création dossier étudiant sans inscription
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">

                        <!-- ************** onglet two ************** -->
 
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Enregistrement étudiant</h5>
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
                                        <form action="{{ route('etudiant.dossierExpress-sansInscription') }}" method="post"  enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-row">    
                                                <div class="col-md-4 mb-2">
                                                    <label for="form-label">Etudiant <i class="text-danger">*</i></label>
                                                    <select class="browser-default custom-select" name="etudiant_id"
                                                        id="etudiant_id" required>
                                                        <option value="" selected>Choisissez un étudiant</option>
                                                        @foreach ($etudiants as $etudiant)
                                                            <option value="{{ $etudiant->id }}">{{ $etudiant->nom }} {{ $etudiant->prenoms }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div> 
                                                <div class="col-md-4 mb-2">
                                                    <label for="form-label">Groupe péda. <i
                                                            class="text-danger">*</i></label>
                                                    <select class="form-select custom-select" name="gp_id"
                                                        id="gp_id_two" required>
                                                        <option value="" selected>Choisissez une option</option>
                                                        @foreach ($gp as $item)
                                                            <option value="{{ $item->id }}">
                                                                {{ $item->getPole->libelle }}
                                                                {{ $item->getFiliere->libelle }}
                                                                {{ $item->libelle_classe }}
                                                                {{ $item->libelle_secondaire }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-md-4 mb-2">
                                                    <label for="form-label">Année académique<i
                                                            class="text-danger">*</i></label>
                                                    <select class="form-select custom-select" name="annee"
                                                        id="annee_two" required>
                                                        <optgroup label="Valeur par défaut">
                                                            <option selected value="{{ date('Y') }}">
                                                                {{ date('Y') }}</option>
                                                        </optgroup>
                                                        <optgroup label="Liste disponible">
                                                            <option value="2023">2023</option>
                                                            <option value="2024">2024</option>
                                                            <option value="2025">2025</option>
                                                            <option value="2026">2026</option>
                                                            <option value="2027">2027</option>
                                                            <option value="2028">2028</option>
                                                        </optgroup>
                                                    </select>
                                                </div> 

                                            </div> 
                                                <div class="form-row">
                                                    <hr>
                                                    Voulez-vous ajouter un parent ?
                                                    <hr class="mt-2">
                                                    <div class="col-md-12">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check_parent_two" type="radio"
                                                                name="ajout_parent" id="choix_one_two" value="1">
                                                            <label class="form-check-label" for="">Non</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check_parent_two" type="radio"
                                                                name="ajout_parent" id="choix_two_two" value="2">
                                                            <label class="form-check-label" for="">Non le parent
                                                                existe déjà</label>
                                                        </div>
                                                        {{--<div class="form-check form-check-inline">
                                                            <input class="form-check-input check_parent_two" type="radio"
                                                                name="ajout_parent" id="choix_tree_two" value="3">
                                                            <label class="form-check-label" for="">Oui je veux
                                                                ajouter</label>
                                                        </div>--}}
                                                    </div>
                                                </div>


                                                <div class="form-row mt-2  d-none" id="step_two_add_parent">
                                                   <div class="bg-light" >
                                                    <div class="col-md-12 text-primary p-3">Ajouter un parent</div>
                                                    <div class="row">
                                                        <div class="col-md-4 mb-2">
                                                            <label for="form-label">Nom <i class="text-danger">*</i></label>
                                                            <input type="text" class="form-control" id="nom_parent_two"
                                                                value="{{ old('nom_parent') }}" 
                                                                aria-describedby="inputGroupPrepend" 
                                                                name="nom_parent" minlength="2" maxlength="150" />
                                                            <div class="invalid-feedback">Champ obligatoire.</div>
                                                            <div class="valid-feedback"></div>
                                                        </div>
                                                        <div class="col-md-4 mb-2">
                                                            <label for="form-label">Prénoms <i
                                                                    class="text-danger">*</i></label>
                                                            <input type="text" class="form-control" id="prenoms_parent_two"
                                                                 aria-describedby="inputGroupPrepend" 
                                                                name="prenoms_parent" minlength="2" maxlength="150"
                                                                value="{{ old('prenoms_parent') }}" />
                                                            <div class="invalid-feedback">Champ obligatoire.</div>
                                                        </div>
                                                        <div class="col-md-4 mb-2">
                                                            <label for="form-label">Téléphone <i
                                                                    class="text-danger">*</i></label>
                                                            <input type="number" class="form-control" id="telephone_parent_two"
                                                                 aria-describedby="inputGroupPrepend" 
                                                                name="telephone_parent" min="0"
                                                                value="{{ old('telephone_parent') }}" />
                                                            <div class="invalid-feedback">Champ obligatoire.</div>
                                                        </div>
                                                        <div class="col-md-6 mb-2">
                                                            <label for="form-label">Email <i class="text-danger">*</i></label>
                                                            <input type="email" class="form-control" id="email_parent_two"
                                                                 aria-describedby="inputGroupPrepend" 
                                                                name="email_parent" minlength="2" maxlength="150"
                                                                value="{{ old('email_parent') }}" />
                                                            <div class="invalid-feedback">Champ obligatoire.</div>
                                                        </div>
    
                                                        <div class="col-md-6 mb-2">
                                                            <label for="form-label">Genre <i class="text-danger">*</i></label>
                                                            <select class="browser-default custom-select"
                                                                name="genre_parent_id" id="genre_parent_id_two">
                                                                <option value="" selected>Choisissez votre genre</option>
                                                                @foreach ($genres as $item)
                                                                    <option value="{{ $item->id }}">{{ $item->libelle }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
    
                                                    </div>
                                                   </div>
                                                </div>

                                                <div class="form-row mt-2 d-none" id="setp_two_choix_parent">
                                                    <div class="bg-light">
                                                        <div class="row">
                                                            <div class="col-md-12 text-primary p-3">Choisissez un parent</div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="col-md-12 mb-2">
                                                                <label for="form-label">Choix parent <i class="text-danger">*</i></label>
                                                                <select class="browser-default custom-select"
                                                                    name="choix_parent_id" id="choix_parent_id_two">
                                                                    <option value="" selected>Choisissez un parent
                                                                    </option>
                                                                    @foreach ($parents as $data)
                                                                        <option value="{{ $data->id }}">
                                                                            {{ $data->nom }} {{ $data->prenoms }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="valid-feedback"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="form-group col-md-6 mb-3">
                                                    <label for="inputText" class="col-form-label">montant à payer<i class="text-danger"></i></label> 
                                                      <input type="text" class="form-control" value="98000" name="montant_a_payer" id="montant_a_payer_two" >
                                                 </div>
                                                 <div class="form-group col-md-6 mb-3">
                                                     <label for="inputText" class="col-form-label">montant payé<i class="text-danger">*</i></label> 
                                                       <input type="number" class="form-control" value="0" name="montant_payer" id="montant_payer_two" required>
                                                  </div>
                                            </div>


                            <div class="row"> 
                                <div class="form-group col-md-6 mb-3">
                                    <label for="inputText" class="col-form-label">Mode de paiement <i
                                            class="text-danger"></i></label>
                                    <select class="form-select" name="mode_paiement" id="mode_paiement" required>
                                        <option value="" selected>Choisissez une option</option>
                                        <option value="Manuel">Manuel</option>
                                        <option value="Virement">Virement</option>
                                        <option value="MoMo">MoMo</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-4 mb-3">
                                    <label for="inputText" class="col-form-label">Preuve (image)<i
                                            class="text-danger"></i></label>
                                    <input type="file" class="form-control" name="preuve" id="preuve">
                                </div>
                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-6"> 
                                                  <label class="col-form-label"></label>
                                                  <div class=""> 
                                                    <input type="submit" value="Procéder au paiement" id="paiement_two" class="btn btn-primary" name="paiement">
                                                  </div> 
                                                </div>
                                                <div class="col-md-6"> 
                                                  <label class="col-form-label"></label>
                                                  <div class=""> 
                                                    <input type="submit" class="btn btn-warning" value="Valider sans payer" id="no_paiement_two" name="no_paiement"/>
                                                  </div>
                                                </div>
                                              </div>

 
                                        </form><!-- End General Form Elements -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--************ end onglet two *******************-->
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

            
$('#paiement').attr("disabled", true);

$('#montant_payer').change(function () {
var montant = parseInt($(this).val());
var montant_a_payer = parseInt($("#montant_a_payer").val());

if (montant > 0 && montant_a_payer > 0) {
  $('#paiement').attr("disabled", false);
  // vérifier si le montant à payer est supérieur au montant à payer
  if (montant > montant_a_payer) {
    alert("Le montant payé ne peut pas être supérieur au montant à payer");
    $('#paiement').attr("disabled", true);
  }

} else {
  $('#paiement').attr("disabled", true);
}
});

// step two


$('#paiement_two').attr("disabled", true);

$('#montant_payer_two').change(function () {
var montant = parseInt($(this).val());
var montant_a_payer = parseInt($("#montant_a_payer_two").val());

if (montant > 0 && montant_a_payer > 0) {
  $('#paiement_two').attr("disabled", false);
  // vérifier si le montant à payer est supérieur au montant à payer
  if (montant > montant_a_payer) {
    alert("Le montant payé ne peut pas être supérieur au montant à payer");
    $('#paiement_two').attr("disabled", true);
  }

} else {
  $('#paiement_two').attr("disabled", true);
}
});


            // update choix parent step one
            $('.check_parent').on('change', function() {
                //alert($(this).val());
                choix = parseInt($(this).val());
                if (choix == 1) { // none
                    if ($('#setp_one_choix_parent').hasClass("d-none")) {

                        // $('#setp_one_choix_parent').removeClass("d-none");
                    } else {
                        $('#setp_one_choix_parent').addClass("d-none");
                    }

                    if ($('#step_one_add_parent').hasClass("d-none")) {
                        //$('#step_one_add_parent').removeClass("d-none");
                    } else {
                        $('#step_one_add_parent').addClass("d-none");
                    }

                    // reset form add parent
                    $('#nom_parent').val("");
                    $('#prenoms_parent').val("");
                    $('#telephone_parent').val("");
                    $('#email_parent').val("");
                }
                if (choix == 2) { // select parent
                    if ($('#setp_one_choix_parent').hasClass("d-none")) { 
                        $('#setp_one_choix_parent').removeClass("d-none");
                    } else { 
                    }
                    if ($('#step_one_add_parent').hasClass("d-none")) {
                        //$('#step_one_add_parent').removeClass("d-none");
                    } else {
                        $('#step_one_add_parent').addClass("d-none");
                    }
                    // reset form add parent
                    $('#nom_parent').val("");
                    $('#prenoms_parent').val("");
                    $('#telephone_parent').val("");
                    $('#email_parent').val("");
                }
                if (choix == 3) { // add parent
                    if ($('#setp_one_choix_parent').hasClass("d-none")) {
                        //$('#setp_one_choix_parent').removeClass("d-none");
                    } else {
                        $('#setp_one_choix_parent').addClass("d-none");
                    }

                    if ($('#step_one_add_parent').hasClass("d-none")) {
                        $('#step_one_add_parent').removeClass("d-none");
                    }
                }
            });

            /************** step two ******************/ 

            // update choix parent step
            $('.check_parent_two').on('change', function() {
                //alert($(this).val());
                choix = parseInt($(this).val());
                if (choix == 1) { // none
                    if ($('#setp_two_choix_parent').hasClass("d-none")) {

                        // $('#setp_two_choix_parent').removeClass("d-none");
                    } else {
                        $('#setp_two_choix_parent').addClass("d-none");
                    }

                    if ($('#step_two_add_parent').hasClass("d-none")) {
                        //$('#step_two_add_parent').removeClass("d-none");
                    } else {
                        $('#step_two_add_parent').addClass("d-none");
                    }

                    // reset form add parent
                    $('#nom_parent_two').val("");
                    $('#prenoms_parent_two').val("");
                    $('#telephone_parent_two').val("");
                    $('#email_parent_two').val("");
                }
                if (choix == 2) { // select parent
                    if ($('#setp_two_choix_parent').hasClass("d-none")) { 
                        $('#setp_two_choix_parent').removeClass("d-none");
                    } else { 
                    }
                    if ($('#step_two_add_parent').hasClass("d-none")) {
                        //$('#step_two_add_parent').removeClass("d-none");
                    } else {
                        $('#step_two_add_parent').addClass("d-none");
                    }
                    // reset form add parent
                    $('#nom_parent_two').val("");
                    $('#prenoms_parent_two').val("");
                    $('#telephone_parent_two').val("");
                    $('#email_parent_two').val("");
                }
                if (choix == 3) { // add parent
                    if ($('#setp_two_choix_parent').hasClass("d-none")) {
                        //$('#setp_two_choix_parent').removeClass("d-none");
                    } else {
                        $('#setp_two_choix_parent').addClass("d-none");
                    }

                    if ($('#step_two_add_parent').hasClass("d-none")) {
                        $('#step_two_add_parent').removeClass("d-none");
                    }
                }
            });
            /****** end step two **************/

            // si autre sponsor afficher le formulaire sponsor
            $('#sponsor_id').on('change', function() {
                var typesponsor_id = parseInt($('#sponsor_id').val());
                if (typesponsor_id == 2) {
                    $('#sponsor').val("");
                    if ($('#show_sponsor').hasClass("d-none")) {
                        $('#show_sponsor').removeClass("d-none");
                    }
                } else {
                    // vérifier si la classe n'existe pas
                    if ($('#show_sponsor').hasClass("d-none")) {

                    } else {
                        $('#show_sponsor').addClass("d-none");
                    }
                }

            });


            $('#etablissement_id').on('change', function() {

                var etablissement_id = parseInt($('#etablissement_id').val());
                if (etablissement_id != "") {
                    $('#site_id').empty();
                    $('#site_id').append(
                        '<option value="" selected="selected">Choisissez une option</option>');
                    $.ajax({
                        url: "{{ route('ajax_requete') }}",
                        data: {
                            etablissement_id: etablissement_id,
                            _token: '{{ csrf_token() }}'
                        },
                        type: 'POST',
                        dataType: 'json',
                        success: function(data, status) {
                            jQuery.each(data, function(key, value) {
                                $('#site_id').append('<option value="' + value.id +
                                    '">' + value.sigle + '</option>');
                            });
                        },
                        error: function(xhr, textStatus, errorThrown) {
                            //  alert('Veuillez renseigner tous les champs'); 
                            console.log(xhr);
                            console.log(textStatus);
                            console.log(errorThrown);
                        }
                    });
                }

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

            // gestion des téléphones
            // Define regular expression
            $("#telephone").keypress(function(e) {
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    $("#errmsg").html("Number Only").stop().show().fadeOut("slow");
                    return false;
                }
            });
            // password control
            addEventListener("DOMContentLoaded", (event) => {
                const password = document.getElementById("password-input");
                const passwordAlert = document.getElementById("password-alert");
                const requirements = document.querySelectorAll(".requirements");
                let lengBoolean, bigLetterBoolean, numBoolean, specialCharBoolean;
                let leng = document.querySelector(".leng");
                let bigLetter = document.querySelector(".big-letter");
                let num = document.querySelector(".num");
                let specialChar = document.querySelector(".special-char");
                const specialChars = "!@#$%^&*()-_=+[{]}\\|;:'\",<.>/?`~";
                const numbers = "0123456789";

                requirements.forEach((element) => element.classList.add("wrong"));

                password.addEventListener("focus", () => {
                    passwordAlert.classList.remove("d-none");
                    if (!password.classList.contains("is-valid")) {
                        password.classList.add("is-invalid");
                    }
                });

                password.addEventListener("input", () => {
                    let value = password.value;
                    if (value.length < 8) {
                        lengBoolean = false;
                    } else if (value.length > 7) {
                        lengBoolean = true;
                    }

                    if (value.toLowerCase() == value) {
                        bigLetterBoolean = false;
                    } else {
                        bigLetterBoolean = true;
                    }

                    numBoolean = false;
                    for (let i = 0; i < value.length; i++) {
                        for (let j = 0; j < numbers.length; j++) {
                            if (value[i] == numbers[j]) {
                                numBoolean = true;
                            }
                        }
                    }

                    specialCharBoolean = false;
                    for (let i = 0; i < value.length; i++) {
                        for (let j = 0; j < specialChars.length; j++) {
                            if (value[i] == specialChars[j]) {
                                specialCharBoolean = true;
                            }
                        }
                    }

                    if (lengBoolean == true && bigLetterBoolean == true && numBoolean == true &&
                        specialCharBoolean == true) {
                        password.classList.remove("is-invalid");
                        password.classList.add("is-valid");

                        requirements.forEach((element) => {
                            element.classList.remove("wrong");
                            element.classList.add("good");
                        });
                        passwordAlert.classList.remove("alert-warning");
                        passwordAlert.classList.add("alert-success");
                    } else {
                        password.classList.remove("is-valid");
                        password.classList.add("is-invalid");

                        passwordAlert.classList.add("alert-warning");
                        passwordAlert.classList.remove("alert-success");

                        if (lengBoolean == false) {
                            leng.classList.add("wrong");
                            leng.classList.remove("good");
                        } else {
                            leng.classList.add("good");
                            leng.classList.remove("wrong");
                        }

                        if (bigLetterBoolean == false) {
                            bigLetter.classList.add("wrong");
                            bigLetter.classList.remove("good");
                        } else {
                            bigLetter.classList.add("good");
                            bigLetter.classList.remove("wrong");
                        }

                        if (numBoolean == false) {
                            num.classList.add("wrong");
                            num.classList.remove("good");
                        } else {
                            num.classList.add("good");
                            num.classList.remove("wrong");
                        }

                        if (specialCharBoolean == false) {
                            specialChar.classList.add("wrong");
                            specialChar.classList.remove("good");
                        } else {
                            specialChar.classList.add("good");
                            specialChar.classList.remove("wrong");
                        }
                    }
                });

                password.addEventListener("blur", () => {
                    passwordAlert.classList.add("d-none");
                });
            });

        })();
    </script>
@endsection

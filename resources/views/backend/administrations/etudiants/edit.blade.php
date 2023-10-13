@extends('backend/include/layout')
<!-- title -->
@section('title')
    Enregistrement Etudiant|| {{ env('APP_NAME') }}
@endsection

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
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Modification étudiant</h5>
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
                        <form action="{{ route('admin.etudiant.update', $etudiant->id) }}" method="post">
                            @csrf
                            @method("put")
                            <input type="hidden" name="etudiant_id" value="{{$etudiant->id}}">
                            <div class="form-row">
                                <div class="col-md-6 mb-2">
                                    <label for="form-label">Nom <i class="text-danger">*</i></label>
                                    <input type="text" class="form-control" id="nom"
                                        value="{{ old('nom') ?? $etudiant->getDossier->getPersonne->nom }}" required
                                        aria-describedby="inputGroupPrepend" required name="nom" minlength="2"
                                        maxlength="150" />
                                    <div class="invalid-feedback">Champ obligatoire.</div>
                                    <div class="valid-feedback"></div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="form-label">Prénoms <i class="text-danger">*</i></label>
                                    <input type="text" class="form-control" id="prenoms" required
                                        aria-describedby="inputGroupPrepend" required name="prenoms" minlength="2"
                                        maxlength="150"
                                        value="{{ old('prenoms') ?? $etudiant->getDossier->getPersonne->prenoms }}" />
                                    <div class="invalid-feedback">Champ obligatoire.</div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 mb-2">
                                    <label for="form-label">Téléphone <i class="text-danger">*</i></label>
                                    <input type="text" class="form-control" id="telephone" required
                                        aria-describedby="inputGroupPrepend" name="telephone" maxlength="20"
                                        value="{{ old('telephone') ?? $etudiant->getDossier->getPersonne->tel }}" />
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="form-label">E-mail <i class="text-danger">*</i></label>
                                    <input type="text" class="form-control" id="email"
                                        value="{{ old('email') ?? $etudiant->getDossier->getPersonne->email }}" required
                                        aria-describedby="inputGroupPrepend" name="email" minlength="2"
                                        maxlength="150" />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-4 mb-2">
                                    <label for="form-label">Date de Naissance <i class="text-danger"></i></label>
                                    <input type="date" class="form-control" id="ddn"
                                        value="{{ old('ddn') ?? $etudiant->getDossier->getPersonne->ddn }}"
                                        aria-describedby="inputGroupPrepend" name="ddn" />
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label for="form-label">Lieu de Naissance <i class="text-danger"></i></label>
                                    <input type="text" class="form-control" id="lieu_naissance"
                                        value="{{ old('lieu_naissance') ?? $etudiant->getDossier->getPersonne->lieunais }}"
                                        aria-describedby="inputGroupPrepend" name="lieu_naissance" minlength="2"
                                        maxlength="150" />
                                </div>
                                
                                <div class="col-md-4 mb-2">
                                    <label for="form-label">Genre <i class="text-danger">*</i></label>
                                    <select class="browser-default custom-select search-select" name="genre_id" id="genre_id" required>
                                        <option value="" selected>Choisissez votre genre</option>
                                        @foreach ($genres as $item)
                                            <option value="{{ $item->id }}"
                                                @if ($item->id == $etudiant->getDossier->getPersonne->genre) selected @endif>{{ $item->libelle }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label for="form-label">Groupe Péda. <i class="text-danger">*</i></label>
                                    <select class="browser-default custom-select search-select" name="gp_id" id="gp_id" required>
                                        <option value="{{ $etudiant->getGp->id }}" selected>
                                            {{ $etudiant->getGp->getPole->libelle }}
                                            {{ $etudiant->getGp->getFiliere->libelle }}
                                            {{ $etudiant->getGp->libelle_classe }}
                                            {{ $etudiant->getGp->libelle_secondaire }}
                                        </option>
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
                                    <div class="form-check mt-4">
                                      <input class="form-check-input" type="checkbox" value="confirmation" id="confirmation" name="confirmation">
                                      <label class="form-check-label" for="">
                                        Confirmer le changement du groupe pédagogique
                                      </label>
                                    </div> 
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary" type="submit">Valider</button>
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

            $('#gp_id').on('change', function() {
                $("#confirmation").prop("required",true); 
                console.log("ok")
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

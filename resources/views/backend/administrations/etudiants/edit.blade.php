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
                                        aria-describedby="inputGroupPrepend" required name="telephone" maxlength="20"
                                        value="{{ old('telephone') ?? $etudiant->getDossier->getPersonne->tel }}" />
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="form-label">E-mail <i class="text-danger">*</i></label>
                                    <input type="text" class="form-control" id="email"
                                        value="{{ old('email') ?? $etudiant->getDossier->getPersonne->email }}" required
                                        aria-describedby="inputGroupPrepend" required name="email" minlength="2"
                                        maxlength="150" />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 mb-2">
                                    <label for="form-label">Profil <i class="text-danger">*</i></label>
                                    <select class="browser-default custom-select" name="profil_id" id="profil_id" required>
                                        <option value="" selected>Choisissez votre type</option>
                                        @foreach ($profils as $item)
                                            <option value="{{ $item->id }}"
                                                @if ($item->id == $etudiant->getDossier->getPersonne->getCompte->profil_id) selected @endif>{{ $item->libelle }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="form-label">Genre <i class="text-danger">*</i></label>
                                    <select class="browser-default custom-select" name="genre_id" id="genre_id" required>
                                        <option value="" selected>Choisissez votre genre</option>
                                        @foreach ($genres as $item)
                                            <option value="{{ $item->id }}"
                                                @if ($item->id == $etudiant->getDossier->getPersonne->genre) selected @endif>{{ $item->libelle }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <hr>
                                Voulez-vous ajouter un parent ?
                                <hr class="mt-2">
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input check_parent_two" type="radio" name="ajout_parent"
                                            id="choix_one_two" value="1">
                                        <label class="form-check-label" for="">Non</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input check_parent_two" type="radio" name="ajout_parent"
                                            id="choix_two_two" value="2">
                                        <label class="form-check-label" for="">Non le parent
                                            existe déjà</label>
                                    </div>
                                    {{-- <div class="form-check form-check-inline">
                                                            <input class="form-check-input check_parent_two" type="radio"
                                                                name="ajout_parent" id="choix_tree_two" value="3">
                                                            <label class="form-check-label" for="">Oui je veux
                                                                ajouter</label>
                                                        </div> --}}
                                </div>
                            </div>


                            <div class="form-row mt-2  d-none" id="step_two_add_parent">
                                <div class="bg-light">
                                    <div class="col-md-12 text-primary p-3">Ajouter un parent</div>
                                    <div class="row">
                                        <div class="col-md-4 mb-2">
                                            <label for="form-label">Nom <i class="text-danger">*</i></label>
                                            <input type="text" class="form-control" id="nom_parent_two"
                                                value="{{ old('nom_parent') }}" aria-describedby="inputGroupPrepend"
                                                name="nom_parent" minlength="2" maxlength="150" />
                                            <div class="invalid-feedback">Champ obligatoire.</div>
                                            <div class="valid-feedback"></div>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <label for="form-label">Prénoms <i class="text-danger">*</i></label>
                                            <input type="text" class="form-control" id="prenoms_parent_two"
                                                aria-describedby="inputGroupPrepend" name="prenoms_parent" minlength="2"
                                                maxlength="150" value="{{ old('prenoms_parent') }}" />
                                            <div class="invalid-feedback">Champ obligatoire.</div>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <label for="form-label">Téléphone <i class="text-danger">*</i></label>
                                            <input type="number" class="form-control" id="telephone_parent_two"
                                                aria-describedby="inputGroupPrepend" name="telephone_parent"
                                                min="0" value="{{ old('telephone_parent') }}" />
                                            <div class="invalid-feedback">Champ obligatoire.</div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="form-label">Email <i class="text-danger">*</i></label>
                                            <input type="email" class="form-control" id="email_parent_two"
                                                aria-describedby="inputGroupPrepend" name="email_parent" minlength="2"
                                                maxlength="150" value="{{ old('email_parent') }}" />
                                            <div class="invalid-feedback">Champ obligatoire.</div>
                                        </div>

                                        <div class="col-md-6 mb-2">
                                            <label for="form-label">Genre <i class="text-danger">*</i></label>
                                            <select class="browser-default custom-select" name="genre_parent_id"
                                                id="genre_parent_id_two">
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
                                            <select class="browser-default custom-select" name="choix_parent_id"
                                                id="choix_parent_id_two">
                                                <option value="" selected>Choisissez un parent
                                                </option>
                                                @foreach ($parents as $data)
                                                    <option value="{{ $data->id }}" {{ $data->id == $etudiant->getDossier->getUserCreated->id ? 'selected' : ''  }}>
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
                    } else {}
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
                    } else {}
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

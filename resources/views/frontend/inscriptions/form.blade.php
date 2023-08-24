@extends('frontend.inc.layout')

@section('title')
    Inscription Etudiant || {{ env('APP_NAME') }}
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
    <section class="w3l-contact-breadcrum m-0">
        <div class="breadcrum-bg py-sm-1 py-0 m-0">
            <div class="container py-lg-1">
                <h2>Inscription</h2>
                <!--#<p><a href="{#{ route('inscription') }}">Choix catégorie</a> &nbsp; / &nbsp; Inscription étudiant</p>#-->
            </div>
        </div>
    </section>

    <!-- bmad -->
    <!-- Start your project here-->
    <div class="container">
        <div class="d-flex justify-content-center align-items-center mt-1 mb-1" style="height: ;40vh">
            <div class="card text-center">
                <h5 class="card-header">FORMULAIRE D'INSCRIPTION</h5>
                <div class="card-body">
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
                    <form action="{{ route('inscription.store') }}" method="POST" class="row g-3 needs-validation"
                        novalidate id="inscription">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-6 mb-2">
                                <div class="input-group form-outline">
                                    <span class="input-group-text" id="inputGroupPrepend"><i
                                            class="fas fa-user-alt fa-fw me-3"></i></span>
                                    <input type="text" class="form-control" id="nom" value="{{ old('nom') }}"
                                        required aria-describedby="inputGroupPrepend" required name="nom" minlength="2"
                                        maxlength="150" />
                                    <label for="nom" class="form-label">Nom</label>
                                    <div class="invalid-feedback">Champ obligatoire.</div>
                                    <div class="valid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="input-group form-outline">
                                    <span class="input-group-text" id="inputGroupPrepend"><i
                                            class="fas fa-user-alt fa-fw me-3"></i></span>
                                    <input type="text" class="form-control" id="prenoms" required
                                        aria-describedby="inputGroupPrepend" required name="prenoms" minlength="2"
                                        maxlength="150" value="{{ old('prenoms') }}" />
                                    <label for="prenoms" class="form-label">Prénoms</label>
                                    <div class="invalid-feedback">Champ obligatoire.</div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-2">
                                <div class="input-group form-outline">
                                    <span class="input-group-text" id="inputGroupPrepend"><i
                                            class="fas fa-mobile-alt fa-fw me-3"></i></span>
                                    <input type="text" class="form-control" id="telephone" required
                                        aria-describedby="inputGroupPrepend" required name="telephone" maxlength="20"
                                        value="{{ old('telephone') }}" />
                                    <label for="telephone" class="form-label">Téléphone</label>
                                    <div class="invalid-feedback">Champ obligatoire.</div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="input-group form-outline">
                                    <span class="input-group-text" id="inputGroupPrepend"><i
                                            class="fas fa-envelope fa-fw me-3"></i></span>
                                    <input type="text" class="form-control" id="email" value="{{ old('email') }}"
                                        required aria-describedby="inputGroupPrepend" required name="email" minlength="2"
                                        maxlength="150" />
                                    <label for="email" class="form-label">E-mail</label>
                                    <div class="invalid-feedback">Champ obligatoire.</div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-2">
                                <select class="browser-default custom-select" name="profil_id" id="profil_id" required>
                                    <option value="" selected>Choisissez votre type</option>
                                    @foreach ($profils as $item)
                                        <option value="{{ $item->id }}">{{ $item->libelle }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-2">
                                <select class="browser-default custom-select" name="genre_id" id="genre_id" required>
                                    <option value="" selected>Choisissez votre genre</option>
                                    @foreach ($genres as $item)
                                        <option value="{{ $item->id }}">{{ $item->libelle }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-2">
                                <div class="input-group form-outline">
                                    <span class="input-group-text" id="inputGroupPrepend"><i
                                            class="fas fa-key fa-fw me-3"></i></span>
                                    <input type="password" class="form-control"
                                        pattern="^(?=.{8,32}$)(?=.*[&_@}-!%£])(?=.*[A-Z])(?=.*[0-9]).*"
                                        id="password-input" required aria-describedby="inputGroupPrepend" required
                                        name="password" minlength="2" maxlength="150" />
                                    <label for="password" class="form-label">Mot de passe</label>
                                    <!--<div class="invalid-feedback">Champ obligatoire.</div>-->
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="input-group form-outline">
                                    <span class="input-group-text" id="inputGroupPrepend"><i
                                            class="fas fa-key fa-fw me-3"></i></span>
                                    <input type="password" class="form-control"
                                        pattern="^(?=.{8,32}$)(?=.*[&_@}-!%£])(?=.*[A-Z])(?=.*[0-9]).*"
                                        id="confirm-password" required aria-describedby="inputGroupPrepend" required
                                        name="password_confirmation" minlength="2" maxlength="150" required />
                                    <label for="confirm-password" class="form-label">Confirmation</label>
                                    <div class="invalid-feedback">Champ obligatoire.</div>
                                </div>
                            </div> <!-- fas fa-users fa-fw me-3 -->

                            <div class="col-12 mt-4 mt-xxl-0 w-auto h-auto">

                                <div class="alert px-4 py-3 mb-0 d-none" role="alert" data-mdb-color="warning"
                                    id="password-alert">
                                    <ul class="list-unstyled mb-0">
                                        <li class="requirements leng">
                                            <i class="fas fa-check text-success me-2"></i>
                                            <i class="fas fa-times text-danger me-3"></i>
                                            Votre mot de passe doit contenir au moins 8 caractères
                                        </li>
                                        <li class="requirements big-letter">
                                            <i class="fas fa-check text-success me-2"></i>
                                            <i class="fas fa-times text-danger me-3"></i>
                                            Votre mot de passe doit comporter au moins un caractère majuscule.
                                        </li>
                                        <li class="requirements num">
                                            <i class="fas fa-check text-success me-2"></i>
                                            <i class="fas fa-times text-danger me-3"></i>
                                            Votre mot de passe doit contenir au moins 1 chiffre.
                                        </li>
                                        <li class="requirements special-char">
                                            <i class="fas fa-check text-success me-2"></i>
                                            <i class="fas fa-times text-danger me-3"></i>
                                            Votre mot de passe doit contenir au moins un caractère spécial &_@}-!%£
                                        </li>
                                    </ul>
                                </div>

                            </div>

                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"
                                data-callback='onSubmit' data-action='submit' type="submit">Valider</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-muted"><!--  --></div>
            </div>
        </div>
    </div>
    <!-- end bmad -->

@endsection

@section('js-script')
    <script>
        $(document).ready(function() {
            //$('.custom-select').materialSelect(); 
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

    <script>
        function onSubmit(token) {
            document.getElementById("inscription").submit();
        }
    </script>
@endsection

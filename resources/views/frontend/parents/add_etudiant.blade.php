@extends('frontend.inc.user_layout')

@section('title')
    Ajouter Etudiant || {{ env('APP_NAME') }}
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

    #country-flag {
        width: 2em;
    }
</style>
@section('contenu')
    <section style="background-color: #eee;">
        <div class="container py-1">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard_parent') }}">Accueil</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('parent.etudiants') }}">Liste étudiants</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Ajouter étudiant</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-4">
                        <h5 class="card-header">FORMULAIRE D'AJOUT D'UN ETUDIANT</h5>
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
                            <form action="{{ route('parent.etudiant-store') }}" method="POST"
                                class="row g-3 needs-validation" novalidate enctype="multipart/form-data" onsubmit="">
                                @csrf
                                <div class="form-row">
                                    <div class="col-md-6 mb-2">
                                        <div class="input-group form-outline">
                                            <span class="input-group-text" id="inputGroupPrepend"><i
                                                    class="fas fa-user-alt fa-fw me-3"></i></span>
                                            <input type="text" class="form-control" id="nom" value=""
                                                required aria-describedby="inputGroupPrepend" required name="nom"
                                                minlength="2" maxlength="150" />
                                            <label for="nom" class="form-label">Nom <i
                                                    class="text-danger">*</i></label>
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
                                                maxlength="150" value="" />
                                            <label for="prenoms" class="form-label">Prénoms <i
                                                    class="text-danger">*</i></label>
                                            <div class="invalid-feedback">Champ obligatoire.</div>
                                        </div>
                                    </div>

                                </div>

                                <div class="form-row">
                                    <div class="col-md-6 mb-2">
                                        <div class="input-group form-outline">
                                            <span class="input-group-text" id="inputGroupPrepend"><i
                                                    class="fas fa-user-alt fa-fw me-3"></i></span>
                                            <input type="text" class="form-control" id="nom_jeune_fille" value=""
                                                aria-describedby="inputGroupPrepend" name="nom_jeune_fille" minlength="2"
                                                maxlength="150" />
                                            <label for="nom_jeune_fille" class="form-label">Nom jeune fille</label>
                                            <div class="invalid-feedback"></div>
                                            <div class="valid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div class="input-group form-outline">
                                            <span class="input-group-text" id="inputGroupPrepend"><i
                                                    class="fas fa-calendar-alt fa-fw me-3"></i></span>
                                            <input type="date" class="form-control" id="ddn" required
                                                aria-describedby="inputGroupPrepend" name="ddn"
                                                max="{{ date('Y-m-d') }}" value="" required />
                                            <label for="ddn" class="form-label">Date de naissance <i
                                                    class="text-danger">*</i></label>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 mb-2">
                                        <div class="input-group form-outline">
                                            <span class="input-group-text" id="inputGroupPrepend"><i
                                                    class="fas fa-map-marker-alt fa-fw me-3"></i></span>
                                            <input type="text" class="form-control" id="lieu_naissance"
                                                value="" required aria-describedby="inputGroupPrepend"
                                                name="lieu_naissance" minlength="2" maxlength="150" required />
                                            <label for="lieu_naissance" class="form-label">Lieu naissance <i
                                                    class="text-danger">*</i></label>
                                            <div class="invalid-feedback"></div>
                                            <div class="valid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div class="input-group form-outline">
                                            <span class="input-group-text" id="inputGroupPrepend"><i
                                                    class="fas fa-house-damage fa-fw me-3"></i></span>
                                            <input type="text" class="form-control" id="adresse" required
                                                aria-describedby="inputGroupPrepend" name="adresse" minlength="2"
                                                maxlength="150" value="" />
                                            <label for="adresse" class="form-label">Adresse <i
                                                    class="text-danger">*</i></label>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 mb-2">
                                        <div class="input-group form-outline">
                                            <span class="input-group-text" id="inputGroupPrepend"><i
                                                    class="fas fa-mobile-alt fa-fw me-3"></i></span>
                                            <input type="text" class="form-control" id="telephone" required
                                                aria-describedby="inputGroupPrepend" required name="telephone"
                                                maxlength="20" value="" />
                                            <label for="telephone" class="form-label">Téléphone <i
                                                    class="text-danger">*</i></label>
                                            <div class="invalid-feedback">Champ obligatoire.</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div class="input-group form-outline">
                                            <span class="input-group-text" id="inputGroupPrepend"><i
                                                    class="fas fa-envelope fa-fw me-3"></i></span>
                                            <input type="text" class="form-control" id="email" value=""
                                                required aria-describedby="inputGroupPrepend" required name="email"
                                                minlength="2" maxlength="150" />
                                            <label for="email" class="form-label">E-mail <i
                                                    class="text-danger">*</i></label>
                                            <div class="invalid-feedback">Champ obligatoire.</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">

                                    <div class="col-md-6 mb-2">
                                       

                                        <select class="browser-default custom-select" name="pays" id="pays"
                                            required onchange="updateNationalite()">
                                            <option value="" selected>Choisissez votre pays</option>
                                            @foreach ($pays as $item)
                                                <option value="{{ $item->id }}"
                                                    data-nationalite="{{ $item->nationalite }}"
                                                    data-name="{{ $item->nom_pays }}"><span class="input-group-text"
                                                        id="inputGroupPrepend">
                                                        <img id="country-flag"
                                                            src="storage/imgs/flags/" alt="">

                                                    </span> {{ $item->nom_pays }} ({{ $item->code_iso }})</option>
                                            @endforeach
                                        </select>


                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div class="input-group form-outline">
                                            <span class="input-group-text" id="inputGroupPrepend"><i
                                                    class="fas fa-flag fa-fw me-3"></i></span>
                                            <input type="text" class="form-control" id="nationalite" value=""
                                                required aria-describedby="inputGroupPrepend" required name="nationalite"
                                                minlength="2" maxlength="150" />
                                            <label for="email" class="form-label">Nationalité <i
                                                    class="text-danger">*</i></label>
                                            <div class="invalid-feedback">Champ obligatoire.</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 mb-2">
                                        <select class="browser-default custom-select" name="genre_id" id="genre_id"
                                            required>
                                            <option value="" selected>Choisissez votre genre</option>
                                            @foreach ($genres as $item)
                                                <option value="{{ $item->id }}">{{ $item->libelle }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div class="input-group form-outline">
                                            <span class="input-group-text" id="inputGroupPrepend"><i
                                                    class="fas fa-images fa-fw me-3"></i></span>
                                            <input type="file" class="form-control" id="photo"
                                                aria-describedby="inputGroupPrepend" name="photo" />
                                            <label for="photo" class="form-label"></label>
                                            <!--<div class="invalid-feedback">Champ obligatoire.</div>-->
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 mb-2">
                                        <div class="input-group form-outline">
                                            <span class="input-group-text" id="inputGroupPrepend"><i
                                                    class="fab fa-internet-explorer fa-fw me-3"></i></span>
                                            <input type="text" class="form-control" id="site_web"
                                                aria-describedby="inputGroupPrepend" name="site_web" maxlength="150"
                                                value="" />
                                            <label for="site_web" class="form-label">Site web</label>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div class="input-group form-outline">
                                            <span class="input-group-text" id="inputGroupPrepend"><i
                                                    class="fab fa-linkedin fa-fw me-3"></i></span>
                                            <input type="text" class="form-control" id="lien_linkedin" value=""
                                                aria-describedby="inputGroupPrepend" name="lien_linkedin" minlength="2"
                                                maxlength="150" />
                                            <label for="lien_linkedin" class="form-label">Profil LinkedIn</label>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 mb-2">
                                        <div class="input-group form-outline">
                                            <span class="input-group-text" id="inputGroupPrepend"><i
                                                    class="fab fa-facebook fa-fw me-3"></i></span>
                                            <input type="text" class="form-control" id="lien_facebook"
                                                aria-describedby="inputGroupPrepend" name="lien_facebook" maxlength="150"
                                                value="" />
                                            <label for="lien_facebook" class="form-label">Profil Facebook</label>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div class="input-group form-outline">
                                            <span class="input-group-text" id="inputGroupPrepend"><i
                                                    class="fab fa-github fa-fw me-3"></i></span>
                                            <input type="text" class="form-control" id="lien_github" value=""
                                                aria-describedby="inputGroupPrepend" name="lien_github" minlength="2"
                                                maxlength="150" />
                                            <label for="lien_github" class="form-label">Profil Github</label>
                                            <div class="invalid-feedback"></div>
                                        </div>
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
                                            <label for="password" class="form-label">Mot de passe <i
                                                    class="text-danger">*</i></label>
                                            <!--<div class="invalid-feedback">Champ obligatoire.</div>-->
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div class="input-group form-outline">
                                            <span class="input-group-text" id="inputGroupPrepend"><i
                                                    class="fas fa-key fa-fw me-3"></i></span>
                                            <input type="password" class="form-control"
                                                pattern="^(?=.{8,32}$)(?=.*[&_@}-!%£])(?=.*[A-Z])(?=.*[0-9]).*"
                                                id="confirm-password" required aria-describedby="inputGroupPrepend"
                                                required name="password_confirmation" minlength="2" maxlength="150"
                                                required />
                                            <label for="confirm-password" class="form-label">Confirmation <i
                                                    class="text-danger">*</i></label>
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
            $('#pays').select2();
            // remove menu active 
            $("div a").removeClass('active');
            // active menu   
            $("#dossier_etudiant").addClass('active');




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
   
    //mettre à jour la nationalité et le code pays
    function updateNationalite() {
        let nationality = pays.options[pays.selectedIndex].getAttribute("data-nationalite");
        console.log(nationality);
        document.getElementById('nationalite').value = nationality;

    }
    </script>
@endsection

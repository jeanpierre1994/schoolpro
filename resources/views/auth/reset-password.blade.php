@extends('frontend.inc.layout')

@section('title')
    Connexion || {{ env('APP_NAME') }}
@endsection
@section('contenu')
    <section class="w3l-contact-breadcrum m-0">
        <div class="breadcrum-bg py-sm-1 py-0 m-0">
            <div class="container py-lg-1">
                <h2>Modifier mt de passe</h2>
                <!--#<p><a href="{#{ route('inscription') }}">Choix catégorie</a> &nbsp; / &nbsp; Inscription étudiant</p>#-->
            </div>
        </div>
    </section>

    <!-- bmad -->
    <!-- Start your project here-->
    <div class="container">
        <div class="d-flex justify-content-center align-items-center mt-1 mb-1" style="height: ;40vh">
            <div class="card text-center">
                <h5 class="card-header">UPDATE PASSORD</h5>
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
                    @if(Session::has('status'))
                        <div class="alert alert-success">
                            <strong>Success!</strong>
                            <p>{{session('status')}}</p>
                        </div>
                    @endif
                    <section class="vh-90x">
                        <div class="container py-0 h-100">
                            <div class="row d-flex align-items-center justify-content-center h-100">

                                @desktop
                                <div class="col-md-8 col-lg-7 col-xl-6">
                                    <!--<img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.svg"
                                    class="img-fluid" alt="Phone image">-->
                                    <img src="{{asset('frontpage/bmad/img/forgot-password.svg')}}" width="400"
                                         height="400"
                                         class="img-fluid" alt="Phone image">
                                </div>
                                @elsedesktop
                                @enddesktop
                                <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                                    <form action="{{ route('password.store') }}" method="POST"
                                          class="row g-3 needs-validation" novalidate>
                                        @csrf
                                        <input type="hidden" name="token" value="{{ $request->route('token') }}">
                                        @desktop
                                        <div class="text-center mb-4 mt-1">
                                            <span class="avatar"><i
                                                    class="fas fa-user-lock fa-fw me-10 fa-5x"></i></span>
                                        </div>
                                        @elsedesktop
                                        <div class="text-center mb-4 mt-0">
                                            <span class="avatar"><i
                                                    class="fas fa-user-lock fa-fw me-10 fa-3x"></i></span>
                                        </div>
                                        @enddesktop
                                        <!-- Email input  -->
                                        <div class="form-outline mb-4">
                                            <input type="email" minlength="3" maxlength="50" name="email"
                                                   value="{{ old('email', $request->email) }}" id="form1Example13"
                                                   class="form-control form-control-lg"/>
                                            <label class="form-label" for="form1Example13">E-mail</label>
                                        </div>
                                        <div class="form-outline mb-4">
                                            <input type="password" minlength="3" maxlength="50" name="password" id="form1Example23" class="form-control form-control-lg" />
                                            <label class="form-label" for="form1Example23">Mot de passe</label>
                                        </div>
                                        <div class="form-outline mb-4">
                                            <input id="password-confirm" type="password" minlength="3" maxlength="50" name="password_confirmation" id="form1Example23" class="form-control form-control-lg" />
                                            <label class="form-label" for="form1Example23"> Confirmer mot de passe</label>
                                        </div>
                                        <!-- Submit button -->
                                        <button type="submit" class="btn btn-primary btn-lg btn-block">Se connecter
                                        </button>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="card-footer text-muted">
                    <!--  -->
                </div>
            </div>
        </div>
    </div>
    <!-- end bmad -->

@endsection

@section('js-script')
    <script>
        $(document).ready(function () {

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

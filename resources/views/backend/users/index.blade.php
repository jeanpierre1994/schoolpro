@extends('backend/include/layout')
<!-- title -->
@section('title')
    Utilisateurs || {{ env('APP_NAME') }}
@endsection

@section('fil-arial')
    <div class="pagetitle">
        <h1>Paramètres</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" style="text-decoration: none;">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.parametres') }}"
                        style="text-decoration: none;">Paramètres</a></li>
                <li class="breadcrumb-item active">Utilisateurs</li>
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
                        <div class="row mb-3">

                            <div class="col-md-4">

                                <h5 class="card-title">Liste des utilisateurs <a href="{{ route('users.create') }}" data-mdb-toggle="tooltip"
                                        data-mdb-placement="right" title="Ajouter" class="btn btn-primary btn-floating btn-sm">
                                        Ajouter
                                    </a></h5>
                            </div>

                            <div class="col-md-4">
                                <form method="get">
                                    <select name="profile" class="form-select" onchange="this.form.submit()">
                                        <option value="">Tous</option>
                                        @foreach ($profiles as $profile)
                                            <option value="{{ \Crypt::encrypt($profile->id) }}"
                                                @if (Request::get('profile') || Request::get('profile') != ''  ) {{ \Crypt::decrypt(Request::get('profile'))  == $profile->id ? 'selected' : '' }} @endif>
                                                {{ $profile->libelle }}</option>
                                        @endforeach

                                    </select>


                                </form>
                            </div>
                        </div>

                        <!-- Bordered Table -->
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-bordered data-tables">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nom</th>
                                        <th scope="col">Prénoms</th>
                                        <th scope="col">Genre</th>
                                        <th scope="col">Profil</th>
                                        <th scope="col">Téléphone</th>
                                        <th scope="col">E-mail</th>
                                        <th scope="col">Date modification</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($users as $item)
                                        <tr>
                                            <td class="text-center"><b>{{ $i++ }}</b></td>
                                            <td>{{ $item->nom }}</td>
                                            <td>{{ $item->prenoms }}</td>
                                            <td>{{ $item->getGenre->libelle }}</td>
                                            <td>{{ $item->getCompte->getProfil->libelle }}</td>
                                            <td>{{ $item->tel }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->updated_at->format('d-m-Y à H:i:s') }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('users.edit', \Crypt::encrypt($item->id)) }}"
                                                    title="Modifier"><button type="button"
                                                        class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"
                                                            style="color: white" aria-hidden="true"></i></button></a>
                                                <a href="#" class="page-constructionv" data-bs-toggle="modal"
                                                    data-bs-target="#myModal_{{ $item->id }}">
                                                    <button type="button" title="Supprimer"
                                                        class="btn btn-sm btn-danger"><i class="bi bi-trash"
                                                            style="color: white" aria-hidden="true"></i></button>
                                                </a>

                                                <!-- The Modal -->
                                                <div class="modal text-center" id="myModal_{{ $item->id }}">
                                                    <div class="modal-dialog modal-md modal-dialog-centered">
                                                        <div class="modal-content text-center">

                                                            <!-- Modal Header -->
                                                            <div class="modal-header">
                                                                <h4 class="modal-title text-center"
                                                                    style="text-align: center;">Confirmer l'action <i
                                                                        class="bi bi-trash text-danger"></i></h4>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"></button>
                                                            </div>

                                                            <!-- Modal body -->
                                                            <div class="modal-body">
                                                                <div class="row mt-2 mb-2">
                                                                    <div
                                                                        class="col-md-12 text-center font-weight-bold font-height-10">
                                                                        Voulez-vous vraiment supprimer cet élément ?
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Modal footer -->
                                                            <div class="modal-footer">

                                                                <form
                                                                    action="{{ route('users.destroy', \Crypt::encrypt($item->id)) }}"
                                                                    method="post">
                                                                    @method('DELETE')
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-danger btn-md"
                                                                        id="" value="">OUI
                                                                    </button>
                                                                    <button type="button" class="btn btn-md btn-secondary"
                                                                        data-bs-dismiss="modal">NON</button>
                                                                </form>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End modal -->
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <!-- End Bordered Table -->

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

            //Pour gérer l'activation et la désactivation d'un élément
            // desactivation
            $('a.confirmation-desactivation').confirm({
                title: "",
                content: "<div style='border-bottom: 1px solid #ddd;' class='text-center'><img width='100px' src='{{ asset('front-design/images/logo-white.svg') }}' alt='logo'></div> <br> " +
                    "<div class='text-center'><p class='text-danger'>Désactivation de l'élément ?</p> <span class='text-center'>Cette action est irréversible.</span> </div>",
                type: 'red',
                typeAnimated: true,
                draggable: true,
                dragWindowBorder: false,
                fermer: function() {

                }
            });

            $('a.confirmation-desactivation').confirm({
                buttons: {
                    hey: function() {
                        location.href = this.$target.attr('href');
                    }
                }
            });

            // activation
            $('a.confirmation-activation').confirm({
                title: "",
                content: "<div style='border-bottom: 1px solid #ddd;' class='text-center'><img width='100px' src='{{ asset('front-design/images/logo-white.svg') }}' alt='logo'></div> <br> " +
                    "<div class='text-center'><p class='text-danger'>Activation de l'élément ?</p> <span class='text-center'>Cette action est irréversible.</span> </div>",
                type: 'red',
                typeAnimated: true,
                draggable: true,
                dragWindowBorder: false,
                fermer: function() {

                }
            });
            $('a.confirmation-activation').confirm({
                buttons: {
                    hey: function() {
                        location.href = this.$target.attr('href');
                    }
                }
            });

        });
    </script>
@endsection

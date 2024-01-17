@extends('backend/include/layout')
<!-- title -->
@section('title')
    Generer Notes || {{ env('APP_NAME') }}
@endsection

@section('fil-arial')
    <div class="pagetitle">
        <h1>Paramètres</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" style="text-decoration: none;">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.parametres') }}"
                        style="text-decoration: none;">Paramètres</a></li>
                <li class="breadcrumb-item active">Generer Notes </li>
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
                        <h5 class="card-title"></h5>
                        <form action="{{ route('bulletins.save-note') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="label fw-bold">Classe</label>
                                        <select name="classe" id="classe" class="form-select">
                                            <option value="">--- Choisissez une valeur ---</option>
                                            @foreach ($gp as $item)
                                                <option value="{{ $item->id }}">{{ $item->getCycle->libelle }}
                                                    {{ $item->getPole->libelle }} {{ $item->getFiliere->libelle }}
                                                    {{ $item->libelle_classe }} {{ $item->libelle_secondaire }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="label fw-bold">Bulletin</label>
                                        <select name="bulletin" id="bulletin" class="form-select">
                                            <option value="">--- Choisissez une valeur ---</option>
                                            @foreach ($bulletins as $item)
                                                <option value="{{ $item->code }}">{{ $item->code }}
                                                    {{ $item->libelle_primaire }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">

                                    <div class="form-group">
                                        <label for="label fw-bold">Action</label><br>
                                        <input type="submit" name="afficher" value="Afficher" class="btn btn-primary btn-sm">
                                        <button type="submit" class="btn btn-secondary btn-sm">Generer notes</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Liste des notes des notes
                            @if ($update)
                                Classe : {{ $get_gp->getCycle->libelle }} {{ $get_gp->getPole->libelle }}
                                {{ $get_gp->getFiliere->libelle }} {{ $get_gp->libelle_classe }}
                                {{ $get_gp->libelle_secondaire }} &nbsp;&nbsp;&nbsp;
                                Bulletin : {{ $get_bulletin->code_bulletin }} {{ $get_bulletin->libelle_primaire }}
                            @else
                            
                            Classe................ Bulletin ................

                            @endif
                        </h5>
                        <!-- Bordered Table -->
                        <div class="table-responsive">
                            <table id="tableHead" class="table table-striped table-hover table-bordered data-tables">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Matricule</th>
                                        <th scope="col">Eleve</th>
                                        <th scope="col">Matiere</th>
                                        <th scope="col">Note 1 (20)</th>
                                        <th scope="col">Note 2 (20)</th>
                                        <th scope="col">Devoir (60)</th>
                                        <th scope="col">Moyenne (100)</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($update == true)
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($liste_notes as $data)
                                        @php
                                           // $my = ceil( (($data->note_first+$data->note_second)/2 + ($data->devoir*$data->getExamenprog->getMatiere->coef) )/2);
                                           $my = $data->note_first+$data->note_second +$data->devoir;
                                       @endphp
                                            <tr>
                                                <td><b>{{ $i++ }}</b></td>
                                                <td>{{ $data->etudiant_id ? $data->getEtudiant->matricule : '' }}</td>
                                                <td>{{ $data->etudiant_id ? $data->getEtudiant->getDossier->getPersonne->nom : '' }}
                                                </td>
                                                <td>{{ $data->examen_prog_id ? $data->getExamenprog->getMatiere->libelle : '' }}
                                                </td>
                                                <td>{{ $data->note_first ? $data->note_first : 0 }}</td>
                                                <td>{{ $data->note_second ? $data->note_second : 0 }}</td>
                                                <td>{{ $data->devoir ? $data->devoir : 0  }}</td>
                                                <td>{{$my}}</td>
                                                <td class="text-center">
                                                     <a target="_blank"
                                                        href="{{ route('show-bulletin', ['id' => \Crypt::encrypt($data->etudiant_id), 'codeBulletin'=>$data->code_bulletin]) }}"
                                                        title="Bulletin"><button type="button"
                                                            class="btn btn-sm btn-danger"><i
                                                                class="bi bi-file-earmark-pdf text-white"
                                                                style="color: white" aria-hidden="true"></i></button></a>
                                                    {{-- <form
                                                        action="{{ route('admin.etudiant.mail', \Crypt::encrypt($item->id)) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="etudiant_id"
                                                            value="{{ \Crypt::encrypt($etudiant->id) }}">
                                                        <button type="submit" class="btn btn-sm btn-primary"><i
                                                                class="bi bi-envelope text-white" style="color: white"
                                                                aria-hidden="true"></i>
                                                        </button>
                                                    </form> --}}


                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    @endif
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
            // Setup - add a text input to each footer cell

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

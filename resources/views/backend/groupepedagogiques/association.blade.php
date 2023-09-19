@extends('backend/include/layout')

@section('title')
    Association Groupe Pédagogique || {{ env('APP_NAME') }}
@endsection

@section('fil-arial')
    <div class="pagetitle">
        <h1>Paramètres</h1>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard_parent') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('groupepedagogiques.index') }}">Groupe Pédagogique</a></li>
                <li class="breadcrumb-item active" aria-current="page"> Nouveau</li>
            </ol>
        </nav>
    </div>
@endsection

@section('contenu')
    <section style="background-color: #eee;">
        <div class="containerx py-1">

            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-4">
                        <h5 class="card-header">Groupe Pédagogique</h5>
                        <div class="card-body text-center">

                            <div class="form-row">
                                <div class="col-md-3 mb-1">
                                    <label for="nom" class="form-label float-left"><b>Pôle <i
                                                class="text-danger">*</i></b></label>

                                    <input type="text" class="form-control"required aria-describedby="inputGroupPrepend"
                                        minlength="2" maxlength="150" value="{{ $gp->getPole->libelle }}" readonly />
                                </div>
                                <div class="col-md-3 mb-1">
                                    <label for="nom" class="form-label float-left"><b>Filière <i
                                                class="text-danger">*</i></b></label>

                                    <input type="text" class="form-control"required aria-describedby="inputGroupPrepend"
                                        minlength="2" maxlength="150" value="{{ $gp->getFiliere->libelle }}" readonly />

                                </div>
                                <div class="col-md-3 mb-1">
                                    <label for="cycle" class="form-label float-left"><b>Cycle <i
                                                class="text-danger">*</i></b></label>
                                    <input type="text" class="form-control"required aria-describedby="inputGroupPrepend"
                                        minlength="2" maxlength="150" value="{{ $gp->getCycle->libelle }}" readonly />

                                </div>
                                <div class="col-md-3 mb-1">
                                    <label for="niveau" class="form-label float-left"><b>Niveau <i
                                                class="text-danger">*</i></b></label>
                                    <input type="text" class="form-control"required aria-describedby="inputGroupPrepend"
                                        minlength="2" maxlength="150" value="{{ $gp->getNiveau->libelle }}" readonly />

                                </div>
                            </div>

                            <div class="form-row" style="text-align: left;">
                                <div class="col-md-4 mb-1">
                                    <label for="niveau" class="form-label float-left"><b>Libellé classe <i
                                                class="text-danger">*</i></b></label>
                                    <input type="text" class="form-control"required aria-describedby="inputGroupPrepend"
                                        minlength="2" maxlength="150" value="{{ $gp->libelle_classe }}" readonly />

                                </div>
                                <div class="col-md-4 mb-1">
                                    <label for="nom" class="form-label"><b>Libellé FR <i
                                                class="text-danger">*</i></b></label>
                                    <input type="text" class="form-control" id="libelle_classe"
                                        value="{{ $gp->libelle_classe }}" aria-describedby="inputGroupPrepend"
                                        name="libelle_classe" minlength="2" maxlength="150" required />
                                </div>
                                <div class="col-md-4 mb-1">
                                    <label for="nom" class="form-label"><b>Libellé EN <i
                                                class="text-danger">*</i></b></label>
                                    <input type="text" class="form-control" id="libelle_secondaire"
                                        value="{{ $gp->libelle_secondaire }}" required aria-describedby="inputGroupPrepend"
                                        name="libelle_secondaire" minlength="2" maxlength="150" />
                                </div>
                            </div>
                            <div class="row mt-3 text-center d-flex">
                                <div class="col-md-4 mx-auto">
                                    <button class="btn btn-primary show-modal" type="button">Ajouter matière ou
                                        professeur</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-4">
                        <h5 class="card-header">Liste des matières et professeurs</h5>
                        <div class="card-body">

                            <div class="form-row">
                                <div class="table-responsive">
                                    <table id="tableHead"
                                        class="table table-striped table-hover table-bordered data-tables">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Matière</th>
                                                <th scope="col">Coef</th>
                                                <th scope="col">Note max</th>
                                                <th scope="col">Moyenne</th>
                                                <th scope="col">Section</th>
                                                <th scope="col">Professeur</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i = 1;
                                                $have_prof = false;
                                                $sec=0;
                                            @endphp
                                            @foreach ($matieres as $item)
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td>{{ $item->libelle }}</td>
                                                    <td class="text-center">{{ $item->coef }}</td>
                                                    <td class="text-center">{{ $item->note_max }}</td>
                                                    <td class="text-center">{{ $item->moyenne }}</td>
                                                    <td>{{ $item->getSection->libelle }}</td>
                                                    <td>
                                                        @foreach (getProfByMatiere($item->id, $item->groupepedagogique_id) as $data)
                                                            @php
                                                                $have_prof = true;
                                                            @endphp
                                                            @if ($loop->last)
                                                                <span class="badge bg-primary">{{ $data->nom }}
                                                                    {{ $data->prenoms }} {{ $data->email }}</span>
                                                            @else
                                                                <span class="badge bg-primary">{{ $data->nom }}
                                                                    {{ $data->prenoms }} {{ $data->email }}</span> &nbsp;
                                                            @endif
                                                            <input type="hidden" id="prof_delete_id"
                                                                name="prof_delete_id" value="{{ $data->user_id }}">
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        <div class="d-flex justify-content-evenly">
                                                            <a href="#" title="Ajouter professeur"
                                                                data-matiere="{{ $item->id }}"
                                                                data-libelle-matiere="{{ $item->libelle }}"
                                                                data-note_max="{{ $item->note_max }}"
                                                                data-moyenne="{{ $item->moyenne }}"
                                                                data-section_id="{{ $sec = $item->section_id }}"
                                                                data-coef="{{ $item->coef }}"
                                                                data-gp="{{ $gp->id }}" class="show-prof-modal">
                                                                <button type="button" class="btn btn-sm btn-warning"><i
                                                                        class="bi bi-person" style="color: white"
                                                                        aria-hidden="true"></i></button></a>
                                                            <a href="#" title="Supprimer"><button type="button"
                                                                    data-matiere="{{ $item->id }}"
                                                                    data-libelle-matiere="{{ $item->libelle }}"
                                                                    data-gp="{{ $gp->id }}"
                                                                    class="btn btn-sm btn-danger show-delete-modal"><i
                                                                        class="bi bi-trash" style="color: white"
                                                                        aria-hidden="true"></i></button></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>




    <!-- modal -->

    <div class="modal fade" id="modalMatiere" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modalematiere" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary w-100 text-center text-white">
                    <h5 class="modal-title text-white" id="modalDelete">Ajouter une matière à la classe :
                        {{ $gp->libelle_classe }} </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form" action="{{ route('groupepedagogiques.association-store') }}" method="post">
                    @csrf
                    <input type="hidden" value="{{ $gp->id }}" name="gp_id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="label">Matière <i class="text-danger">*</i></label>
                                <select class="form-select" name="matiere_id" id="matiere_id" required>
                                    <option selected value="">Sélectionnez une option</option>
                                    @foreach ($listeMatieres as $donnees)
                                        @if (!checkGpMatiere($gp->id, $donnees->id))
                                            <option value="{{ $donnees->id }}">{{ $donnees->libelle }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="label">Section <i class="text-danger">*</i></label>
                                <select class="form-select" name="section_id" id="section_id" required>
                                    <option selected value="">Sélectionnez une option</option>
                                    @foreach ($sections as $section)
                                        <option value="{{ $section->id }}">{{ $section->libelle }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-6 ">
                                <label for="label">Note max <i class="text-danger">*</i></label>
                                <input type="number" min="0" name="note_max" id="note_max"
                                    class="form-control" value="20" required>
                            </div>
                            <div class="form-group col-md-6 ">
                                <label for="label">Moyenne <i class="text-danger">*</i></label>
                                <input type="number" min="0" value="10" name="moyenne" id="moyenne"
                                    class="form-control" required>
                            </div>
                            <div class="form-group col-md-6 ">
                                <label for="label">Coef <i class="text-danger">*</i></label>
                                <input type="number" min="1" value="1" name="coef" id="coef"
                                    class="form-control" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="label">Professeur <i class="text-danger"></i></label>
                                <select class="form-select" name="professeur_id" id="professeur_id">
                                    <option selected value=""></option>
                                    @foreach ($professeurs as $data)
                                        <option value="{{ $data->compte_id }}">{{ $data->nom }} {{ $data->prenoms }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" id="valider" class="btn btn-primary">Valider</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end modal export -->

    <!-- modal delete data -->

    <div class="modal fade" id="modalDeleteMatiere" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modaledeletematiere" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary w-100 text-center text-white">
                    <h5 class="modal-title text-white" id="modalDelete">Suppression d'une matière ou professeur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form" action="{{ route('groupepedagogiques.delete-data') }}" method="post">
                    @csrf
                    <input type="hidden" value="" name="gp_id" id="gp_id">
                    <input type="hidden" name="prof_sup_id" id="prof_sup_id">
                    <input type="text" value="" name="matiere_delete_id" id="matiere_delete_id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Matière</label>
                                    <input type="text" class="form-control" disabled name=""
                                        id="libelle_matiere" aria-describedby="helpId" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-6">

                            </div>
                            <div class="col-md-6">

                            </div>
                            <div class="col-md-12">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="delete_data" value="1">
                                    <label class="form-check-label" for="">Matière</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="delete_data" value="2">
                                    <label class="form-check-label" for="">Professeur</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="delete_data" value="3">
                                    <label class="form-check-label" for="">Matière et professeur</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" id="valider" class="btn btn-primary">Valider</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- modal add prof data -->

    <div class="modal fade" id="modalProf" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modaleprof" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary w-100 text-center text-white">
                    <h5 class="modal-title text-white" id="modalDelete">Ajouter un professeur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form" action="{{ route('groupepedagogiques.update-profmatiere') }}" method="post">
                    @csrf
                    <input type="hidden" value="" name="prof_gp_id" id="prof_gp_id">
                    <input type="hidden" value="" name="prof_matiere_id" id="prof_matiere_id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Matière</label>
                                    <input type="text" class="form-control" disabled name=""
                                        id="prof_libelle_matiere" aria-describedby="helpId" placeholder="">
                                </div>
                            </div>
                            <div class="form-group col-md-12 ">
                                <label for="label">Section <i class="text-danger">*</i></label>
                                <select class="form-select" name="section_id" id="section_id" required>
                                    <option selected value="">Sélectionnez une option</option>
                                    @foreach ($sections as $section)
                                        <option value="{{ $section->id }}" {{ $section->id == $sec ? 'selected' : '' }}>{{ $section->libelle }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4 ">
                                <label for="label">Note max <i class="text-danger">*</i></label>
                                <input type="number" min="0" name="note_max" id="note_max2"
                                    class="form-control" value="20" required>
                            </div>
                            <div class="form-group col-md-4 ">
                                <label for="label">Moyenne <i class="text-danger">*</i></label>
                                <input type="number" min="0" value="10" name="moyenne" id="moyenne2"
                                    class="form-control" required>
                            </div>
                            <div class="form-group col-md-4 ">
                                <label for="label">Coef <i class="text-danger">*</i></label>
                                <input type="number" min="1" value="1" name="coef" id="coef2"
                                    class="form-control" required>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Professeur</label>
                                    <select class="form-select" name="professeur_id">
                                        <option selected value=""></option>
                                        @foreach ($professeurs as $data)
                                            <option value="{{ $data->compte_id }}">{{ $data->nom }}
                                                {{ $data->prenoms }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" id="valider-prof" class="btn btn-primary">Valider</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end modal export -->
@endsection

@section('script-js')
    <script>
        // show modal 

        $(document).ready(function() {
            // remove menu active
            $("ul").removeClass('show');
            $("ul li a").removeClass('active');
            // active menu 
            $("#parametres").removeClass('collapsed');
 
            // show modal
            $(".show-modal").on("click", function() {
                $('#modalMatiere').modal('show')
            });

            // show delete modal
            $(".show-delete-modal").on("click", function() {
                $("#libelle_matiere").val($(this).attr("data-libelle-matiere"));
                $("#gp_id").val($(this).attr("data-gp"));
                $("#matiere_delete_id").val($(this).attr("data-matiere"));
                $("#prof_sup_id").val($("#prof_delete_id").val())
                $('#modalDeleteMatiere').modal('show')
            });
            // show prof modal
            $(".show-prof-modal").on("click", function() {
                $("#prof_libelle_matiere").val($(this).attr("data-libelle-matiere"));
                $("#prof_gp_id").val($(this).attr("data-gp"));
                $("#prof_matiere_id").val($(this).attr("data-matiere"));
                $('#modalProf').modal('show')
                $('#note_max2').val($(this).attr("data-note_max"));
                $('#section_id2').val($(this).attr("data-section_id"));
                $('#moyenne2').val($(this).attr("data-moyenne"));
                $('#coef2').val($(this).attr("data-coef"));
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
        })();
    </script>
@endsection

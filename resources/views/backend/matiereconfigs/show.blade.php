@extends('backend/include/layout')
<!-- title -->
@section('title')
    Matière || {{ env('APP_NAME') }}
@endsection

@section('fil-arial')
    <div class="pagetitle">
        <h1>Paramètres</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" style="text-decoration: none;">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.parametres') }}"
                        style="text-decoration: none;">Paramètres</a></li>
                <li class="breadcrumb-item"><a href="{{ route('matiereconfigs.index') }}">Matières</a> </li>
                <li class="breadcrumb-item active">Détails </li>
            </ol>
        </nav>
    </div>
@endsection

@section('contenu')
    <section class="section">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="" class="form-label">Sigle</label>
                    <input type="text" class="form-control" name="" id="" aria-describedby="helpId"
                        value="{{ $matiereconfig->sigle }}" placeholder="" readonly>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="" class="form-label">Libellé</label>
                    <input type="text" class="form-control" name="" id="" aria-describedby="helpId"
                        value="{{ $matiereconfig->libelle }}" placeholder="" readonly>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Liste des classes et professeurs <a href="#" title="Ajouter"
                                class="show-modal"><button style="font-size: 15px;" type="button"
                                    class="btn btn-lg btn-outline-primary">Ajouter une classe</button></a></h5>
                        <!-- Bordered Table -->
                        <div class="table-responsive">
                            <table id="tableHead" class="table table-striped table-hover table-bordered data-tables">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Classe</th>
                                        <th scope="col">Professeur</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                        $gpId = 1;
                                    @endphp
                                    @foreach ($matiere_gp as $item)
                                        <tr>
                                            <td class="text-center"><b>{{ $i++ }}</b></td>
                                            <td>{{ $item->getGp->getFiliere->libelle }} {{ $item->getGp->libelle_classe }}
                                                {{ $item->getGp->libelle_secondaire }}</td>
                                            <td>
                                                @foreach (getProfesseurMatiere($item->id) as $prof)
                                                    <span
                                                        class="badge bg-primary">{{ getDataProfesseur($prof->professeur_id)->nom }}
                                                        {{ getDataProfesseur($prof->professeur_id)->prenoms }}</span>
                                                        <input type="hidden" id="prof_delete_id" name="prof_delete_id" value="{{$prof->professeur_id}}">

                                                @endforeach
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-evenly">
                                                    <!--<a href="#" title="Modifier"><button type="button"
                                                                            class="btn btn-sm btn-warning"><i
                                                                                class="bi bi-pencil-square" style="color: white"
                                                                                aria-hidden="true"></i></button></a>-->
                                                    <a href="#" title="Supprimer"><button type="button"
                                                            data-matiere="{{ $item->id }}"
                                                            data-libelle-matiere="{{ $item->libelle }}"
                                                            @php
                                                                $gpId =  $item->groupepedagogique_id;
                                                            @endphp
                                                            data-gp="{{ $item->groupepedagogique_id }}"
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
                        <!-- End Bordered Table -->

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
                    <h5 class="modal-title text-white" id="modalDelete">Ajouter une classe au matière :
                        {{ $matiereconfig->sigle }} {{ $matiereconfig->libelle }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form" action="{{ route('matiereconfigs.store-gp') }}" method="post">
                    @csrf
                    <input type="hidden" value="{{ $matiereconfig->id }}" name="matiereconfig_id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="label">Groupe Péda. <i class="text-danger">*</i></label>
                                <select class="form-select" name="gp_id" id="gp_id" required>
                                    <option selected value="">Sélectionnez une option</option>
                                    @foreach ($gp as $item)
                                        @if (checkGpMatiere($item->id, $matiereconfig->id))
                                        @else
                                            <option value="{{ $item->id }}">{{ $item->getFiliere->libelle }}
                                                {{ $item->libelle_classe }} {{ $item->libelle_secondaire }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="label">Section <i class="text-danger">*</i></label>
                                <select class="form-select" name="section_id" id="section_id" required>
                                    <option selected value="">Sélectionnez une option</option>
                                    @foreach ($sections as $item)
                                        <option value="{{ $item->id }}">{{ $item->libelle }}</option>
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
                                <select class="form-select" name="professeur_id" id="professeur_id" required>
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

    <div class="modal fade" id="modalDeleteMatiere" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modaledeletematiere" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary w-100 text-center text-white">
                    <h5 class="modal-title text-white" id="modalDelete">Suppression d'une matière ou professeur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form" action="{{ route('groupepedagogiques.delete-data-GpProf') }}" method="post">
                    @csrf
                    <input type="hidden" value="{{ $gpId }}"  name="gp_id" id="gp_id">
                    <input type="hidden" name="prof_sup_id" id="prof_sup_id">
                    <input type="hidden"  name="matiere_delete_id" id="matiere_delete_id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Matière</label>
                                    <input type="text" class="form-control" disabled name=""
                                        id="libelle_matiere" aria-describedby="helpId" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="delete_data" value="1">
                                    <label class="form-check-label" for="">Groupe Péda.</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="delete_data" value="2">
                                    <label class="form-check-label" for="">Professeur</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="delete_data" value="3">
                                    <label class="form-check-label" for="">Groupe Péda. et professeur</label>
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

            // show delete modal
            $(".show-delete-modal").on("click", function() {  
                $("#libelle_matiere").val($(this).attr("data-libelle-matiere"));
                $("#gp_id").val($(this).attr("data-gp"));
                $("#matiere_delete_id").val($(this).attr("data-matiere"));
                $("#prof_sup_id").val($("#prof_delete_id").val())
                $('#modalDeleteMatiere').modal('show')
            });

            // show modal
            $(".show-modal").on("click", function() {
                $('#modalMatiere').modal('show')
            });

        });
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
        });
    </script>
@endsection

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
                <li class="breadcrumb-item active">Generer Notes</li>
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
                                            <optgroup label="Valeur par defaut">
                                                @if ($update)
                                            <option selected value="{{ $get_gp->id }}">{{ $get_gp->getCycle->libelle }}
                                                {{ $get_gp->getPole->libelle }} {{ $get_gp->getFiliere->libelle }}
                                                    {{ $get_gp->libelle_classe }} {{ $get_gp->libelle_secondaire }}
                                                </option>
                                            @else
                                            <option value="">--- Choisissez une valeur ---</option>
                                            </optgroup>
                                            @endif
                                            <optgroup label="liste disponible">
                                                @foreach ($gp as $item)
                                                    <option value="{{ $item->id }}">{{ $item->getCycle->libelle }}
                                                        {{ $item->getPole->libelle }} {{ $item->getFiliere->libelle }}
                                                        {{ $item->libelle_classe }} {{ $item->libelle_secondaire }}</option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="label fw-bold">Bulletin</label>
                                        <select name="bulletin" id="bulletin" class="form-select">
                                            <optgroup label="Valeur par defaut">
                                                @if ($update)
                                            <option selected value="{{ $get_bulletin->code }}">{{ $get_bulletin->code }} {{ $get_bulletin->libelle_primaire }} {{ $item->annee }}</option>
                                            @else
                                                <option value="">--- Choisissez une valeur ---</option>
                                            @endif
                                            </optgroup>

                                            <optgroup label="Liste disponible">
                                                @foreach ($bulletins as $item)
                                                <option value="{{ $item->code }}">{{ $item->code }}
                                                    {{ $item->libelle_primaire }} {{ $item->annee }}</option>
                                            @endforeach
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">

                                    <div class="form-group">
                                        <label for="label fw-bold">Action</label><br>
                                        <input type="submit" name="afficher" value="Afficher"
                                               class="btn btn-primary btn-sm">
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
                                Bulletin : {{ $get_bulletin->code_bulletin }} {{ $get_bulletin->libelle_primaire }} {{ $get_bulletin->annee }}
                            @else

                                Classe................ Bulletin ................

                            @endif
                        </h5>
                        <!-- Bordered Table --> 
                        <div class="table-responsive">
                            <form action="{{ route('bulletins.save-note') }}" method="post">
                                @csrf
                                @method("post")
                                @if ($update == true)
                                    <input type="hidden" name="classe" value="{{ $get_gp->id }}">
                                    <input type="hidden" name="bulletin" value="{{ $get_bulletin->code }}">
                                    <button style="float: right" type="submit"
                                            class="btn btn-warning btn-sm text-white mb-2" name="valider_appreciation">
                                        Valider appreciation
                                    </button>&nbsp;&nbsp;
                                    <button style="float: right;margin-left: 2px; margin-right:2px;" type="submit"
                                            class="btn btn-success btn-sm text-white mb-2" name="valider_appreciation">
                                        Transmission par mail
                                    </button>&nbsp;&nbsp;
                                    <a style="margin-left: 2px; margin-right:2px;" target="_blank" href="{{route('bulletins.impression_masse',['codeBulletin'=>$get_bulletin->code,'gp'=>$get_gp->id])}}" style="float: right" type="submit"
                                            class="btn btn-dark btn-sm text-white mb-2" name="impression_masse">
                                        Impression en masse
                                </a> &nbsp;&nbsp;
                                @endif
                                <table id="tableHead"
                                       class="table table-striped table-hover table-bordered data-tables">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        {{--<th> 
                                            <input type="checkbox" class="form-check-input" id="cocher"
                                                onClick="updateCheckbox(this.checked);"> Cocher 
                                            </th> --}}
                                        <th scope="col">Matricule</th>
                                        <th scope="col">Nom</th>
                                        <th scope="col">Prenoms</th>
                                        <th scope="col">Rang</th>
                                        <th scope="col">Moyenne</th>
                                        <th scope="col">Appreciation 1</th>
                                        <th scope="col">Appreciation 2</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if ($update == true)

                                        @php
                                            $i=1;
                                        @endphp
                                        @foreach ($liste_moyennes as $datas)
                                            <tr>
                                                <td><b>{{ $i++ }}</b></td>
                                               
                                                    {{-- <td>
                                                    <input type='checkbox' name="send_bulletin[]" value="{{$datas->id}}" class='form-check-input multiple_send'>
                                                 
                                                </td>--}}
                                                <td>{{ $datas->etudiant_id ? $datas->getEtudiant->matricule : '' }}</td>
                                                <td>{{ $datas->etudiant_id ? $datas->getEtudiant->getDossier->getPersonne->nom : '' }}</td>
                                                <td>{{ $datas->etudiant_id ? $datas->getEtudiant->getDossier->getPersonne->prenoms : '' }}</td>
                                                <td>
                                                    @if ($loop->first)
                                                        {{$datas->rang}} er
                                                    @else

                                                        @if ($liste_moyennes[$loop->index - 1]->rang == $datas->rang)
                                                            {{$datas->rang}} ex
                                                        @else
                                                            {{$datas->rang}} eme
                                                        @endif

                                                    @endif
                                                </td>
                                                <td>{{ $datas->moyenne ? $datas->moyenne : 0 }}</td>
                                                <td>
                                                    <input type="hidden" name="bulletin_id[]" value="{{$datas->id}}"
                                                           required>
                                                    <input type="text" name="appreciation_fr[]"
                                                           value="{{$datas->appreciation_fr}}" id=""
                                                           class="form-control">
                                                </td>
                                                <td>
                                                    <input type="text" name="appreciation_en[]"
                                                           value="{{$datas->appreciation_en}}" id=""
                                                           class="form-control">
                                                </td>
                                                <td>
                                                    <a target="_blank"
                                                       href="{{ route('show-bulletin', ['id' => \Crypt::encrypt($datas->etudiant_id), 'codeBulletin'=>$datas->code_bulletin]) }}"
                                                       title="Bulletin">
                                                        <button type="button"
                                                                class="btn btn-sm btn-danger"><i
                                                                class="bi bi-file-earmark-pdf text-white"
                                                                style="color: white" aria-hidden="true"></i></button>
                                                    </a>

                                                    <a target="_blank"
                                                       href="{{ route('show-bulletinSynthese', ['id' => \Crypt::encrypt($datas->etudiant_id), 'codeBulletin'=>$datas->code_bulletin]) }}"
                                                       title="Bulletin synthèse">
                                                        <button type="button"
                                                                class="btn btn-sm btn-secondary"><i
                                                                class="bi bi-file-earmark-pdf text-white"
                                                                style="color: white" aria-hidden="true"></i></button>
                                                    </a>

                                                    <a href="#" title="Consultation des notes"
                                                       data-etudiant="{{ $datas->etudiant_id }}"
                                                       data-etudiant_name="{{ $datas->getEtudiant->matricule }} || {{$datas->getEtudiant->getDossier->getPersonne->nom}}  {{$datas->getEtudiant->getDossier->getPersonne->prenoms}} "
                                                       data-gp="{{ $get_gp->id }}"
                                                       data-bulletin="{{ $datas->code_bulletin }}" class="show-modal">
                                                        <button type="button" class="btn btn-sm btn-primary"><i
                                                                class="bi bi-list" style="color: white"
                                                                aria-hidden="true"></i></button>
                                                    </a>

                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </form>


                        </div>
                        <!-- End Bordered Table -->


                        <!-- modal consultation bulletin-->

                        <div class="modal fade" id="modalConsultationNote" data-bs-backdrop="static"
                             data-bs-keyboard="false" tabindex="-1"
                             aria-labelledby="modalematiere" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary w-100 text-center text-white">
                                        <h5 class="modal-title text-white" id="modalDelete">Liste des notes de :
                                            <b id="afficher_etudiant"></b></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <section id="table-note">

                                                </section>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer
                                        </button>
                                        <button type="submit" id="valider" class="btn btn-primary">Valider</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- end modal consultation bulletin -->


                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

<!-- jsScript -->
@section('script-js')
    <script>
        $(document).ready(function () {
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
                fermer: function () {

                }
            });

            $('a.confirmation-desactivation').confirm({
                buttons: {
                    hey: function () {
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
                fermer: function () {

                }
            });
            $('a.confirmation-activation').confirm({
                buttons: {
                    hey: function () {
                        location.href = this.$target.attr('href');
                    }
                }
            });

            // show modal
            $(".show-modal").on("click", function () {
                // get all data
                var etudiant_id = $(this).attr("data-etudiant");
                var groupe_pedagogique = $(this).attr("data-gp");
                var code_bulletin = $(this).attr("data-bulletin");
                //
                $.ajax({
                    url: "{{ route('ajax_requete') }}",
                    data: {
                        consultation_note: "ok",
                        etudiant_id: etudiant_id,
                        groupe_pedagogique: groupe_pedagogique,
                        code_bulletin: code_bulletin,
                        _token: '{{csrf_token()}}'
                    },
                    type: 'POST',
                    dataType: 'json',
                    success: function (data, status) {
                        //console.log(data);

                        $("#table-note").html(data)
                        /*jQuery.each(data, function(key, value) {
                            $('#filiere_id').append('<option value="' + value.id + '">' + value.libelle + '</option>');
                        });*/
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        alert('Veuillez renseigner tous les champs.');
                        console.log(xhr);
                        console.log(textStatus);
                        console.log(errorThrown);
                    }
                });
                $("#afficher_etudiant").text($(this).attr("data-etudiant_name"))
                $('#modalConsultationNote').modal('show')
            });

            // show delete modal
            $(".show-delete-modal").on("click", function () {
                $("#libelle_matiere").val($(this).attr("data-libelle-matiere"));
                $("#gp_id").val($(this).attr("data-gp"));
                $("#matiere_delete_id").val($(this).attr("data-matiere"));
                $("#prof_sup_id").val($(this).attr("data-prof-id"))
                $('#modalDeleteMatiere').modal('show')
            });


        });

        function updateCheckbox(isChecked) {

if (isChecked) {
    $.each($('.multiple_send'), function() {
        $(this).prop('checked', true);
    });
} else {
    $.each($('.multiple_send'), function() {
        $(this).prop('checked', false);
    });

}
}
    </script>
@endsection

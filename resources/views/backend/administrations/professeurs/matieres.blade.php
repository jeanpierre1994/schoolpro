@extends('backend/include/layout')
<!-- title -->
@section('title')
    Professeurs Matière || {{ env('APP_NAME') }}
@endsection

@section('fil-arial')
    <div class="pagetitle">
        <h1>Paramètres</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" style="text-decoration: none;">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.parametres') }}"
                        style="text-decoration: none;">Paramètres</a></li>
                <li class="breadcrumb-item active">Professeurs Matière</li>
            </ol>
        </nav>
    </div>
@endsection

@section('contenu')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
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
                    <div class="card-body">
                        <h5 class="card-title">Liste des matières par professeur</h5>
                        <!-- Bordered Table -->
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-bordered data-tables">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nom</th>
                                        <th scope="col">Prénoms</th>
                                        <th scope="col">Téléphone</th>
                                        <th scope="col">E-mail</th>
                                        <th scope="col">Matières</th>
                                        <th scope="col">Date modification</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($professeurs as $item)
                                        <tr>
                                            <td class="text-center"><b>{{ $i++ }}</b></td>
                                            <td>{{ $item->nom }}</td>
                                            <td>{{ $item->prenoms }}</td>
                                            <td>{{ $item->tel }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>
                                                @foreach (getMatiereProf($item->id) as $data)
                                                @if ($loop->last)
                                                    <span class="badge bg-primary">{{$data->libelle_classe}} : {{$data->libelle}}</span>
                                                @else
                                                    <span class="badge bg-primary">{{$data->libelle_classe}} : {{$data->libelle}}</span> &nbsp;
                                                @endif
                                                @endforeach
                                                
                                            </td>
                                            <td>{{ $item->updated_at->format('d-m-Y à H:i:s') }}</td>
                                            <td class="text-center">
                                                <a href="#" class="show-modal" data-reference="{{ $item }}"
                                                    title="Ajouter matière"><button style="font-size: 5px;" type="button"
                                                        class="btn btn-sm btn-outline-primary"><i class="bi bi-plus-circle"
                                                            aria-hidden="true" style="font-size: 10px;"></i></button></a>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <!-- End Bordered Table -->

                        <!-- modal -->

                        <div class="modal fade" id="modalMatiere" data-bs-backdrop="static" data-bs-keyboard="false"
                            tabindex="-1" aria-labelledby="modalematiere" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary w-100 text-center text-white">
                                        <h5 class="modal-title text-white" id="modalDelete">Ajouter matière</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form id="form" action="{{ route('professeurs.store-matiere') }}" method="post">
                                        @csrf

                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="form-group col-md-6 ">
                                                    <label for="label">Nom <i class="text-danger">*</i></label>
                                                    <input type="text" readonly name="nom" id="nom"
                                                        class="form-control" required>
                                                </div>
                                                <div class="form-group col-md-6 ">
                                                    <label for="label">Prénoms <i class="text-danger">*</i></label>
                                                    <input type="text" readonly name="prenoms" id="prenoms"
                                                        class="form-control" required>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="label">Groupe Péda. <i class="text-danger">*</i></label>
                                                    <select class="form-select" name="gp_id" id="gp_id" required>
                                                        <option selected value="">Sélectionnez une option</option>
                                                        @foreach ($groupepedagogiques as $item)
                                                            <option value="{{ $item->id }}">{{$item->getFiliere->libelle}} {{$item->libelle_classe}} {{ $item->libelle_secondaire }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-12 ">
                                                    <label for="label">Matière <i class="text-danger">*</i></label>
                                                    <select class="form-select" name="matiere_id" id="matiere_id" required>
                                                        <option selected value=""></option>
                                                    </select>
                                                </div>
                                                <input type="hidden" name="professeur_id" id="professeur_id" value="" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Fermer</button>
                                            <button type="submit" id="valider" class="btn btn-primary">Valider</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- end modal export -->


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

            // show modal
            $(".show-modal").on("click", function() {
                // convert data to json object
                var data = $.parseJSON($(this).attr("data-reference"));
                //cleane form attribute 
                $("#matiere_id").val("")
                $("#professeur_id").val("")
                $("#nom").val("")
                $("#prenoms").val("")
                $("#gp_id").val("") 
              // set data 
                    $("#professeur_id").val(data.id) 
                    $("#nom").val(data.nom)
                    $("#prenoms").val(data.prenoms)                 
                    $('#modalMatiere').modal('show')
            });

        // gestion de la sélection des matières

// si changement de filière, il faut charger la liste des niveau associées si cycle existe
$('#gp_id').on('change', function() { 
var gp_id = parseInt($('#gp_id').val());  
var professeur_id = parseInt($('#professeur_id').val());  
if ( gp_id != "" && professeur_id != "") { 
    $('#matiere_id').empty();
    $('#matiere_id').append('<option value="" selected="selected">Choisissez la matière</option>');
    $.ajax({
        url: "{{ route('ajax_requete') }}",
        data: {
          get_matiere: "ok", 
          professeur_id: professeur_id, 
          gp_id: gp_id,
            _token: '{{csrf_token()}}'
        },
        type: 'POST',
        dataType: 'json',
        success: function(data, status) { 
            console.log(data)
            jQuery.each(data, function(key, value) {
                $('#matiere_id').append('<option value="' + value.id + '">' + value.libelle + '</option>');
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
    </script>
@endsection

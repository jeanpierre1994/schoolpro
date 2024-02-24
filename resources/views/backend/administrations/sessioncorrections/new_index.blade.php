@extends('backend/include/layout')
<!-- title -->
@section('title')
   Session correction || {{ env('APP_NAME') }}
@endsection

@section('fil-arial')
    <div class="pagetitle">
        <h1>Paramètres</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" style="text-decoration: none;">Accueil</a></li> 
                <li class="breadcrumb-item active">Session correction </li>
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
                        <form action="{{ route('sessionscorrections.new-index')}}" method="post">

                            @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="label fw-bold">Examen <i class="text-danger">*</i></label>
                                    <select name="examen" id="examen" class="form-select" required>
                                        <option value="">--- Choisissez une valeur ---</option>
                                        @foreach ($examens as $item)
                                            <option value="{{$item->id}}">{{$item->code_examen}} {{$item->libelle}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="label fw-bold">Classe <i class="text-danger">*</i></label>
                                    <select name="classe" id="classe" class="form-select" required>
                                        <option value="">--- Choisissez une valeur ---</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="label fw-bold">Matiere <i class="text-danger">*</i></label>
                                    <select name="matiere" id="matiere" class="form-select" required>
                                        <option value="">--- Choisissez une valeur ---</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                
                            <div class="form-group">
                                    <label for="label fw-bold">Action</label><br>
                                    <button type="submit" class="btn btn-secondary btn-sm">Saisir les notes</button>
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
                        @if ($send_form)
                        <div class="card-titlex"><b>Saisir des notes Examen :</b> {{$get_examen->code_examen}} {{$get_examen->libelle}} <br> 
                            <b>Classe :</b> {{$session->getExamenprog->getMatiere->getGp->getPole->libelle}} {{$session->getExamenprog->getMatiere->getGp->getFiliere->libelle}} {{$session->getExamenprog->getMatiere->getGp->libelle_classe}} {{$session->getExamenprog->getMatiere->getGp->libelle_secondaire}} <br> 
                            <b>Matiere :</b> {{$session->getExamenprog->getMatiere->libelle}}</div> <br>
                        @endif
                        <form action="{{route("sessionscorrections.note_store")}}" method="POST">
                            @csrf
                            
                @if ($send_form)
                <input type="hidden" value="{{$session->getExamenprog->getExamen->id}}" name="examen_id">
                <input type="hidden" value="{{$session->getExamenprog->id}}" name="examenprog_id">
                <input type="hidden" value="{{$session->getExamenprog->getMatiere->getGp->id}}" name="gp_id">
                @endif
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-bordered data-tables">
                                <thead>
                                    <tr class="text-center">
                                        <th scope="col">Matricule</th>
                                        <th scope="col">Nom</th>
                                        <th scope="col">Prénoms</th> 
                                        <th scope="col">Note</th> 
                                        <th scope="col"><button type="submit" class="btn btn-primary btn-sm" title="Validation en max"><i class="bi bi-check text-white"></i> Validation Note</button></th>  
                                     </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @if ($send_form)
                                    @foreach ($notes_etudiants_encours as $data)
                                    <tr> 
                                        <td>{{ $data->etudiant_id ?  $data->getEtudiant->matricule : ''}}</td>
                                        <td>{{ $data->etudiant_id ?  $data->getEtudiant->getDossier->getPersonne->nom : '' }}</td>
                                        <td>{{ $data->etudiant_id ?  $data->getEtudiant->getDossier->getPersonne->prenoms : '' }}</td>
                                        <td>
                                            <input type="number" step=".01" name="note[]" value="{{$data->note}}" class="form-control">
                                            <input type="hidden" name="note_id[]" value="{{$data->id}}">
                                            <input type="hidden" value="{{ $data->etudiant_id ?  $data->getEtudiant->id : ''}}" name="etudiant_id[]">
                                        </td>   
                                        <td><input type="text" name="commentaire[]" class="form-control" value="{{$data->commentaire}}"></td> 
                                    </tr>
                                @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </form>
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

            
// change examen
$('#examen').on('change', function() { 
var examen = parseInt($('#examen').val()); 
    $('#classe').empty();
    $('#classe').append('<option value="" selected="selected">Choisissez une option</option>');
    $('#matiere').empty();
    $('#matiere').append('<option value="" selected="selected">Choisissez une option</option>');
if (examen != "") {
    $.ajax({
        url: "{{ route('ajax_requete') }}",
        data: {
          change_examen: examen,
            _token: '{{csrf_token()}}'
        },
        type: 'POST',
        dataType: 'json',
        success: function(data, status) { 
            jQuery.each(data, function(key, value) {
                $('#classe').append('<option value="' + value.id + '">' + value.pole + ' '+ value.filiere + ' '+ value.libelle_classe+ ' '+ value.libelle_secondaire + '</option>');
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


// change classe
$('#classe').on('change', function() { 
var examen = parseInt($('#examen').val());  
var classe = parseInt($('#classe').val());  
    $('#matiere').empty();
    $('#matiere').append('<option value="" selected="selected">Choisissez une option</option>');
if (examen != "" && classe != "") {
    $.ajax({
        url: "{{ route('ajax_requete') }}",
        data: {
          change_classe: classe,
          examen: examen,
            _token: '{{csrf_token()}}'
        },
        type: 'POST',
        dataType: 'json',
        success: function(data, status) { 
            jQuery.each(data, function(key, value) {
                $('#matiere').append('<option value="' + value.id + '">' + value.matiere + '</option>');
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

@extends('backend/include/layout')
<!-- title -->
@section('title')
Ouverture Session de correction || {{ env('APP_NAME') }}
@endsection

@section('fil-arial')
    <div class="pagetitle">
        <h1>Paramètres</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" style="text-decoration: none;">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.parametres') }}" style="text-decoration: none;">Paramètres</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.anc_sessioncorrections') }}" style="text-decoration: none;">Session de correction</a></li>
                <li class="breadcrumb-item active">Ouverture session de correction</li>
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
                        <div class="card-body row mb-2" style="border-bottom: 2px #e0adad solid;">
                            <div class="col-md-12 mb-2">Groupe péda. : <b>{{$session->getExamenprog->getMatiere->getGp->getPole->libelle}} {{$session->getExamenprog->getMatiere->getGp->getFiliere->libelle}} {{$session->getExamenprog->getMatiere->getGp->libelle_classe}} {{$session->getExamenprog->getMatiere->getGp->libelle_secondaire}}</b> </div>
                            <div class="col-md-12 mb-2">Session de correction d'examen N° <b>{{$session->getExamenprog->getExamen->code_examen}} || {{$session->getExamenprog->getExamen->libelle}}</b> </div>
                            <div class="col-md-12 mb-2">Epreuve de : <b>{{$session->getExamenprog->getMatiere->libelle}}</b> </div>
                            <div class="col-md-12 mb-2">Nbre d'étudiants notés : <b>{{$notes_etudiants_valide}}</b> 
                                @if ($notes_etudiants_valide > 0)
                                <a href="{{route("sessionscorrections.liste",['id'=>$session->getExamenprog->id,'id_gp'=>$session->getExamenprog->getMatiere->getGp->id])}}"><span class="badge bg-primary p-1">consulter la liste</span></a>
                                @endif
                            </div>
                            <div class="col-md-12">Statut de la session : 
                                @if ($session->statutvalidation_id == 1)
                                <span class="badge bg-warning">{{$session->getStatut->libelle}}</span>
                                @else
                                    <span class="badge bg-success">{{$session->getStatut->libelle}}</span>
                                @endif 
                            </div>
                        </div>
                        <h5 class="card-title">Interface d'édition des notes</h5>
                        <!-- Bordered Table -->
                        <form action="{{route("sessionscorrections.anc_store")}}" method="POST">
                            @csrf
                            
                
                <input type="hidden" value="{{$session->getExamenprog->getExamen->id}}" name="examen_id">
                <input type="hidden" value="{{$session->getExamenprog->id}}" name="examenprog_id">
                <input type="hidden" value="{{$session->getExamenprog->getMatiere->getGp->id}}" name="gp_id">
                
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

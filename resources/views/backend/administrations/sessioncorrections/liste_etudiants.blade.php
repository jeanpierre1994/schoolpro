@extends('backend/include/layout')
<!-- title -->
@section('title')
Liste des notes || {{ env('APP_NAME') }}
@endsection

@section('fil-arial')
    <div class="pagetitle">
        <h1>Paramètres</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" style="text-decoration: none;">Accueil</a></li> 
                <li class="breadcrumb-item"><a href="{{ url()->previous() }}" style="text-decoration: none;">Retour</a></li>
                <li class="breadcrumb-item active">Liste des notes</li>
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
                        <h5 class="card-title">Groupe péda. : <b>{{$session->getExamenprog->getMatiere->getGp->getPole->libelle}} {{$session->getExamenprog->getMatiere->getGp->getFiliere->libelle}} {{$session->getExamenprog->getMatiere->getGp->libelle_classe}} {{$session->getExamenprog->getMatiere->getGp->libelle_secondaire}}</b> <br> <br>
                        Session de correction d'examen N° <b>{{$session->getExamenprog->getExamen->code_examen}} || {{$session->getExamenprog->getExamen->libelle}}</b> <br>
                        <br>Epreuve de : <b>{{$session->getExamenprog->getMatiere->libelle}}</b> <br>
                        <br> <code>Liste des notes</code>
                    </h5>  
                        <!-- Bordered Table -->
                        <form action="{{route("sessionscorrections.store")}}" method="POST">
                            @csrf
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-bordered data-tables">
                                <thead>
                                    <tr class="text-center">
                                        <th scope="col">Matricule</th>
                                        <th scope="col">Nom</th>
                                        <th scope="col">Prénoms</th> 
                                        <th scope="col">Note</th>    
                                        <th scope="col">Commentaire</th>    
                                     </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($notes as $data)
                                        <tr> 
                                            <td class="text-center">{{ $data->etudiant_id ?  $data->getEtudiant->matricule : ''}}</td>
                                            <td class="text-center">{{ $data->etudiant_id ?  $data->getEtudiant->getDossier->getPersonne->nom : '' }}</td>
                                            <td class="text-center">{{ $data->etudiant_id ?  $data->getEtudiant->getDossier->getPersonne->prenoms : '' }}</td>
                                            <td class="text-center">{{$data->note}}</td>  
                                            <td class="text-center">{{$data->commentaire}}</td>  
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

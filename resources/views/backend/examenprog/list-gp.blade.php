
@extends('backend/include/layout')
<!-- title -->
@section('title') Examens Prog Groupe Pédagogique || {{env('APP_NAME')}} @endsection

@section('fil-arial')
<div class="pagetitle">
    <h1>Paramètres</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#" style="text-decoration: none;">Accueil</a></li>
        <li class="breadcrumb-item"><a href="{{route('admin.parametres')}}" style="text-decoration: none;">Paramètres</a></li>
        <li class="breadcrumb-item"><a href="{{route('examens.index')}}" style="text-decoration: none;">Examens</a></li>
        <li class="breadcrumb-item active">Examens Prog - Groupe pédagogique</li>
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
      <h5 class="card-title">Liste des groupes pédagogiques</h5>
      <!-- Bordered Table -->
      <div class="table-responsive">
      <table class="table table-striped table-hover table-bordered data-tables">
        <thead>
          <tr>
            <th scope="col">#</th> 
            <th scope="col">Site</th>
            <th scope="col">Cycle</th>
            <th scope="col">Niveau</th>
            <th scope="col">Pôle</th>
            <th scope="col">Filière</th>
            <th scope="col">Libelle</th>
            <th scope="col">Libelle 2</th> 
            <th scope="col">Action</th> 
          </tr>
        </thead>
        <tbody>
          @php
              $i = 1;
          @endphp
          @foreach ($listeGP as $item )
          <tr>
              <td class="text-center"><b>{{$i++}}</b></td> 
              <td>
                  <p class="fw-normal mb-1">{{$item->getSite->getEtablissement->sigle}}</p>
                  <p class="text-muted mb-0">Site : {{$item->getSite->sigle}}</p>
              </td>
              <td>{{$item->getCycle->libelle}}</td>
              <td>{{$item->getNiveau->libelle}}</td>
              <td>
                  {{$item->getPole->libelle}}
              </td>
              <td>{{$item->getFiliere->libelle}}</td>
              <td>{{ $item->libelle_classe }}</td>
              <td>{{ $item->libelle_secondaire }}</td> 
              <td class="text-center">
                <a href="{{ route('examenprog.matiere-gp',['id' => $examen->id,'gp_id' => $item->id]) }}" title="Liste matière"><button type="button" class="btn btn-sm btn-warning"><i class="bi bi-list" style="color: white" aria-hidden="true"></i></button></a>
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
    content:
    "<div style='border-bottom: 1px solid #ddd;' class='text-center'><img width='100px' src='{{ asset('front-design/images/logo-white.svg') }}' alt='logo'></div> <br> "+
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
        hey: function(){
            location.href = this.$target.attr('href');
        }
    }
});

// activation
$('a.confirmation-activation').confirm({
    title: "",
    content:
    "<div style='border-bottom: 1px solid #ddd;' class='text-center'>Attention!</div> <br> "+
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
        hey: function(){
            location.href = this.$target.attr('href');
        }
    }
});

  // show modal
  $(".show-modal").on("click", function() { 
      $('#modalMatiere').modal('show')
  }); 



	// gestion des dates
$("#valider").prop("disabled",true);
if($("#date_fin").val() != "" && $("#date_fin").val() != ""){
	$("#valider").prop("disabled",false);
}else{
	$("#valider").prop("disabled",true);
}

$("#date_debut").on("change", function(){ 
   let date_debut = $(this).val();
   let date_fin = $("#date_fin").val(); 
   if(date_fin != ""){
    if (date_debut > date_fin) {
      $("#valider").prop("disabled",true); 

      $.dialog({
                    title: "",
                    content: "<div style='border-bottom: 1px solid #ddd;' class='text-center'>Attention!</div> <br> " +
                        "<div class='text-center'><p class='text-danger'>La date début ne doit pas être supérieur à la date de fin</p></div>",
                    type: 'red',
                    typeAnimated: true,
                    draggable: true,
                    dragWindowBorder: false,
                    buttons: {
                        aRandomButton: function () {
                            // this will be removed.
                        }
                    }
                });
     } else {
      //alert("date début inférieur");
      $("#valider").prop("disabled",false);
    }
   }
     
  });


$("#date_fin").on("change", function(){ 
   let date_debut = $("#date_debut").val();
   let date_fin = $(this).val(); 
  
   if(date_debut != ""){
    if (date_fin < date_debut) {
      
      $("#valider").prop("disabled",true); 
      $.dialog({
                    title: "",
                    content: "<div style='border-bottom: 1px solid #ddd;' class='text-center'><img width='100px' src='{{ asset('logo.jpeg') }}' alt='logo'></div> <br> " +
                        "<div class='text-center'><p class='text-danger'>date de fin ne doit pas être supérieur à la date de début</p></div>",
                    type: 'red',
                    typeAnimated: true,
                    draggable: true,
                    dragWindowBorder: false,
                    buttons: {
                        aRandomButton: function () {
                            // this will be removed.
                        }
                    }
                });
     } else {
      //alert("date fin inférieur"); 
      $("#valider").prop("disabled",false);
    }
   }
     
  });

 
  } );
</script>
@endsection

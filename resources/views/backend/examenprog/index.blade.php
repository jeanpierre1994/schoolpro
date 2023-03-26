
@extends('backend/include/layout')
<!-- title -->
@section('title') Examens Prog || {{env('APP_NAME')}} @endsection

@section('fil-arial')
<div class="pagetitle">
    <h1>Paramètres</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#" style="text-decoration: none;">Accueil</a></li>
        <li class="breadcrumb-item"><a href="{{route('admin.parametres')}}" style="text-decoration: none;">Paramètres</a></li>
        <li class="breadcrumb-item"><a href="{{route('examens.index')}}" style="text-decoration: none;">Examens</a></li>
        <li class="breadcrumb-item active">Examens Prog</li>
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
      <h5 class="card-title">Liste des matières de l'examen N° {{$examen->code_examen}} <a href="#" class="show-modal" title="Ajouter"><button style="font-size: 5px;" type="button" class="btn btn-sm btn-outline-primary"><i class="bi bi-plus-circle" aria-hidden="true" style="font-size: 10px;"></i></button></a></h5>
      <!-- Bordered Table -->
      <div class="table-responsive">
      <table class="table table-striped table-hover table-bordered data-tables">
        <thead>
          <tr>
            <th scope="col">#</th> 
            <th scope="col">Matière</th> 
            <th scope="col">Date début</th> 
            <th scope="col">Date fin</th> 
            <th scope="col">Année académique</th> 
            <th scope="col">Commentaire</th>  
          </tr>
        </thead>
        <tbody>
          @php
              $i = 1;
          @endphp
          @foreach ($examenprog as $item )
          <tr>
              <td class="text-center"><b>{{$i++}}</b></td> 
              <td>{{$item->matiere_id ? $item->getMatiere->libelle : ''}}</td> 
              <td>{{$item->date_debut}}</td> 
              <td>{{$item->date_fin}}</td> 
              <td>{{$item->getExamen->annee_academique}}</td>  
              <td>{{$item->commentaire}}</td> 
              {{--<td class="text-center">
                <a href="{{ route('examens.edit',$item->id) }}" title="Modifier"><button type="button" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square" style="color: white" aria-hidden="true"></i></button></a>
             </td>--}}
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
                         <form id="form" action="{{route('examenprog.store')}}" method="post">
                             @csrf 

                             <div class="modal-body">
                              <div class="row">
                                  <div class="form-group col-md-12 ">
                                      <label for="label">Matière <i class="text-danger">*</i></label>
                                      <select class="form-select" name="matiere_id" id="matiere_id" required>
                                        <option selected value="">Sélectionnez une option</option>
                                        @foreach ($matieres as $item)
                                        @if (checkMatiere($item->id,$examen->id))
                                        <option value="{{$item->id}}">{{$item->libelle}}</option> 
                                        @endif 
                                        @endforeach
                                      </select>
                                  </div> 
                                     <div class="form-group col-md-6 ">
                                         <label for="label">Date début <i class="text-danger">*</i></label>
                                         <input type="datetime-local" name="date_debut" id="date_debut" class="form-control" required>
                                     </div>
                                     <div class="form-group col-md-6 ">
                                         <label for="label">Date fin <i class="text-danger">*</i></label>
                                         <input type="datetime-local" name="date_fin" id="date_fin" class="form-control" required>
                                     </div>
                                     <div class="form-group col-md-12 ">
                                         <label for="label">Commentaire <i class="text-danger">*</i></label>
                                         <input type="text" name="commentaire" id="commentaire" class="form-control" required>
                                     </div>
                                     <input type="hidden" name="examen_id" value="{{$examen->id}}">
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

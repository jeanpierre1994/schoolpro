
@extends('backend/include/layout')
<!-- title -->
@section('title') Enregistrement Examen|| {{env('APP_NAME')}} @endsection

@section('fil-arial') 
<div class="pagetitle">
    <h1>Paramètres</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#" style="text-decoration: none;">Accueil</a></li>
        <li class="breadcrumb-item"><a href="{{route('admin.parametres')}}" style="text-decoration: none;">Paramètres</a></li>
        <li class="breadcrumb-item"><a href="{{route('examens.index')}}" style="text-decoration: none;">Examens</a> </li>
        <li class="breadcrumb-item active">Enregistrement </li>
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
        <h5 class="card-title">Enregistrement</h5>
          <!-- General Form Elements -->
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
          <form action="{{ route('examens.store') }}" method="post">
            @csrf
            <div class="row mb-3"> 
            {{--  <div class="col-md-6">
                <label for="inputText" class=" col-form-label">Groupe pédagogique<i class="text-danger">*</i></label>
                <div> 
                    <select class="form-select" name="gp_id" id="gp_id" required>
                      <option selected value="">Sélectionnez une option</option>
                      @foreach ($gp as $item)
                      <option value="{{$item->id}}">{{$item->libelle_classe}}</option> 
                      @endforeach
                    </select> 
                </div>
              </div>  --}}
              <div class="col-md-6">
                <label for="inputText" class=" col-form-label">Type examen<i class="text-danger">*</i></label>
                <div> 
                    <select class="form-select" name="examentype_id" id="examentype_id" required>
                      <option selected value="">Sélectionnez une option</option>
                      @foreach ($examentypes as $item)
                      <option value="{{$item->id}}">{{$item->libelle}}</option> 
                      @endforeach
                    </select> 
                </div>
              </div> 
              
              <div class="col-md-6">
                <label for="inputText" class=" col-form-label">Libellé <i class="text-danger">*</i></label>
                <div>
                  <input type="text" class="form-control" required name="libelle" id="libelle" minlength="1" maxlength="100" >
                </div>
              </div>  
            </div>
            <div class="row mb-3">   
              <div class="col-md-6">
                <label for="inputText" class=" col-form-label">Démarre le <i class="text-danger">*</i></label>
                <div>
                  <input type="date" class="form-control" required name="date_debut" id="date_debut">
                </div>
              </div>
              <div class="col-md-6">
              <label for="inputText" class=" col-form-label">Finit le <i class="text-danger">*</i></label>
                <div>
                  <input type="date" class="form-control" required name="date_fin" id="date_fin">
                </div>  
              </div>
            </div> 
            <div class="row mb-3"> 
              <div class="col-md-6 mb-1">
                  <label for="nom" class="form-label float-left"><b>Pôle <i class="text-danger"></i></b></label> 
                  <select class="browser-default custom-select" name="pole_id" id="pole_id" >
                    <option value="" selected>Choisissez le pôle</option>  
                        @foreach ($poles as $item)
                          <option value="{{$item->id}}">{{$item->libelle}}</option>
                        @endforeach
                  </select>                         
              </div>
              <div class="col-md-6 mb-1">
                  <label for="nom" class="form-label float-left"><b>Filière <i class="text-danger"></i></b></label> 
                  <select class="browser-default custom-select" name="filiere_id" id="filiere_id" >
                    <option value="" selected></option>   
                  </select>                         
              </div>
            </div>
            <div class="row mb-3"> 
              <div class="col-md-6 mb-1">
                  <label for="cycle" class="form-label float-left"><b>Cycle <i class="text-danger"></i></b></label> 
                  <select class="browser-default custom-select" name="cycle_id" id="cycle_id" >
                    <option value="" selected></option>  
                        
                  </select>                         
              </div>
              <div class="col-md-6 mb-1">
                  <label for="niveau" class="form-label float-left"><b>Groupe Péda. <i class="text-danger"></i></b></label> 
                  <select class="browser-default custom-select" name="gp" id="gp">
                    <option value="" selected></option>   
                  </select>                         
              </div>
            </div>
 
            <div class="row mb-3">
              <div class="col-md-4">
              <label for="inputText" class=" col-form-label">Année académique <i class="text-danger">*</i></label>
                <div>
                  <input type="number" class="form-control" required name="annee_academique" id="annee_academique" value="{{date('Y')}}" min="0" max="9999" >
                </div>  
              </div> 
              <div class="col-md-4">
              <label for="inputText" class=" col-form-label">Note maximum <i class="text-danger">*</i></label>
                <div>
                  <input type="number" class="form-control" required name="note_max" value="20" id="note_max" min="0" max="100" >
                </div>  
              </div> 
              <div class="col-md-4">
              <label for="inputText" class=" col-form-label">Moyenne min <i class="text-danger">*</i></label>
                <div>
                  <input type="number" class="form-control" required name="min_moyenne" value="12" id="min_moyenne" min="0" max="100" >
                </div>  
              </div>  
              <div class="col-md-4">
              <label for="inputText" class=" col-form-label">Moyenne max <i class="text-danger">*</i></label>
                <div>
                  <input type="number" class="form-control" required name="max_moyenne" value="20" id="max_moyenne" min="0" max="100" >
                </div>  
              </div> 
              <div class="col-md-4">
              <label for="inputText" class=" col-form-label">Pondération<i class="text-danger">*</i></label>
                <div>
                  <input type="number" class="form-control" name="ponderation" id="ponderation" value="1" min="0" max="255" value="" required>
                </div>  
              </div> 
              <div class="col-md-4">
              <label for="inputText" class=" col-form-label">Commentaire<i class="text-danger"></i></label>
                <div>
                  <input type="text" class="form-control" name="commentaire" id="commentaire" minlength="0" maxlength="255" >
                </div>  
              </div> 
            </div>   
            <div class="row mb-3">  
                <div class="col-md-6">
                  <button type="submit" class="btn btn-primary">Enregistrer</button> 
                </div>
            </div> 
          </form><!-- End General Form Elements -->
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


      
// si changement de pôle, il faut charger la liste des filières associées
$('#pole_id').on('change', function() { 
var pole_id = parseInt($('#pole_id').val()); 

if (pole_id != "") {
    $('#filiere_id').empty(); 
    $('#cycle_id').empty();
    $('#gp').empty();
    $('#filiere_id').append('<option value="" selected="selected">Choisissez la filière</option>');
    $.ajax({
        url: "{{ route('ajax_requete') }}",
        data: {
          pole_change: "ok",
          pole_id: pole_id,
            _token: '{{csrf_token()}}'
        },
        type: 'POST',
        dataType: 'json',
        success: function(data, status) { 
            jQuery.each(data, function(key, value) {
                $('#filiere_id').append('<option value="' + value.id + '">' + value.libelle + '</option>');
            });
        },
        error: function(xhr, textStatus, errorThrown) {
             alert('Veuillez renseigner tous les champs'); 
            console.log(xhr); 
            console.log(textStatus);
            console.log(errorThrown);
        }
    });
}

});


// si changement de filière, il faut charger la liste des niveau associées si cycle existe
$('#filiere_id').on('change', function() { 
var filiere_id = parseInt($('#filiere_id').val()); 
//var cycle_id = parseInt($('#cycle_id').val()); 
if (filiere_id != "") { 
    $('#cycle_id').empty(); 
    $('#gp').empty();
    $('#cycle_id').append('<option value="" selected="selected">Choisissez le cycle</option>');
    $.ajax({
        url: "{{ route('ajax_requete') }}",
        data: {
          filiere_change: "ok",
          filiere_id: filiere_id, 
            _token: '{{csrf_token()}}'
        },
        type: 'POST',
        dataType: 'json',
        success: function(data, status) { 
            jQuery.each(data, function(key, value) {
                $('#cycle_id').append('<option value="' + value.id + '">' + value.libelle + '</option>');
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


// si changement de filière, il faut charger la liste des niveau associées si cycle existe
$('#cycle_id').on('change', function() { 
var cycle_id = parseInt($('#cycle_id').val()); 
var filiere_id = parseInt($('#filiere_id').val()); 
var pole_id = parseInt($('#pole_id').val()); 
if (filiere_id != "" && cycle_id != "" && pole_id != "") { 
    $('#gp').empty();
    $('#gp').append('<option value="" selected="selected">Choisissez le niveau</option>');
    $.ajax({
        url: "{{ route('ajax_requete') }}",
        data: {
          cycle_for_gp_change: "ok",
          filiere_id: filiere_id,
          pole_id: pole_id,
          cycle_id: cycle_id,
            _token: '{{csrf_token()}}'
        },
        type: 'POST',
        dataType: 'json',
        success: function(data, status) { 
            jQuery.each(data, function(key, value) {
                $('#gp').append('<option value="' + value.id + '">'+ value.pole + ' ' +value.filiere + ' '+value.cycle+' ' + value.libelle_classe + ' '+ value.libelle_secondaire+ '</option>');
            });
        },
        error: function(xhr, textStatus, errorThrown) {
              alert('Veuillez renseigner tous les champs'); 
            console.log(xhr); 
            console.log(textStatus);
            console.log(errorThrown);
        }
    });
}

});
 

    } );
</script> 
@endsection
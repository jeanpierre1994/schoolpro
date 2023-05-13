
@extends('backend/include/layout')
<!-- title -->
@section('title') Modification Niveau || {{env('APP_NAME')}} @endsection

@section('fil-arial') 
<div class="pagetitle">
    <h1>Paramètres</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#" style="text-decoration: none;">Accueil</a></li>
        <li class="breadcrumb-item"><a href="{{route('admin.parametres')}}" style="text-decoration: none;">Paramètres</a></li>
        <li class="breadcrumb-item"><a href="{{route('niveaux.index')}}" style="text-decoration: none;">Niveaux</a> </li>
        <li class="breadcrumb-item active">Modification </li>
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
        <h5 class="card-title">Modification</h5>
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
          <form action="{{ route('niveaux.update',$niveau->id) }}" method="post">
            @csrf
            @method("put")
            <div class="row mb-3">
              <label for="inputText" class="col-sm-2 col-form-label">Pôle <i class="text-danger">*</i></label>
              <div class="col-sm-10">
                <select class="browser-default custom-select" name="pole_id" id="pole_id" required>
                  <optgroup label="Valeur par défaut">
                    <option value="{{ $niveau->filiere_id ? $niveau->getFiliere->getPole->id : ''}}" selected>{{ $niveau->filiere_id ? $niveau->getFiliere->getPole->libelle : ''}}</option>
                  </optgroup> 
                  <optgroup label="Option disponible">
                    @foreach ($poles as $item)
                          <option value="{{$item->id}}">{{$item->libelle}}</option>
                        @endforeach
                  </optgroup>   
                </select>  
              </div>
            </div> 
            <div class="row mb-3">
              <label for="inputText" class="col-sm-2 col-form-label">Filière <i class="text-danger">*</i></label>
              <div class="col-sm-10">
                <select class="form-select" name="filiere_id" id="filiere_id" required> 
                  <optgroup label="Valeur par défaut">
                    <option selected value="{{ $niveau->filiere_id ? $niveau->getFiliere->id : ''}}">{{ $niveau->filiere_id ? $niveau->getFiliere->libelle : ''}}</option> 
                  </optgroup> 
                </select>
              </div>
            </div>  
            <div class="row mb-3">
              <label for="inputText" class="col-sm-2 col-form-label">Cycle <i class="text-danger">*</i></label>
              <div class="col-sm-10">
                <select class="form-select" name="cycle_id" id="cycle_id" required> 
                  <optgroup label="Valeur par défaut">
                    <option selected value="{{ $niveau->cycle_id ? $niveau->getCycle->id : ''}}">{{ $niveau->cycle_id ? $niveau->getCycle->libelle : ''}}</option> 
                  </optgroup>
                  <optgroup label="Liste disponible">
                    @foreach ($cycles as $item)
                    <option value="{{$item->id}}">{{$item->libelle}}</option> 
                    @endforeach
                  </optgroup>
                </select>
              </div>
            </div>
            <div class="row mb-3">
              <label for="inputText" class="col-sm-2 col-form-label">Libellé <i class="text-danger">*</i></label>
              <div class="col-sm-10">
                <input type="text" class="form-control" value="{{$niveau->libelle}}" required name="libelle" id="libelle" minlength="2" maxlength="100">
              </div>
            </div>  
            <div class="row mb-3">
              <label for="inputText" class="col-sm-2 col-form-label">Libellé secondaire <i class="text-danger">*</i></label>
              <div class="col-sm-10">
                <input type="text" class="form-control" value="{{$niveau->libelle_secondaire}}" required name="libelle_secondaire" id="libelle_secondaire" minlength="3" maxlength="100">
              </div>
            </div> 
            <div class="row mb-3">
              <label for="description" class="col-sm-2 col-form-label">Description</label>
              <div class="col-sm-10">
                <textarea class="form-control" style="height: 100px" name="description" id="description" >{{$niveau->description}}</textarea>
              </div>
            </div>  
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label">Validation</label>
              <div class="col-sm-10">
                <button type="submit" class="btn btn-warning">Modifier</button>
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

// si changement de pôle, il faut charger la liste des filières associées
$('#pole_id').on('change', function() { 
var pole_id = parseInt($('#pole_id').val()); 

if (pole_id != "") {
    $('#filiere_id').empty();
    $('#niveau_id').empty();
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
      // remove menu active
      $("ul").removeClass('show');
      $("ul li a").removeClass('active');
      // active menu 
      $("#parametres").removeClass('collapsed');
    } );
</script> 
@endsection
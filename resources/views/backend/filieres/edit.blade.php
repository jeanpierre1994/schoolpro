
@extends('backend/include/layout')
<!-- title -->
@section('title') Modification Filière || {{env('APP_NAME')}} @endsection

@section('fil-arial') 
<div class="pagetitle">
    <h1>Paramètres</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#" style="text-decoration: none;">Accueil</a></li>
        <li class="breadcrumb-item"><a href="{{route('admin.parametres')}}" style="text-decoration: none;">Paramètres</a></li>
        <li class="breadcrumb-item"><a href="{{route('filieres.index')}}" style="text-decoration: none;">Filière</a> </li>
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
          <form action="{{ route('filieres.update',$filiere->id) }}" method="post">
            @csrf
            @method("put")
            <div class="row mb-3">
              <label for="inputText" class="col-sm-2 col-form-label">Pôle <i class="text-danger">*</i></label>
              <div class="col-sm-10">
                <select class="form-select" name="pole_id" id="pole_id" required> 
                  <optgroup label="Valeur par défaut">
                    <option selected value="{{ $filiere->pole_id ? $filiere->getPole->id : ''}}">{{ $filiere->pole_id ? $filiere->getPole->libelle : ''}}</option> 
                  </optgroup>
                  <optgroup label="Liste disponible">
                    @foreach ($poles as $item)
                    <option value="{{$item->id}}">{{$item->libelle}}</option> 
                    @endforeach
                  </optgroup>
                </select>
              </div>
            </div>  
            <div class="row mb-3">
              <label for="inputText" class="col-sm-2 col-form-label">Libellé <i class="text-danger">*</i></label>
              <div class="col-sm-10">
                <input type="text" class="form-control" value="{{$filiere->libelle}}" required name="libelle" id="libelle" minlength="1" maxlength="100">
              </div>
            </div>  
            <div class="row mb-3">
              <label for="inputText" class="col-sm-2 col-form-label">Libellé secondaire <i class="text-danger">*</i></label>
              <div class="col-sm-10">
                <input type="text" class="form-control" value="{{$filiere->libelle_secondaire}}" required name="libelle_secondaire" id="libelle_secondaire" minlength="1" maxlength="100">
              </div>
            </div> 
            <div class="row mb-3">
              <label for="description" class="col-sm-2 col-form-label">Description</label>
              <div class="col-sm-10">
                <textarea class="form-control" style="height: 100px" name="description" id="description" >{{$filiere->description}}</textarea>
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

      // remove menu active
      $("ul").removeClass('show');
      $("ul li a").removeClass('active');
      // active menu 
      $("#parametres").removeClass('collapsed');
    } );
</script> 
@endsection
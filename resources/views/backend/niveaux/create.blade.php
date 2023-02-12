
@extends('backend/include/layout')
<!-- title -->
@section('title') Enregistrement Niveau|| {{env('APP_NAME')}} @endsection

@section('fil-arial') 
<div class="pagetitle">
    <h1>Paramètres</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#" style="text-decoration: none;">Accueil</a></li>
        <li class="breadcrumb-item"><a href="{{route('admin.parametres')}}" style="text-decoration: none;">Paramètres</a></li>
        <li class="breadcrumb-item"><a href="{{route('niveaux.index')}}" style="text-decoration: none;">Niveaux</a> </li>
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
          <form action="{{ route('niveaux.store') }}" method="post">
            @csrf
            <div class="row mb-3">
              <label for="inputText" class="col-sm-2 col-form-label">Filière <i class="text-danger">*</i></label>
              <div class="col-sm-10">
                <select class="form-select" name="filiere_id" id="filiere_id" required>
                  <option selected value="">Sélectionnez une option</option>
                  @foreach ($filieres as $item)
                  <option value="{{$item->id}}">{{$item->libelle}}</option> 
                  @endforeach
                </select> 
              </div>
            </div>  
            <div class="row mb-3">
              <label for="inputText" class="col-sm-2 col-form-label">Cycle <i class="text-danger">*</i></label>
              <div class="col-sm-10">
                <select class="form-select" name="cycle_id" id="cycle_id" required>
                  <option selected value="">Sélectionnez une option</option>
                  @foreach ($cycles as $item)
                  <option value="{{$item->id}}">{{$item->libelle}}</option> 
                  @endforeach
                </select> 
              </div>
            </div> 
            <div class="row mb-3">
              <label for="inputText" class="col-sm-2 col-form-label">Libellé <i class="text-danger">*</i></label>
              <div class="col-sm-10">
                <input type="text" class="form-control" required name="libelle" id="libelle" minlength="2" maxlength="50">
              </div>
            </div>  
            <div class="row mb-3">
              <label for="description" class="col-sm-2 col-form-label">Description</label>
              <div class="col-sm-10">
                <textarea class="form-control" style="height: 100px" name="description" id="description" ></textarea>
              </div>
            </div>  
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label">Validation</label>
              <div class="col-sm-10">
                <button type="submit" class="btn btn-warning">Enregistrer</button>
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

@extends('backend/include/layout')
<!-- title -->
@section('title') Enregistrement Site|| {{env('APP_NAME')}} @endsection

@section('fil-arial') 
<div class="pagetitle">
    <h1>Paramètres</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#" style="text-decoration: none;">Accueil</a></li>
        <li class="breadcrumb-item"><a href="{{route('admin.parametres')}}" style="text-decoration: none;">Paramètres</a></li>
        <li class="breadcrumb-item"><a href="{{route('sites.index')}}" style="text-decoration: none;">Site</a> </li>
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
          <form action="{{ route('sites.store') }}" method="post">
            @csrf
            <div class="row mb-3">
              <div class="col-md-6">
                <label for="inputText" class=" col-form-label">Sigle <i class="text-danger">*</i></label>
                <div>
                  <input type="text" class="form-control" required name="sigle" id="sigle" minlength="3" maxlength="20">
                </div>
              </div>
              <div class="col-md-6">
                <label for="inputText" class=" col-form-label">Etablissement<i class="text-danger">*</i></label>
                <div> 
                    <select class="form-select" name="etablissement_id" id="etablissement_id" required>
                      <option selected value="">Sélectionnez une option</option>
                      @foreach ($etablissements as $item)
                      <option value="{{$item->id}}">{{$item->sigle}}</option> 
                      @endforeach
                    </select> 
                </div>
              </div>   
            </div>
            <div class="row mb-3"> 
              <div class="col-md-6">
                <label for="inputText" class=" col-form-label">Téléphone <i class="text-danger">*</i></label>
                <div>
                  <input type="number" class="form-control" required name="telephone" id="telephone" >
                </div>
              </div>
              <div class="col-md-6">
                <label for="inputText" class=" col-form-label">Adresse <i class="text-danger">*</i></label>
                <div>
                  <input type="text" class="form-control" required name="adresse" id="adresse" minlength="3" maxlength="255" >
                </div>
              </div>
              <div class="col-md-6">
              <label for="inputText" class=" col-form-label">E-mail <i class="text-danger">*</i></label>
                <div>
                  <input type="text" class="form-control" required name="email" id="email" minlength="2" maxlength="150" >
                </div>  
              </div> 
              <div class="col-md-6">
              <label for="inputText" class=" col-form-label">Gestionnaire <i class="text-danger">*</i></label>
                <div>
                  <input type="text" class="form-control" required name="manager" id="manager" minlength="2" maxlength="150" >
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
    } );
</script> 
@endsection
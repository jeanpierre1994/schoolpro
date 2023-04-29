
@extends('backend/include/layout')
<!-- title -->
@section('title') Enregistrement Professeur || {{env("APP_NAME")}} @endsection

@section('fil-arial') 
<div class="pagetitle">
    <h1>Professeur</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#" style="text-decoration: none;">Home</a></li>
        <li class="breadcrumb-item"><a href="{{route('admin.parametres')}}" style="text-decoration: none;">Paramètres</a></li>
        <li class="breadcrumb-item"><a href="{{route('professeurs.index')}}" style="text-decoration: none;">Professeur</a> </li>
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
          <form action="{{ route('professeurs.store') }}" method="post">
            @csrf
            <div class="row mb-3">
              <div class="col-md-6">
                <label for="inputText" class=" col-form-label">Nom <i class="text-danger">*</i></label>
                <div>
                  <input type="text" class="form-control" required name="nom" id="nom" minlength="3" maxlength="100">
                </div>
              </div>
              <div class="col-md-6">
                <label for="inputText" class=" col-form-label">Prénoms <i class="text-danger">*</i></label>
                <div>
                  <input type="text" class="form-control" required name="prenoms" id="prenoms" minlength="3" maxlength="100">
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
                <label for="inputText" class=" col-form-label">E-mail <i class="text-danger">*</i></label>
                <div>
                  <input type="email" class="form-control" required name="email" id="email" minlength="5" maxlength="100" >
                </div>
              </div>   
            </div>  
            
            <div class="row mb-3">  
              <div class="col-md-6">
                <label for="inputText" class=" col-form-label">Mot de passe <i class="text-danger">*</i></label>
                <div>
                  <input type="password" maxlength="100" minlength="8" name="password" class="form-control" id="password" pattern="^(?=.{8,32}$)(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).*" required>
                  <div class="invalid-feedbackx">
                    Le mot de passe doit contenir : 
                     <li>au moin 1 lettre majuscule</li>
                     <li>au moin 1 lettre miniscule</li>
                     <li>au moin 1 numéro</li>
                     <li>Minimum 8 caractères</li>
                 </div>
                </div> 
              </div>   
              <div class="col-md-6">
                <label for="inputText" class=" col-form-label">Date enregistrement <i class="text-danger">*</i></label>
                <div>
                  <input type="date" class="form-control" required name="date_enregistrment" id="date_enregistrment" value="{{date("Y-m-d")}}" >
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
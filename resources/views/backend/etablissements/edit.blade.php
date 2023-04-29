
@extends('backend/include/layout')
<!-- title -->
@section('title') Modification Etablissement|| {{env('APP_NAME')}} @endsection

@section('fil-arial') 
<div class="pagetitle">
    <h1>Paramètres</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#" style="text-decoration: none;">Accueil</a></li>
        <li class="breadcrumb-item"><a href="{{route('admin.parametres')}}" style="text-decoration: none;">Paramètres</a></li>
        <li class="breadcrumb-item"><a href="{{route('etablissements.index')}}" style="text-decoration: none;">Etablissements</a> </li>
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
          <form action="{{ route('etablissements.update',$etablissement->id) }}" method="post">
            @csrf
            @method("put")
            <div class="row mb-3">
              <div class="col-md-6">
                <label for="inputText" class=" col-form-label">Sigle <i class="text-danger">*</i></label>
                <div>
                  <input type="text" class="form-control" value="{{$etablissement->sigle}}" required name="sigle" id="sigle" minlength="3" maxlength="20">
                </div>
              </div>
              <div class="col-md-6">
                <label for="inputText" class=" col-form-label">Description <i class="text-danger">*</i></label>
                <div>
                  <input type="text" class="form-control"  value="{{$etablissement->description}}"required name="description" id="description" minlength="3" maxlength="100">
                </div>
              </div>   
            </div>
            <div class="row mb-3"> 
              <div class="col-md-6">
                <label for="inputText" class=" col-form-label">Téléphone <i class="text-danger">*</i></label>
                <div>
                  <input type="number" class="form-control" value="{{$etablissement->telephone}}" required name="telephone" id="telephone" >
                </div>
              </div>
              <div class="col-md-6">
                <label for="inputText" class=" col-form-label">IFU <i class="text-danger">*</i></label>
                <div>
                  <input type="text" class="form-control" value="{{$etablissement->ifu}}" required name="ifu" id="ifu" minlength="13" maxlength="13" >
                </div>
              </div>   
            </div>  
            
            <div class="row mb-3"> 
              <div class="col-md-4">
                <label for="inputText" class=" col-form-label">Statut juridique <i class="text-danger">*</i></label>
                <div> 
                  <select class="form-select" name="statutjuridique_id" id="statutjuridique_id" required> 
                    <optgroup label="Valeur par défaut">
                      <option value="{{ $etablissement->statutjuridique_id ? $etablissement->getStatutjuridique->id : ''}}">{{ $etablissement->statutjuridique_id ? $etablissement->getStatutjuridique->libelle : ''}}</option> 
                    </optgroup>
                    <optgroup label="Liste disponible">
                      @foreach ($statutjuridiques as $item)
                      <option value="{{$item->id}}">{{$item->libelle}}</option> 
                      @endforeach
                    </optgroup>
                  </select>  
                </div>
              </div>
              <div class="col-md-4">
                <label for="inputText" class=" col-form-label">Dirigeant <i class="text-danger">*</i></label>
                <div>
                  <input type="text" class="form-control" value="{{$etablissement->dirigeant}}" required name="dirigeant" id="dirigeant" minlength="1" maxlength="150" >
                </div>
              </div> 
              <div class="col-md-4">
                <label for="inputText" class=" col-form-label">Adresse <i class="text-danger">*</i></label>
                <div>
                  <input type="text" class="form-control" value="{{$etablissement->adresse}}" required name="adresse" id="adresse" minlength="2" maxlength="150" >
                </div>
              </div> 
            </div> 
            <div class="row mb-3">  
                <div class="col-md-6">
                  <button type="submit" class="btn btn-primary">Modifier</button> 
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
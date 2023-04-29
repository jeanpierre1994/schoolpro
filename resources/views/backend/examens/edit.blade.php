
@extends('backend/include/layout')
<!-- title -->
@section('title') Modification Examen|| {{env('APP_NAME')}} @endsection

@section('fil-arial') 
<div class="pagetitle">
    <h1>Paramètres</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#" style="text-decoration: none;">Accueil</a></li>
        <li class="breadcrumb-item"><a href="{{route('admin.parametres')}}" style="text-decoration: none;">Paramètres</a></li>
        <li class="breadcrumb-item"><a href="{{route('examens.index')}}" style="text-decoration: none;">Examens</a> </li>
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
          <form action="{{ route('examens.update',$examen->id) }}" method="post">
            @csrf
            <div class="row mb-3"> 
              <div class="col-md-6">
                <label for="inputText" class=" col-form-label">Groupe pédagogique<i class="text-danger">*</i></label>
                <div> 
                    <select class="form-select" name="gp_id" id="gp_id" required>
                      <optgroup label="Valeur par défaut">
                        <option selected value="{{$examen->groupepedagogique_id ? $examen->getGP->id : ''}}">{{$examen->groupepedagogique_id ? $examen->getGP->libelle_classe : ''}}</option>
                      </optgroup>
                      <optgroup label="Liste disponible">
                        @foreach ($gp as $item)
                        <option value="{{$item->id}}">{{$item->libelle_classe}}</option> 
                        @endforeach
                      </optgroup> 
                    </select> 
                </div>
              </div>  
              <div class="col-md-6">
                <label for="inputText" class=" col-form-label">Type examen<i class="text-danger">*</i></label>
                <div> 
                    <select class="form-select" name="examentype_id" id="examentype_id" required>
                      <optgroup label="Valeur par défaut">
                        <option selected value="{{$examen->examentype_id ? $examen->getExamentype->id : ''}}">{{$examen->examentype_id ? $examen->getExamentype->libelle : ''}}</option>
                      </optgroup>
                      <optgroup label="Liste disponible">
                        @foreach ($examentypes as $item)
                        <option value="{{$item->id}}">{{$item->libelle}}</option> 
                        @endforeach
                      </optgroup> 
                    </select> 
                </div>
              </div>   
            </div>
            <div class="row mb-3">   
              <div class="col-md-4">
                <label for="inputText" class=" col-form-label">Libellé <i class="text-danger">*</i></label>
                <div>
                  <input type="text" class="form-control" required name="libelle" id="libelle" minlength="1" maxlength="100" value="{{$examen->libelle}}" >
                </div>
              </div>
              <div class="col-md-4">
                <label for="inputText" class=" col-form-label">Démarre le <i class="text-danger">*</i></label>
                <div>
                  <input type="date" class="form-control" required name="date_debut" id="date_debut" value="{{$examen->date_debut}}" >
                </div>
              </div>
              <div class="col-md-4">
              <label for="inputText" class=" col-form-label">Finit le <i class="text-danger">*</i></label>
                <div>
                  <input type="date" class="form-control" required name="date_fin" id="date_fin" value="{{$examen->date_fin}}" >
                </div>  
              </div> 
              <div class="col-md-4">
              <label for="inputText" class=" col-form-label">Année académique <i class="text-danger">*</i></label>
                <div>
                  <input type="number" class="form-control" required name="annee_academique" id="annee_academique" min="0" max="9999" value="{{$examen->annee_academique}}" >
                </div>  
              </div> 
              <div class="col-md-4">
              <label for="inputText" class=" col-form-label">Note maximum <i class="text-danger">*</i></label>
                <div>
                  <input type="number" class="form-control" required name="note_max" id="note_max" min="0" max="100" value="{{$examen->note_max}}" >
                </div>  
              </div> 
              <div class="col-md-4">
              <label for="inputText" class=" col-form-label">Moyenne min <i class="text-danger">*</i></label>
                <div>
                  <input type="number" class="form-control" required name="min_moyenne" id="min_moyenne" min="0" max="100" value="{{$examen->min_moyenne}}" >
                </div>  
              </div> 
              <div class="col-md-4">
              <label for="inputText" class=" col-form-label">Moyenne max <i class="text-danger">*</i></label>
                <div>
                  <input type="number" class="form-control" required name="max_moyenne" id="max_moyenne" min="0" max="100" value="{{$examen->max_moyenne}}" >
                </div>  
              </div> 
              <div class="col-md-4">
              <label for="inputText" class=" col-form-label">Pondération<i class="text-danger">*</i></label>
                <div>
                  <input type="number" class="form-control" name="ponderation" id="ponderation" min="0" max="255" value="{{$examen->ponderation}}" required>
                </div>  
              </div> 
              <div class="col-md-4">
              <label for="inputText" class=" col-form-label">Commentaire<i class="text-danger"></i></label>
                <div>
                  <input type="text" class="form-control" name="commentaire" id="commentaire" minlength="0" maxlength="255" value="{{$examen->commentaire}}">
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

@extends('backend/include/layout')
<!-- title -->
@section('title') Modification Matière Groupe Pédagogique|| {{env('APP_NAME')}} @endsection

@section('fil-arial') 
<div class="pagetitle">
    <h1>Paramètres</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#" style="text-decoration: none;">Accueil</a></li>
        <li class="breadcrumb-item"><a href="{{route('admin.parametres')}}" style="text-decoration: none;">Paramètres</a></li>
        <li class="breadcrumb-item"><a href="{{route('matieres.index')}}" style="text-decoration: none;">Matière Groupe Pédagogique</a> </li>
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
          <form action="{{ route('matieres.update',$matiere->id) }}" method="post">
            @csrf
            @method("PUT")
            <div class="row mb-3"> 
              <div class="col-md-6">
                <label for="inputText" class=" col-form-label">Groupe pédagogique<i class="text-danger">*</i></label>
                <div> 
                    <select class="form-select" name="gp_id" id="gp_id" required>
                      <optgroup label="Valeur par défaut">
                        <option selected value="{{$matiere->groupepedagogique_id ? $matiere->getGP->id : ''}}">{{$matiere->groupepedagogique_id ? $matiere->getGP->libelle_classe : ''}}</option>
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
                <label for="inputText" class=" col-form-label">Section <i class="text-danger">*</i></label>
                <div> 
                    <select class="form-select" name="section_id" id="section_id" required>
                      <optgroup label="Valeur par défaut">
                        <option selected value="{{$matiere->section_id ? $matiere->getsection->id : ''}}">{{$matiere->section_id ? $matiere->getsection->libelle : ''}}</option>
                      </optgroup>
                      <optgroup label="Liste disponible">
                        @foreach ($sections as $item)
                        <option value="{{$item->id}}">{{$item->libelle}}</option> 
                        @endforeach
                      </optgroup>
                    </select> 
                </div>
              </div>
            </div>
            <div class="row mb-3">    
              <div class="col-md-6">
                <label for="inputText" class=" col-form-label">Libellé <i class="text-danger">*</i></label>
                <div>
                  <select class="form-select" name="matiereconfig_id" id="matiereconfig_id" required>
                    <optgroup label="Valeur par défaut">
                      <option selected value="{{$matiere->categorie_id ? $matiere->getCategorie->id : ''}}">{{$matiere->categorie_id ? $matiere->getCategorie->libelle : ''}}</option>
                    </optgroup>
                    <optgroup label="Liste disponible">
                      @foreach ($matiereconfigs as $item)
                      <option value="{{$item->id}}">{{$item->libelle}}</option> 
                      @endforeach
                    </optgroup>
                  </select> 
                </div>
              </div>
              <div class="col-md-6">
              <label for="inputText" class=" col-form-label">Note max <i class="text-danger">*</i></label>
                <div>
                  <input type="number" class="form-control" required name="note_max" id="note_max" min="0" max="100" value="{{$matiere->note_max}}">
                </div>  
              </div> 
              <div class="col-md-6">
              <label for="inputText" class=" col-form-label">Moyenne <i class="text-danger">*</i></label>
                <div>
                  <input type="number" class="form-control" required name="moyenne" id="moyenne" min="0" max="100" value="{{$matiere->moyenne}}">
                </div>  
              </div> 
              <div class="col-md-6">
              <label for="inputText" class=" col-form-label">Coef <i class="text-danger">*</i></label>
                <div>
                  <input type="number" class="form-control" required name="coef" id="coef" min="0" max="100" value="{{$matiere->coef}}">
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
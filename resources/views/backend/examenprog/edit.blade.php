
@extends('backend/include/layout')
<!-- title -->
@section('title') Modification Examen Prog|| {{env('APP_NAME')}} @endsection

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
          <form action="{{ route('examenprog.update',$examenprog->id) }}" method="post">
            @csrf
            @method("put")
            <input type="hidden" name="examen_id" value="{{$examenprog->examen_id}}">
            <input type="hidden" name="gp_id" value="{{$examenprog->getMatiere->getGP->id}}">
            <div class="row mb-3">  
              <div class="col-md-6">
                <label for="inputText" class=" col-form-label">Groupe Péda. <i class="text-danger">*</i></label>
                <div>
                  <input type="text" value="{{$examenprog->getMatiere->getGP->getFiliere->libelle}} {{$examenprog->getMatiere->getGP->libelle_classe}} {{ $examenprog->getMatiere->getGP->libelle_secondaire }}" class="form-control" disabled name="gp" id="gp" minlength="1" maxlength="100" >
                </div>
              </div>  
              
              <div class="col-md-6">
                <label for="inputText" class=" col-form-label">Matière <i class="text-danger">*</i></label>
                <div>
                  <input type="text" value="{{$examenprog->matiere_id ? $examenprog->getMatiere->libelle : ''}}" class="form-control" name="matiere" disabled id="matiere" minlength="1" maxlength="100" >
                </div>
              </div>  
            </div>
            <div class="row mb-3">   
              <div class="col-md-6">
                <label for="inputText" class=" col-form-label">Date début <i class="text-danger">*</i></label>
                <div>
                  <input type="datetime-local" value="{{$examenprog->date_debut}}" class="form-control" required name="date_debut" id="date_debut">
                </div>
              </div>
              <div class="col-md-6">
              <label for="inputText" class="col-form-label">Date fin <i class="text-danger">*</i></label>
                <div>
                  <input type="datetime-local" value="{{$examenprog->date_fin}}" class="form-control" required name="date_fin" id="date_fin">
                </div>  
              </div>   
              <div class="col-md-4">
              <label for="inputText" class=" col-form-label">Commentaire<i class="text-danger"></i></label>
                <div>
                  <input type="text" value="{{$examenprog->commentaire}}" class="form-control" name="commentaire" id="commentaire" minlength="0" maxlength="255" >
                </div>  
              </div>   
              <div class="col-md-4">
              <label for="inputText" class=" col-form-label">Action<i class="text-danger"></i></label>
                <div>
                    <button type="submit" class="btn btn-primary">Modifier</button>                 </div>  
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
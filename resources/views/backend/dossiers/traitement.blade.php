
@extends('backend/include/layout')
<!-- title -->
@section('title') Traitement dossier || {{env('APP_NAME')}} @endsection

@section('fil-arial') 
<div class="pagetitle">
    <h1>Traitement</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#" style="text-decoration: none;">Accueil</a></li>
        <li class="breadcrumb-item"><a href="{{route('dossiers.en_attente')}}" style="text-decoration: none;">Dossier en attente</a></li>
        <li class="breadcrumb-item active"><a href="{{route('dossiers.traitement',$dossier->id)}}" style="text-decoration: none;">Traiement</a> </li>
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
        <h5 class="card-title">Traitement du dossier N° <code>{{$dossier->code}}</code></h5>
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
          <form action="{{route('dossiers.store_traitement')}}" method="post">
            @csrf 
            <div class="row">
                <div class="form-group col-md-4 mb-3">
                    <label for="inputText" class="col-form-label">Nom <i class="text-danger">*</i></label> 
                      <input type="text" readonly class="form-control" value="{{$dossier->getPersonne->nom}}" required name="nom" id="nom" >
                 </div>
                 <div class="form-group col-md-4 mb-3">
                     <label for="inputText" class="col-form-label">Prénoms <i class="text-danger">*</i></label> 
                       <input type="text" readonly class="form-control" value="{{$dossier->getPersonne->prenoms}}" required name="prenoms" id="prenoms" >
                  </div>
                  <div class="form-group col-md-4 mb-3">
                      <label for="inputText" class="col-form-label">DDN <i class="text-danger">*</i></label> 
                        <input type="date" readonly class="form-control" value="{{$dossier->ddn}}" required name="ddn" id="ddn" >
                   </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4 mb-3">
                    <label for="inputText" class="col-form-label">Nationalité <i class="text-danger">*</i></label> 
                      <input type="text" readonly class="form-control" value="{{$dossier->getPersonne->lieu_naissance}}" required name="lieu_naissance" id="lieu_naissance" >
                 </div>
                 <div class="form-group col-md-4 mb-3">
                     <label for="inputText" class="col-form-label">Adresse <i class="text-danger">*</i></label> 
                       <input type="text" readonly class="form-control" value="{{$dossier->getPersonne->adresse}}" required name="adresse" id="adresse" >
                  </div>
                  <div class="form-group col-md-4 mb-3">
                      <label for="inputText" class="col-form-label">Téléphone <i class="text-danger">*</i></label> 
                        <input type="text" readonly class="form-control" value="{{$dossier->telephone}}" required name="telephone" id="telephone" >
                   </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4 mb-3">
                    <label for="inputText" class="col-form-label">Etablissement <i class="text-danger">*</i></label> 
                      <input type="text" readonly class="form-control" value="{{$dossier->getSite->getEtablissement->sigle}}" required name="etablissement" id="etablissement" >
                 </div>
                 <div class="form-group col-md-4 mb-3">
                     <label for="inputText" class="col-form-label">Site <i class="text-danger">*</i></label> 
                       <input type="text" readonly class="form-control" value="{{$dossier->getSite->sigle}}" required name="sigle" id="sigle" >
                  </div>
                  <div class="form-group col-md-4 mb-3">
                      <label for="inputText" class="col-form-label">Pôle <i class="text-danger">*</i></label> 
                        <input type="text" readonly class="form-control" value="{{$dossier->getPole->libelle}}" required name="pole" id="pole" >
                   </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4 mb-3">
                    <label for="inputText" class="col-form-label">Filière <i class="text-danger">*</i></label> 
                      <input type="text" readonly class="form-control" value="{{$dossier->getFiliere->libelle}}" required name="filiere" id="filiere" >
                 </div>
                 <div class="form-group col-md-4 mb-3">
                     <label for="inputText" class="col-form-label">Cycle <i class="text-danger">*</i></label> 
                       <input type="text" readonly class="form-control" value="{{$dossier->getCycle->libelle}}" required name="cycle" id="cycle" >
                  </div>
                  <div class="form-group col-md-4 mb-3">
                      <label for="inputText" class="col-form-label">Niveau <i class="text-danger">*</i></label> 
                        <input type="text" readonly class="form-control" value="{{$dossier->getNiveau->libelle}}" required name="niveau" id="niveau" >
                   </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6 mb-3">
                    <label for="inputText" class="col-form-label">Année <i class="text-danger">*</i></label> 
                      <input type="text" readonly class="form-control" value="{{$dossier->annee}}" required name="annee" id="annee" >
                 </div>
                 <div class="form-group col-md-6 mb-3">
                     <label for="inputText" class="col-form-label">Type sponsor <i class="text-danger">*</i></label> 
                       <input type="text" readonly class="form-control" value="{{$dossier->getTypesponsor->libelle}} {{ $dossier->sponsor }}" required name="typesponsor" id="typesponsor" >
                  </div> 
            </div>

            <hr style="border: solid black 1px; magrin-bottom:2px">

            <div class="row">
                <div class="form-group col-md-4 mb-3">
                    <label for="inputText" class="col-form-label">Groupe pédagogique <i class="text-danger">*</i></label> 
                    <select class="form-select" name="groupepedagogique_id" id="groupepedagogique_id" required>
                        <option value="" selected>Choisissez une option</option>  
                        @foreach ($gp as $item)
                        <option value="{{$item->id}}">{{$item->getPole->libelle}} {{$item->getFiliere->libelle}} {{$item->libelle_classe}} {{$item->libelle_secondaire}}</option>
                        @endforeach
                      </select>
                 </div>
                 <div class="form-group col-md-4 mb-3">
                     <label for="inputText" class="col-form-label">Statut traitement <i class="text-danger">*</i></label> 
                     <select class="form-select" name="statuttraitement_id" id="statuttraitement_id" required>
                        <option value="" selected>Choisissez une option</option>  
                        @foreach ($statuttraitements as $item)
                        <option value="{{$item->id}}">{{$item->libelle}}</option>
                        @endforeach
                      </select>
                  </div> 
                  <div class="form-group col-md-4 mb-3">
                      <label for="inputText" class="col-form-label">Commentaire<i class="text-danger"></i></label> 
                        <input type="text" class="form-control" value="" name="commentaire" id="commentaire" >
                   </div>
                   <div class="form-group col-md-6 mb-3">
                       <label for="inputText" class="col-form-label">montant à payer<i class="text-danger"></i></label> 
                         <input type="text" class="form-control" value="98000" name="montant_a_payer" id="montant_a_payer" >
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        <label for="inputText" class="col-form-label">montant payé<i class="text-danger">*</i></label> 
                          <input type="number" class="form-control" value="0" name="montant_payer" id="montant_payer" required>
                     </div>
            </div> 
            <div class="row mb-3">
              <div class="col-md-6"> 
                <label class="col-form-label"></label>
                <div class="">
                  <input type="hidden" name="id" value="{{$dossier->id}}">
                  <input type="submit" value="Procéder au paiement" id="paiement" class="btn btn-primary" name="paiement">
                </div> 
              </div>
              <div class="col-md-6"> 
                <label class="col-form-label"></label>
                <div class=""> 
                  <input type="submit" class="btn btn-warning" value="Valider sans payer" id="no_paiement" name="no_paiement"/>
                </div>
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


$('#paiement').attr("disabled", true);

$('#montant_payer').change(function () {
var montant = parseInt($(this).val());
var montant_a_payer = parseInt($("#montant_a_payer").val());

if (montant > 0 && montant_a_payer > 0) {
  $('#paiement').attr("disabled", false);
  // vérifier si le montant à payer est supérieur au montant à payer
  if (montant > montant_a_payer) {
    alert("Le montant payé ne peut pas être supérieur au montant à payer");
    $('#paiement').attr("disabled", true);
  }

} else {
  $('#paiement').attr("disabled", true);
}
});

    } );
</script> 
@endsection
@extends('frontend.inc.layout')

@section("title")
Inscription Etudiant || {{env('APP_NAME')}}
@endsection

@section("contenu") 

<section class="w3l-contact-breadcrum">
    <div class="breadcrum-bg py-sm-5 py-4">
      <div class="container py-lg-3">
        <h2>Inscription étudiant</h2>
        <p><a href="{{route('inscription')}}">Choix catégorie</a> &nbsp; / &nbsp; Inscription étudiant</p>
      </div>
    </div>
  </section>
  <!-- - - - -->
  <section class="w3l-contacts-12" id="contact">
      <div class="contact-top pt-5">
          <div class="container py-md-3">              
              <div class="row justify-content-md-center cont-main-top well">
                <h3 class="mb-5">Formulaire d'inscription des étudiants</h3>
                   <!-- inscription étudiant form -->
                   <div class="contacts12-main col-offset-3 col-lg-8 mt-lg-0 mt-5"> 
                      <form action="{{route('inscription.store_parent_etudiant')}}" method="post" class="main-input">
                        @csrf
                        <input type="hidden" name="parent_id" value="{{$parent->id}}">
                        <div class="row">
                          <div class="form-group col-md-6">
                            <label for="nom_parent">Nom & prenoms parent<i class="text-danger">*</i></label>
                            <input type="text" name="nom_parent" id="nom_parent" value="{{$parent->nom}} {{$parent->prenoms}}" required="" readonly maxlength="100">
                          </div>
                          <div class="form-group col-md-6">
                            <label for="lienparental_id">Lien parental <i class="text-danger">*</i></label>
                               <select name="lienparental_id" id="lienparental_id" class="form-control" required>
                                <option value=""></option>
                                @foreach ($lienparentals as $item)
                                <option value="{{$item->id}}">{{$item->libelle}}</option>
                                @endforeach
                              </select>                       
                          </div>
                        </div>
                        <hr>
                        <cite><b>Etudiant/Elève</b></cite>
                        <hr>
                        <div class="row">
                          <div class="form-group col-md-6">
                            <label for="nom">Nom <i class="text-danger">*</i></label>
                            <input type="text" name="nom" id="nom" required="" maxlength="100" required>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="prenoms">Prénoms <i class="text-danger">*</i></label>
                            <input type="text" name="prenoms" id="prenoms" required=""  maxlength="100" required>
                          </div>
                        </div>
                        <div class="row">
                          <div class="form-group col-md-6">
                            <label for="surnom">Surnom <i class="text-danger"></i></label>
                            <input type="text" name="surnom" id="surnom" maxlength="100">
                          </div>
                          <div class="form-group col-md-6">
                            <label for="nom_jeune_fille">Nom de jeune fille <i class="text-danger"></i></label>
                            <input type="text" name="nom_jeune_fille" id="nom_jeune_fille"  maxlength="100">
                          </div>
                        </div>
                        <div class="row">
                          <div class="form-group col-md-6">
                            <label for="ddn">Date Nais. <i class="text-danger">*</i></label>
                            <input type="date" name="ddn" id="ddn" required="" required>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="lieu_naissance">Lieu Nais. <i class="text-danger">*</i></label>
                            <input type="text" name="lieu_naissance" id="lieu_naissance" required="" maxlength="150" required>
                          </div>
                        </div>
                        <div class="row">
                          <div class="form-group col-md-6">
                            <label for="telephone">Téléphone <i class="text-danger">*</i></label>
                            <input type="number" name="telephone" id="telephone" required="" maxlength="20" required>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="email">E-mail <i class="text-danger">*</i></label>
                            <input type="text" name="email" id="email" required="" maxlength="100" required >
                          </div>
                        </div>
                        <div class="row">
                          <div class="form-group col-md-6">
                            <label for="genre">Genre <i class="text-danger">*</i></label>
                            <select name="genre_id" id="genre_id" class="form-control" required>
                              <option value=""></option>
                              @foreach ($genres as $item)
                              <option value="{{$item->id}}">{{$item->libelle}}</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="email">Nationalité <i class="text-danger">*</i></label>
                            <select name="nationalite_id" id="nationalite_id" class="form-control" required>
                              <option value=""></option>
                              <option value="Béninoise">Béninoise</option> 
                            </select>
                          </div>
                        </div> 
                        <div class="row">
                          <div class="form-group col-md-6">
                            <label for="etablissement">Etablissement <i class="text-danger">*</i></label>
                            <select name="etablissement_id" id="etablissement_id" class="form-control" required>
                              <option value=""></option> 
                              @foreach ($etablissements as $item)
                              <option value="{{$item->id}}">{{$item->sigle}}</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="site">Site <i class="text-danger">*</i></label>
                            <select name="site_id" id="site_id" class="form-control" required>
                              <option value=""></option> 
                            </select>
                          </div>
                          <div class="form-group col-md-12">
                            <label for="password">Mot de passe <i class="text-danger">*</i></label>
                            <input type="password" name="password" id="password" required="" maxlength="100" required >
                          </div>
                        </div>        
                          <div class="text-right">
                              <a href="{{route('index')}}"><button type="button" class="btn btn-theme2">Terminer</button></a>
                              <button type="submit" class="btn btn-theme2">Valider</button>
                          </div>
                      </form>
                  </div>
                  <!-- //inscription étudiant form -->
              </div>
          </div> 
      </div>
  </section>
  <!-- //- - - -->

@endsection

@section("js-script")
<script>
  $(document).ready(function() {
 $('#etablissement_id').on('change', function() {
 
 var etablissement_id = parseInt($('#etablissement_id').val()); 
 if (etablissement_id != "") {
     $('#site_id').empty();
     $('#site_id').append('<option value="" selected="selected">Choisissez une option</option>');
     $.ajax({
         url: "{{ route('ajax_requete') }}",
         data: {
           etablissement_id: etablissement_id,
             _token: '{{csrf_token()}}'
         },
         type: 'POST',
         dataType: 'json',
         success: function(data, status) { 
             jQuery.each(data, function(key, value) {
                 $('#site_id').append('<option value="' + value.id + '">' + value.sigle + '</option>');
             });
         },
         error: function(xhr, textStatus, errorThrown) {
             //  alert('Veuillez renseigner tous les champs'); 
             console.log(xhr); 
             console.log(textStatus);
             console.log(errorThrown);
         }
     });
 }
 
 });
 });
   </script>
@endsection
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
                <h3 class="mb-5">Formulaire d'inscription des parents</h3>
                   <!-- inscription étudiant form -->
                   <div class="contacts12-main col-offset-3 col-lg-8 mt-lg-0 mt-5"> 
                      <form action="{{route('parent_etudiant')}}" method="post" class="main-input">
                        @csrf
                        <div class="row">
                          <div class="form-group col-md-6">
                            <label for="nom">Nom <i class="text-danger">*</i></label>
                            <input type="text" name="nom" id="nom" required="" maxlength="100">
                          </div>
                          <div class="form-group col-md-6">
                            <label for="prenoms">Prénoms <i class="text-danger">*</i></label>
                            <input type="text" name="prenoms" id="prenoms" required=""  maxlength="100">
                          </div>
                        </div> 
                        <div class="row">
                          <div class="form-group col-md-6">
                            <label for="telephone">Téléphone <i class="text-danger">*</i></label>
                            <input type="number" name="telephone" id="telephone" required="" min="0">
                          </div>
                          <div class="form-group col-md-6">
                            <label for="email">E-mail <i class="text-danger">*</i></label>
                            <input type="email" name="email" id="email" required="">
                          </div>
                        </div>
                        <div class="row">
                          <div class="form-group col-md-6">
                            <label for="genre">Genre <i class="text-danger">*</i></label>
                            <select name="genre_id" id="genre_id" class="form-control" required>
                              <option value=""></option>
                              <option value="Masculin">Masculin</option>
                              <option value="Féminin">Féminin</option>
                            </select>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="email">Nationalité <i class="text-danger">*</i></label>
                            <select name="pays_id" id="pays_id" class="form-control" required>
                              <option value=""></option>
                              <option value="Béninoise">Béninoise</option> 
                            </select>
                          </div>
                        </div> 
                        <div class="row">
                          <div class="form-group col-md-6">
                            <label for="situation_matri">Situation matri. <i class="text-danger">*</i></label>
                            <select name="situation_matri_id" id="situation_matri_id" class="form-control" required>
                              <option value=""></option> 
                              <option value="Célibataire">Célibataire</option> 
                              <option value="Mariée">Mariée</option> 
                            </select>                          
                          </div>
                          <div class="form-group col-md-6">
                            <label for="adresse">Adresse <i class="text-danger">*</i></label>
                            <input type="text" name="adresse" id="adresse" required="" maxlength="150">
                          </div>
                        </div> 
                          <div class="text-right">
                              <button type="submit" class="btn btn-theme2">Suivant</button>
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
  
@endsection
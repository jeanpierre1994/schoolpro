@extends('frontend.inc.layout')

@section("title")
Inscription || {{env('APP_NAME')}}
@endsection

@section("contenu") 

<section class="w3l-contact-breadcrum">
    <div class="breadcrum-bg py-sm-5 py-4">
      <div class="container py-lg-3">
        <h2>Inscription</h2>
        <p><a href="{{route('index')}}">Accueil</a> &nbsp; / &nbsp; Inscription</p>
      </div>
    </div>
  </section>
  <!-- contact -->
  <section class="w3l-contacts-12" id="inscription">
      <div class="contact-top pt-5">
          <div class="container py-md-3">              
              <div class="row justify-content-md-center cont-main-top well">
                   <!-- inscription form -->                   
                   <div class="contacts12-main col-offset-3 col-lg-8 mt-lg-0 mt-5"> 
                      <form action="{{route('inscription-form')}}" method="post" class="main-input">
                        @csrf
                        <h3 class="text-center mb-5">Choisissez votre catégorie</h3>
                        <div class="top-inputs d-grid">
                            <button type="submit" name="etudiant" class="btn btn-theme2 p-5"><span class="fa fa-user fa-2x"></span> Inscription Etudiant</button>
                            <button type="submit" name="parent" class="btn btn-theme2 p-5"><span class="fa fa-users fa-2x"></span> Inscription parent</button>
                            <input readonly type="text" placeholder="Name" name="w3lName" value="Réserver pour les étudiants" id="w3lName" required="">
                            <input readonly type="text" name="email" placeholder="Email" value="Réserver pour les parents d'élèves" id="w3lSender" required="">
                        </div>   
                      </form>
                  </div>
                  <!-- //inscription form -->
              </div>
          </div> 
      </div>
  </section>
  <!-- //contact -->

@endsection

@section("js-script")
  
@endsection
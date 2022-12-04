@extends('frontend.inc.layout')

@section("title")
Accueil || {{env('APP_NAME')}}
@endsection

@section("contenu") 

<section class="w3l-contact-breadcrum">
    <div class="breadcrum-bg py-sm-5 py-4">
      <div class="container py-lg-3">
        <h2>Connexion</h2>
        <p><a href="{{route('index')}}">Accueil</a> &nbsp; / &nbsp; Connexion</p>
      </div>
    </div>
  </section>
  <!-- contact -->
  <section class="w3l-contacts-12" id="contact">
      <div class="contact-top pt-5">
          <div class="container py-md-3">
              
              <div class="row justify-content-md-center cont-main-top well">
                   <!-- connexion form -->
                   <div class="contacts12-main col-offset-3 col-lg-8 mt-lg-0 mt-5"> 
                      <form action="{{route('dashboard')}}" method="post" class="main-input well">
                        @csrf   
                        <div class="form-group">
                            <label for="email" class="for-label"><b>E-mail <i>*</i></b></label>
                            <input type="email" placeholder="E-mail" name="email" id="email" required="">
                           </div>
                           <div class="form-group">
                            <label for="password" class="for-label"><b>Mot de passe <i>*</i></b></label>
                            <input type="password" placeholder="" name="password" id="password" required="">
                           </div> 
                          <div class="text-right">
                              <button type="submit" class="btn btn-theme2">Se connecter</button>
                          </div>
                      </form>
                  </div>
                  <!-- //connexion form -->
              </div>
          </div> 
      </div>
  </section>
  <!-- //contact -->

@endsection

@section("js-script")
  
@endsection
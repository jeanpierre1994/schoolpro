@extends('frontend.inc.layout')

@section("title")
Inscription Etudiant || {{env('APP_NAME')}}
@endsection

@section("contenu") 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
<style>
  * {
    margin: 0;
    padding: 0;
}

html {
    height: 100%;
}

/*Background color*/
#grad1 {
    background-color: : ;#9C27B0;
    background-image: ;linear-gradient(120deg, #FF4081, #81D4FA);
}

/*form styles*/
#msform {
    text-align: center;
    position: relative;
    margin-top: 20px;
}

#msform fieldset .form-card {
    background: white;
    border: 0 none;
    border-radius: 0px;
    box-shadow: 0 2px 2px 2px rgba(0, 0, 0, 0.2);
    padding: 20px 40px 30px 40px;
    box-sizing: border-box;
    width: 100%;
    margin: 0 3% 3px 3%;

    /*stacking fieldsets above each other*/
    position: relative;
}

#msform fieldset {
    background: white;
    border: 0 none;
    border-radius: 0.5rem;
    box-sizing: border-box;
    width: 100%;
    margin: 0;
    padding-bottom: 20px;

    /*stacking fieldsets above each other*/
    position: relative;
}

/*Hide all except first fieldset*/
#msform fieldset:not(:first-of-type) {
    display: none;
}

#msform fieldset .form-card {
    text-align: left;
    color: #9E9E9E;
}

#msform input, #msform textarea {
    padding: 0px 8px 4px 8px;
    border: none;
    border-bottom: 1px solid #ccc;
    border-radius: 0px;
    margin-bottom: 25px;
    margin-top: 2px;
    width: 100%;
    box-sizing: border-box;
    font-family: montserrat;
    color: #2C3E50;
    font-size: 16px;
    letter-spacing: 1px;
}

#msform input:focus, #msform textarea:focus {
    -moz-box-shadow: none !important;
    -webkit-box-shadow: none !important;
    box-shadow: ;none !important;
    border: ;none;
    font-weight: bold;
    border-bottom: 2px solid skyblue;
    outline-width: 0;
}

/*Blue Buttons*/
#msform .action-button {
    width: 100px;
    background: skyblue;
    font-weight: bold;
    color: white;
    border: 0 none;
    border-radius: 0px;
    cursor: pointer;
    padding: 10px 5px;
    margin: 10px 5px;
}

#msform .action-button:hover, #msform .action-button:focus {
    box-shadow: 0 0 0 2px white, 0 0 0 3px skyblue;
}

/*Previous Buttons*/
#msform .action-button-previous {
    width: 100px;
    background: #616161;
    font-weight: bold;
    color: white;
    border: 0 none;
    border-radius: 0px;
    cursor: pointer;
    padding: 10px 5px;
    margin: 10px 5px;
}

#msform .action-button-previous:hover, #msform .action-button-previous:focus {
    box-shadow: 0 0 0 2px white, 0 0 0 3px #616161;
}

/*Dropdown List Exp Date*/
select.list-dt {
    border: none;
    outline: 0;
    border-bottom: 1px solid #ccc;
    padding: 2px 5px 3px 5px;
    margin: 2px;
}

select.list-dt:focus {
    border-bottom: 2px solid skyblue;
}

/*The background card*/
.card {
    z-index: 0;
    border: none;
    border-radius: 0.5rem;
    position: relative;
}

/*FieldSet headings*/
.fs-title {
    font-size: 25px;
    color: #2C3E50;
    margin-bottom: 10px;
    font-weight: bold;
    text-align: left;
}

/*progressbar*/
#progressbar {
    margin-bottom: 30px;
    overflow: hidden;
    color: lightgrey;
}

#progressbar .active {
    color: #000000;
}

#progressbar li {
    list-style-type: none;
    font-size: 12px;
    width: 25%;
    float: left;
    position: relative;
}

/*Icons in the ProgressBar*/
#progressbar #account:before {
    font-family: FontAwesome;
    content: "\f023";
}

#progressbar #personal:before {
    font-family: FontAwesome;
    content: "\f007";
}

#progressbar #payment:before {
    font-family: FontAwesome;
    content: "\f09d";
}

#progressbar #confirm:before {
    font-family: FontAwesome;
    content: "\f00c";
}

/*ProgressBar before any progress*/
#progressbar li:before {
    width: 50px;
    height: 50px;
    line-height: 45px;
    display: block;
    font-size: 18px;
    color: #ffffff;
    background: lightgray;
    border-radius: 50%;
    margin: 0 auto 10px auto;
    padding: 2px;
}

/*ProgressBar connectors*/
#progressbar li:after {
    content: '';
    width: 100%;
    height: 2px;
    background: lightgray;
    position: absolute;
    left: 0;
    top: 25px;
    z-index: -1;
}

/*Color number of the step and the connector before it*/
#progressbar li.active:before, #progressbar li.active:after {
    background: skyblue;
}

/*Imaged Radio Buttons*/
.radio-group {
    position: relative;
    margin-bottom: 25px;
}

.radio {
    display:inline-block;
    width: 204;
    height: 104;
    border-radius: 0;
    background: lightblue;
    box-shadow: 0 2px 2px 2px rgba(0, 0, 0, 0.2);
    box-sizing: border-box;
    cursor:pointer;
    margin: 8px 2px; 
}

.radio:hover {
    box-shadow: 2px 2px 2px 2px rgba(0, 0, 0, 0.3);
}

.radio.selected {
    box-shadow: 1px 1px 2px 2px rgba(0, 0, 0, 0.1);
}

/*Fit image in bootstrap div*/
.fit-image{
    width: 100%;
    object-fit: cover;
}
</style>
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
                      <form action="{{route('inscription.store_parent')}}" method="post" class="main-input">
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
                              @foreach ($genres as $item)
                              <option value="{{$item->id}}">{{$item->libelle}}</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="email">Nationalité <i class="text-danger">*</i></label>
                            <select name="nationalite" id="nationalite" class="form-control" required>
                              <option value=""></option>
                              <option value="Béninoise">Béninoise</option> 
                            </select>
                          </div>
                        </div> 
                        <div class="row"> 
                          <div class="form-group col-md-6">
                            <label for="adresse">Adresse <i class="text-danger">*</i></label>
                            <input type="text" name="adresse" id="adresse" required="" maxlength="150">
                          </div>
                          <div class="form-group col-md-6">
                            <label for="password">Mot de passe <i class="text-danger">*</i></label>
                            <input type="password" name="password" id="password" required="" maxlength="150">
                          </div>
                        </div> 
                          <div class="text-right">
                              <button type="submit" class="btn btn-theme2">Suivant</button>
                          </div>
                      </form>

                      <br>

                      <!-- wizard form -->
<!-- MultiStep Form -->
<div class="container-fluid" id="grad1">
  <div class="row justify-content-center mt-0">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 text-center p-0 mt-3 mb-2">
          <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
              <h2><strong>Sign Up Your User Account</strong></h2>
              <p>Fill all form field to go to next step</p>
              <div class="row">
                  <div class="col-md-12 mx-0">
                      <form id="msform" class="" method="post" action="">
                          <!-- progressbar -->
                          <ul id="progressbar">
                              <li class="active" id="account"><strong>Info Parent</strong></li>
                              <li id="personal"><strong>Info Etudiant</strong></li>
                              <li id="payment"><strong>Adresse</strong></li>
                              <li id="confirm"><strong>Etablissement</strong></li>
                          </ul>
                          <!-- fieldsets -->
                          <fieldset>
                              <div class="form-card">
                                  <h2 class="fs-title">Information sur le parent</h2>
                                  <label for="">Nom parent</label>
                                  <input type="text" class="form-control" name="nom_parent" placeholder=""/>
                                  <label for="">Prénoms parent</label>
                                  <input type="text" class="form-control" name="prenom_parent" placeholder="Prénoms parent"/> 
                                  <label for="">Lien parental</label>
                                  <select name="lienparental_id" id="lienparental_id" class="form-control" required>
                                    <option value=""></option>
                                  </select>   
                              </div>
                              <input type="button" name="next" class="next action-button" value="Suivant"/>
                          </fieldset>
                          <fieldset>
                              <div class="form-card">
                                  <h2 class="fs-title">Informartion sur l'étudiant</h2> 
                                  <label for="">Nom</label>
                                  <input type="text" name="nom" id="nom" required="" maxlength="100" required>
                                  <label for="prenoms">Prénoms <i class="text-danger">*</i></label>
                                  <input type="text" name="prenoms" id="prenoms" required=""  maxlength="100" required>
                                  <label for="surnom">Surnom <i class="text-danger"></i></label>
                                  <input type="text" name="surnom" id="surnom" maxlength="100">
                                  <label for="nom_jeune_fille">Nom de jeune fille <i class="text-danger"></i></label>
                                  <input type="text" name="nom_jeune_fille" id="nom_jeune_fille"  maxlength="100">
                                  <label for="ddn">Date Nais. <i class="text-danger">*</i></label>
                                  <input type="date" name="ddn" id="ddn" required="" required>
                                  <label for="lieu_naissance">Lieu Nais. <i class="text-danger">*</i></label>
                                  <input type="text" name="lieu_naissance" id="lieu_naissance" required="" maxlength="150" required> 
                              </div>
                              <input type="button" name="previous" class="previous action-button-previous" value="Précédent"/>
                              <input type="button" name="next" class="next action-button" value="Suivant"/>
                          </fieldset>
                          <fieldset>
                              <div class="form-card">
                                  <h2 class="fs-title">Adresse</h2> 
                                  <label for="telephone">Téléphone étudiant<i class="text-danger">*</i></label>
                                  <input type="number" name="telephone" id="telephone" required="" maxlength="20" required>
                                  <label for="email">E-mail <i class="text-danger">*</i></label>
                                  <input type="text" name="email" id="email" required="" maxlength="100" required >
                                  <label for="genre">Genre <i class="text-danger">*</i></label>
                                  <select name="genre_id" id="genre_id" class="form-control" required>
                                    <option value=""></option> 
                                  </select>
                                  <label for="email">Nationalité <i class="text-danger">*</i></label>
                                  <select name="nationalite_id" id="nationalite_id" class="form-control" required>
                                    <option value=""></option>
                                    <option value="Béninoise">Béninoise</option> 
                                  </select>  
                              </div>
                              <input type="button" name="previous" class="previous action-button-previous" value="Précédent"/>
                              <input type="button" name="make_payment" class="next action-button" value="Suivant"/>
                          </fieldset>
                          <fieldset>
                              <div class="form-card">
                                  <h2 class="fs-title text-center">Etablissement</h2>
                                  <label for="etablissement">Etablissement <i class="text-danger">*</i></label>
                                  <select name="etablissement_id" id="etablissement_id" class="form-control" required>
                                    <option value=""></option>  
                                  </select>    
                                  <label for="site">Site <i class="text-danger">*</i></label>
                                  <select name="site_id" id="site_id" class="form-control" required>
                                    <option value=""></option> 
                                  </select>
                                  <label for="password">Mot de passe <i class="text-danger">*</i></label>
                                  <input type="password" name="password" id="password" required="" maxlength="100" required >
                              </div>
                              <input type="button" name="previous" class="previous action-button-previous" value="Précédent"/>
                              <input type="submit" name="make_payment" class="next action-button" value="Valider"/>
                          </fieldset>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
                      <!-- end wizard form -->
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
    $(document).ready(function(){
    
    var current_fs, next_fs, previous_fs; //fieldsets
    var opacity;
    
    $(".next").click(function(){
        
        current_fs = $(this).parent();
        next_fs = $(this).parent().next();
        
        //Add Class Active
        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
        
        //show the next fieldset
        next_fs.show(); 
        //hide the current fieldset with style
        current_fs.animate({opacity: 0}, {
            step: function(now) {
                // for making fielset appear animation
                opacity = 1 - now;
    
                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                next_fs.css({'opacity': opacity});
            }, 
            duration: 600
        });
    });
    
    $(".previous").click(function(){
        
        current_fs = $(this).parent();
        previous_fs = $(this).parent().prev();
        
        //Remove class active
        $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
        
        //show the previous fieldset
        previous_fs.show();
    
        //hide the current fieldset with style
        current_fs.animate({opacity: 0}, {
            step: function(now) {
                // for making fielset appear animation
                opacity = 1 - now;
    
                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                previous_fs.css({'opacity': opacity});
            }, 
            duration: 600
        });
    });
    
    /*$('.radio-group .radio').click(function(){
        $(this).parent().find('.radio').removeClass('selected');
        $(this).addClass('selected');
    });*/
    
    /*$(".submit").click(function(){
        return true;
    })*/
        
    });
  </script>
@endsection
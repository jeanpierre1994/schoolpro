@extends('frontend.inc.layout')

@section("title")
Profil Parent || {{env('APP_NAME')}}
@endsection

@section("contenu")  
<section class="w3l-contact-breadcrum">
    <div class="breadcrum-bg py-sm-5 py-4">
      <div class="container py-lg-3">
        <h2>Profil Parent</h2>
        <p>Profil Parent</p>
      </div>
    </div>
</section> 

<!-- contact -->
<section class="w3l-contacts-12" id="contact">
    <div class="contact-top pt-5">
        <div class="container py-md-3">
            
            <div class="row cont-main-top">
               
                <!-- profil parent -->
                <div class="contact col-lg-4">
                    <div class="cont-add add-2"> 
                        <div class="cont-add-rgt">
                            <h4>Code Parent</h4>
                            <a href="#mailto:info@example.com">
                                <p class="contact-text-sub">MT-000001</p>
                            </a>
                            </div>
                            <div class="cont-add-lft">
                                <span class="fa fa-envelope" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="cont-add add-2"> 
                        <div class="cont-add-rgt">
                            <h4>Nom & Prénoms</h4>
                            <a href="#mailto:info@example.com">
                                <p class="contact-text-sub">DOSSOU Jeannette</p>
                            </a>
                            </div>
                            <div class="cont-add-lft">
                                <span class="fa fa-envelope" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="cont-subs">
                        <div class="cont-add"> 
                           <div class="cont-add-rgt">
                            <h4>Address:</h4>
                            <p class="contact-text-sub">BP OO229 Cotonou Bénin</p>
                        </div>
                        <div class="cont-add-lft">
                            <span class="fa fa-map-marker" aria-hidden="true"></span>
                       </div>
                    </div>
                        <div class="cont-add add-2">
                            
                           <div class="cont-add-rgt">
                            <h4>Email:</h4>
                            <a href="#mailto:info@example.com">
                                <p class="contact-text-sub">info@example.com</p>
                            </a>
                        </div>
                        <div class="cont-add-lft">
                            <span class="fa fa-envelope" aria-hidden="true"></span>
                       </div>
                    </div>
                        <div class="cont-add">
                           
                            <div class="cont-add-rgt">
                                 <h4>Phone:</h4>
                                 <a href="tel:+7-800-999-800">
                                    <p class="contact-text-sub">+229-90-99-88-99</p>
                                 </a>
                            </div>
                            <div class="cont-add-lft">
                                <span class="fa fa-phone" aria-hidden="true"></span>
                           </div>
                        </div>
                        <div class="cont-add add-3">
                           
                            <div class="cont-add-rgt">
                                 <h4>Find Us On</h4>
                                 <div class="main-social-1 mt-2">
                                    <a href="#facebook" class="facebook"><span class="fa fa-facebook"></span></a>
                                    <a href="#twitter" class="twitter"><span class="fa fa-twitter"></span></a>
                                    <a href="#instagram" class="instagram"><span class="fa fa-instagram"></span></a>
                                    <a href="#google-plus" class="google-plus"><span class="fa fa-google-plus"></span></a>
                                    <a href="#linkedin" class="linkedin"><span class="fa fa-linkedin"></span></a>
                                </div>
                            </div>
                            <div class="cont-add-lft">
                               
                           </div>
                        </div>
                    </div>
                </div>
                <!-- //profil parent -->
                 <!-- liste étudiant -->
                 <div class="contacts12-main col-lg-8 mt-lg-0 mt-5"> 
                    <div class="cont-add-rgt">
                        <h4>Liste des étudiants </h4> 
                   </div>
                   <div class="text-right">
                    <a href="{{route('ajouter-etudiant')}}">
                        <button type="button" class="btn btn-theme2">Ajouter membre de famille</button>
                    </a>
                </div>
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Nom</th>
                                <th>Prénoms</th>
                                <th>Téléphone</th>
                                <th>E-mail</th>
                                <th>Lieu de naissance</th>
                                <th>Lien parental</th>
                                <th>Etablissement</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($etudiants as $item) 
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$item->nom}}</td>
                                <td>{{$item->prenoms}}</td>
                                <td>{{$item->tel}}</td>
                                <td>{{$item->email}}</td>
                                <td>{{$item->lieunais}}</td>
                                <td>{{$item->lien_parental ? $item->getLienparental->libelle : ''}}</td>
                                <td>{{$item->etablissement_id ? $item->getEtablissement->sigle : ''}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- //liste étudiant -->
            </div>
        </div> 
    </div>
</section>
<!-- //contact -->

@endsection

@section("js-script")
  <script>
    $(document).ready(function(){
     
    });
  </script>
@endsection
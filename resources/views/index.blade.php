@extends('frontend.inc.layout')

@section("title")
Accueil || {{env('APP_NAME')}}
@endsection

@section("main-slide") 
<!-- main slide -->
@include('frontend.inc.main_slide')
<!-- end main slide -->
@endsection

@section("contenu") 
<section class="w3l-feature-3" id="features">
	<div class="grid top-bottom mb-lg-5 pb-lg-5">
		<div class="container">
			
			<div class="middle-section grid-column text-center">
				<div class="three-grids-columns">
					<span class="fa fa-laptop"></span>
					<h4>Apprenez Avec Nos Cours En Ligne</h4>
					<p>Notre plateforme de formation en ligne est facile à utiliser et accessible depuis n’importe où dans le monde. Vous pouvez accéder à vos cours en ligne à tout moment, n’importe où, sur votre ordinateur de bureau, votre tablette ou votre téléphone portable.

                        Inscrivez-vous dès aujourd’hui et commencez votre voyage d’apprentissage en ligne avec nous !</p>
					<a href="#" class="btn btn-secondary btn-theme3 mt-4">Inscription </a>
				</div>
				<div class="three-grids-columns">
					<span class="fa fa-users"></span>
					<h4>Corps Professoral Hautement Qualifié</h4>
					<p>Nous avons une équipe d’enseignants professionnels, tous hautement qualifiés dans leur domaine. Ils sont passionnés par l’enseignement et sont déterminés à aider les élèves à réussir.</p>
					<a href="#" class="btn btn-secondary btn-theme3 mt-4">Voir Plus </a>
				</div>
				<div class="three-grids-columns">
					<span class="fa fa-book"></span>
					<h4>Bibliothèque Numérique</h4>
					<p> Notre bibliothèque numérique propose une vaste collection de livres éducatifs pour tous les niveaux. De plus, notre magasin en ligne propose une sélection de matériel pédagogique, y compris des fournitures de bureau et des accessoires pour la maison, pour compléter votre expérience d’apprentissage.</p>
					<a href="#" class="btn btn-secondary btn-theme3 mt-4">Voir Plus </a>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- features-4 block -->
<section class="w3l-index1" id="about">
	<div class="calltoaction-20  py-5 editContent">
		<div class="container py-md-3">
		
			<div class="calltoaction-20-content row">
				<div class="column center-align-self col-lg-6 pr-lg-5">
					<h5 class="editContent">Bienvenue Dans Notre Campus</h5>
					<p class="more-gap editContent"> Bienvenue sur notre application éducative en ligne, qui offre une expérience d’apprentissage unique pour tous. Avec des cours en ligne de qualité supérieure, des outils de collaboration en temps réel, et un accès facile à une bibliothèque numérique riche en contenu, nous sommes fiers d’offrir une éducation de qualité supérieure à tous nos utilisateurs.</p>
						<p class="more-gap editContent">Nous sommes ravis de vous accueillir sur notre application éducative en ligne, et nous sommes impatients de travailler avec vous pour offrir une expérience d’apprentissage exceptionnelle. </p>
							<a class="btn btn-secondary btn-theme2 mt-3" href="#"> Voir Plus</a>
				</div>
				<div class="column ccont-left col-lg-6">
					<img src="{{ asset("frontpage/assets/images/g1.jpg") }}" class="img-responsive" alt="">
				</div>
			</div>
		</div>
	</div>
</section>
<!-- features-4 block -->
<section class="services-12" id="course">
	<div class="form-12-content">
		<div class="container">
			<div class="grid grid-column-2 ">
				
				<div class="column1">
					<div class="heading">
						<h3 class="head text-white">Postulez Dès Maintenant Pour Des Bourses d'Etudes</h3>
						<h4>Candidature Pour La Rentrée d'automne 2023! </h4>
						<p class="my-3 text-white">Nous sommes ravis d’annoncer que les candidatures pour la rentrée universitaire de l’automne 2019 sont maintenant ouvertes. Si vous êtes un étudiant à la recherche d’une éducation de qualité, notre application est là pour vous aider. Avec une large gamme de cours en ligne et des bourses d’études disponibles, nous offrons une éducation de qualité supérieure à des prix abordables. N’attendez plus pour postuler, notre processus de candidature est simple et facile. Rejoignez notre communauté d’étudiants passionnés et atteignez vos objectifs éducatifs avec notre application</p>
					  </div>
					</div>
					<div class="column2">
						<a class="btn btn-secondary btn-theme2 mt-3" href="#"> Postulez Ici</a>
					</div>
			</div>
		</div>
	</div>
</section>

<!--  form-12 -->
<section class="w3l-form-12">
		<div class="form-12-content py-5" id="services">
			<div class="container py-md-3">
				<div class="grid grid-column-2 py-md-5">
						
					<div class="column1">
						<h4 class="tagline">Find your course</h4>
						<p>Fill in below form to find your courses</p>
							<form action="/" method="Get">
								<div class="">
									<input type="text" name="name" class="form-input" placeholder="Course Name">
								</div>
								<div class="">
									<select id="sel1">
										<option>Category</option>
										<option>Computer</option>
										<option>Science</option>
										<option>History</option>
										<option>Economics</option>
									  </select>
								</div>
								
								
								<button type="submit" class="btn btn-secondary btn-theme2">Submit</button>
							</form>
						</div>
						<div class="column2">
						<div class="row">
							<div class="col-md-3 col-sm-6 col-6">
								<a href="#"><div class="courses-item">
									<span class="fa fa-male"></span>
									<p>Socioligy</p>
								</div></a>
							</div>
							<div class="col-md-3 col-sm-6 col-6">
								<a href="#"><div class="courses-item">
									<span class="fa fa-suitcase"></span>
									<p>Business</p>
								</div></a>
							</div>
							<div class="col-md-3 col-sm-6 col-6 mt-md-0 mt-4">
								<a href="#"><div class="courses-item">
									<span class="fa fa-code"></span>
									<p>Web Dev</p>
								</div></a>
							</div>
							<div class="col-md-3 col-sm-6 col-6 mt-md-0 mt-4">
								<a href="#"><div class="courses-item">
									<span class="fa fa-flask"></span>
									<p>Science</p>
								</div></a>
							</div>
							<div class="col-md-3 col-sm-6 col-6 mt-4">
								<a href="#"><div class="courses-item mt-2">
									<span class="fa fa-money"></span>
									<p>Ecomomics</p>
								</div></a>
							</div>
							<div class="col-md-3 col-sm-6 col-6 mt-4">
								<a href="#"><div class="courses-item mt-2">
									<span class="fa fa-gg"></span>
									<p>Biology</p>
								</div></a>
							</div>
							<div class="col-md-3 col-sm-6 col-6 mt-4">
								<a href="#"><div class="courses-item mt-2">
									<span class="fa fa-desktop"></span>
									<p>Computing</p>
								</div></a>
							</div>
							<div class="col-md-3 col-sm-6 col-6 mt-4">
								<a href="#"><div class="courses-item mt-2">
									<span class="fa fa-mouse-pointer"></span>
									<p>Web Design</p>
								</div></a>
							</div>
						</div>
						</div>
				</div>
			</div>
		</div>
	</section>
<!-- // form-12 -->



 <!-- specifications -->
    <section class="w3l-index2">
        <div class="main-w3 py-5" id="stats">
            <div class="container py-lg-3">
               <div class="row main-cont-wthree-fea">
                    <div class="col-lg-3 col-sm-6">
                        <div class="grids-speci1">
                            <h3 class="title-spe">60</h3>
                            <p>PROFESSIONAL <br>INSTRUCTORS</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 mt-sm-0 mt-4">
                        <div class="grids-speci1">
                            <h3 class="title-spe">18</h3>
                            <p> NEW COURSES <br>EVERY YEAR</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6  mt-lg-0 mt-4">
                        <div class="grids-speci1">
                            <h3 class="title-spe">34</h3>
                            <p>LIVE SESSIONS <br>EVERY MONTH</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 mt-lg-0 mt-4">
                        <div class="grids-speci1">
                            <h3 class="title-spe">20</h3>
                            <p>REGISTERED <br>STUDENTS</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- //specifications -->
    </section>
<!-- customers4 block -->
<section class="w3l-customers-4" id="testimonials">
  <div id="customers4-block" class="py-5">
    <div class="container py-md-3">
  
     <div class="section-title align-center row">
      <div class="item-top col-md-6 pr-md-5">
        <div class="heading">
          <h3 class="head text-white">Avis de nos étudiants </h3>
          <p class="my-3 head text-white">Nous croyons que l’éducation est la clé du succès et nous sommes fiers de contribuer à améliorer l’expérience éducative de chaque centre d’éducation. Essayez notre application dès maintenant et découvrez comment elle peut simplifier la gestion de votre système éducatif !</p>
            <p class="my-3 head text-white"> N’attendez plus pour vous inscrire et découvrir tous les avantages que notre application peut vous offrir. Inscrivez-vous dès maintenant et rejoignez notre communauté en pleine croissance !</p>
          </div>
     </div>
          <div class="item-top col-md-6 mt-md-0 mt-4">
            <div class="item text-center">
             <div class="imgTitle">
               <img src="{{ asset("frontpage/assets/images/c3.jpg") }}" class="img-responsive" alt="" />
              </div>
              <h6 class="mt-3">Jessey Rosey</h6>
              <p class="">Etudiante</p>
              <p>J’utilise l’application de gestion scolaire depuis quelques mois maintenant et je suis impressionné par la facilité d’utilisation et la clarté de l’interface. Je peux facilement suivre mes notes, mes absences et mes devoirs en un seul endroit, ce qui me permet de mieux gérer mon temps
                Je recommande fortement cette application à tous les étudiants qui cherchent à améliorer leur expérience d'apprentissage 
              </p>
              
          </div>
         </div>
    </div>
  </div>
  </div>
</section>

<section class="w3l-price-2" id="news">
    <div class="price-main py-5">
        <div class="container py-md-3">
             <div class="pricing-style-w3ls row py-md-5">
              <div class="pricing-chart col-lg-6">
                <h3 class="">Latest Posts</h3>
                <div class="tatest-top mt-md-5 mt-4">
                        <div class="price-box btn-layout bt6">
                            <div class="grid grid-column-2">
                                    <div class="column-6">
                                            <img src="{{ asset("frontpage/assets/images/g9.jpg") }}" alt="" class="img-fluid">
                                        </div>
                                <div class="column1">
                                   
                                    <div class="job-info">
                                        <h6 class="pricehead"><a href="#">Début des cours de Vacances </a></h6>
                                        <h5>April 25, 2020</h5>
                                        <p>Deux mois. Trois (3) à quatre (4) cours disponibles</p>
                                    </div>
                                </div>
                               
                            </div>
                        </div>
                        <div class="price-box btn-layout bt6 top-middle-1">
                            <div class="grid grid-column-2">
                                    <div class="column-6">
                                            <img src="{{ asset("frontpage/assets/images/g10.jpg") }}" alt="" class="img-fluid">
                                        </div>
                                <div class="column1">
                                   <div class="job-info">
                                        <h6 class="pricehead"><a href="#">	
                                            A propos de l'Intelligence Artificielle</a></h6>
                                       <h5>March 25, 2020</h5>
                                       <p>Conférence sur l'intelligence artificielle aujourd'hui ! Soyez nombreux !</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="price-box btn-layout bt6">
                            <div class="grid grid-column-2">
                                    <div class="column-6">
                                            <img src="{{ asset("frontpage/assets/images/g8.jpg") }}" alt="" class="img-fluid">
                                        </div>
                                <div class="column1">
                                  
                                    <div class="job-info">
                                        <h6 class="pricehead"><a href="#">	
                                            Nouveau calendrier des examens </a></h6>
                                        <h5>February 25, 2020</h5>
                                        <p>Calendrier des examens disponibles pour faciliter la gestion du temps de révision</p>
                                    </div>
                                </div>
                                
                                
                            </div>
                        </div>
                    </div>
                    <div class="text-right mt-4">
                        <a class="btn btn-secondary btn-theme2" href="#">Voir Plus</a>
                      </div>
                    </div>
                    <div class="w3l-faq-page col-lg-6 pl-3 pl-lg-5 mt-lg-0 mt-5">
                        <h3 class="">Evènements à venir</h3>
                        <div class="events-top mt-md-5 mt-4">
                            <div class="events-top-left">
                                    <div class="icon-top">
                                        <h3>20</h3>
                                        <p>Nov</p>
                                        <span>2020</span>
                                    </div>
                            </div>
                            <div class="events-top-right">
                                <h6 class="pricehead"><a href="#">	
                                    Annonce des résultats de fin d'année</a></h6>
                                    <p class="mb-2 mt-3">Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nulla mollis dapibus nunc, ut rhoncus turpis sodales quis. Integer sit amet mattis quam.</p>
                                    <li>07:00 - 10:00 </li>
                                    <li class="melb">Melbourne, Australia</li>
                            </div>
                        </div>
                        <div class="events-top mt-4">
                            <div class="events-top-left">
                                    <div class="icon-top">
                                        <h3>25</h3>
                                        <p>Nov</p>
                                        <span>2020</span>
                                    </div>
                            </div>
                            <div class="events-top-right">
                                <h6 class="pricehead"><a href="#">	
                                   Sortie Interne : Direction le Ghana ! </a></h6>
                                    <p class="mb-2 mt-3">Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nulla mollis dapibus nunc, ut rhoncus turpis sodales quis. Integer sit amet mattis quam.</p>
                                    <li>07:00 - 10:00 </li>
                                    <li class="melb">Melbourne, Australia</li>
                            </div>
                        </div>
                        <div class="text-right mt-4">
                          <a class="btn btn-secondary btn-theme2" href="#"> Voir Plus</a>
                        </div>
                      </div>
            </div>
        </div>
    </div>
</section>
<!-- grids block 5 -->

@endsection

@section("js-script")
  
@endsection
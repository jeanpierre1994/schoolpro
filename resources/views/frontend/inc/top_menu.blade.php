
<!-- Top Menu 1 -->
<section class="w3l-top-menu-1">
	<div class="top-hd">
		<div class="container">
	<header class="row top-menu-top">
		<div class="accounts col-md-9 col-6">
				<li class="top_li"><span class="fa fa-phone"></span><a href="#">+229 {{$etablissement->telephone ? $etablissement->telephone : '97000000'}}</a> </li>
				<li class="top_li1"><span class="fa fa-envelope-o"></span> <a href="mailto:{{$etablissement->email ? $etablissement->email : 'info@mail.com'}}" class="mail"> {{$etablissement->email ? $etablissement->email : 'info@mail.com'}}</a>	</li>
		</div>
		<div class="social-top col-md-3 col-6">
      @if (!empty(auth()->user()->id)) 
      <a href="{{route('check_dashboard')}}" class="btn btn-success btn-theme4">Mon compte</a>
      <a href="{{route('signout')}}" class="btn btn-secondary btn-theme4">Se déconnecter</a>
      @else 
      <a href="{{route('authentification')}}" class="btn btn-secondary btn-theme4">Se connecter</a>
      @endif
			
		</div>
	</header>
</div>
</div>
</section>
<!-- //Top Menu 1 -->

<section class="w3l-bootstrap-header">
    <nav class="navbar navbar-expand-lg navbar-light py-lg-2 py-2">
      <div class="container">
        <a class="navbar-brand" href="{{route('index')}}"><span class="fa fa-pencil-square-o "></span> {{$etablissement->sigle ? $etablissement->sigle : 'School Pro'}}</a>
        <!-- if logo is image enable this   
      <a class="navbar-brand" href="##">
          <img src="image-path" alt="Your logo" title="Your logo" style="height:35px;" />
      </a> -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon fa fa-bars"></span>
        </button>
  
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mx-auto">
            <li class="nav-item">
              <a class="nav-link" href="{{route('index')}}">Accueil</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">A propos</a>
            </li>
              <li class="nav-item">
              <a class="nav-link" href="#l">FAQ</a>
            </li>
          
            <li class="nav-item">
              <a class="nav-link" href="#">Contact</a>
            </li>
          </ul>
          {{--<form action="#" class="form-inline position-relative my-2 my-lg-0">
            <input class="form-control search" type="search" placeholder="Recherche..." aria-label="Search" required="">
            <button class="btn btn-search position-absolute" type="submit"><span class="fa fa-search" aria-hidden="true"></span></button>
          </form>--}}
        </div>
      </div>
    </nav>
  </section>
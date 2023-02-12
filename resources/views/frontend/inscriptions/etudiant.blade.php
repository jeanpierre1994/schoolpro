@extends('frontend.inc.layout')

@section("title")
Inscription Etudiant || {{env('APP_NAME')}}
@endsection

@section("contenu") 
<style>
  body {
  background-color: #fbfbfb;
}
@media (min-width: 991.98px) {
  main {
    padding-left: 240px;
  }
}

/* Sidebar */
.sidebar {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  padding: 58px 0 0; /* Height of navbar */
  box-shadow: 0 2px 5px 0 rgb(0 0 0 / 5%), 0 2px 10px 0 rgb(0 0 0 / 5%);
  width: 240px;
  z-index: 600;
}

@media (max-width: 991.98px) {
  .sidebar {
    width: 100%;
  }
}
.sidebar .active {
  border-radius: 5px;
  box-shadow: 0 2px 5px 0 rgb(0 0 0 / 16%), 0 2px 10px 0 rgb(0 0 0 / 12%);
}

.sidebar-sticky {
  position: relative;
  top: 0;
  height: calc(100vh - 48px);
  padding-top: 0.5rem;
  overflow-x: hidden;
  overflow-y: auto; /* Scrollable contents if viewport is shorter than content. */
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
                <h3 class="mb-5">Formulaire d'inscription des étudiants</h3>
                   <!-- inscription étudiant form -->
                   <div class="contacts12-main col-offset-3 col-lg-8 mt-lg-0 mt-5"> 
                      <form action="{{route('inscription.store_etudiant')}}" method="post" class="main-input">
                        @csrf
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

  <!-- bmad -->
   <!-- Start your project here-->
<div class="container">
    <div class="d-flex justify-content-center align-items-center" style="height: 100vh">
      <div class="card text-center">
        <div class="card-header">INSCRIPTION DES ETUDIANTS</div>
        <div class="card-body">
          <h5 class="card-title">_ _ _</h5>
          <form class="row g-3 needs-validation" novalidate>
            <div class="col-md-4">
              <div class="form-outline">
                <input type="text" class="form-control" id="validationCustom01" value="Mark" required />
                <label for="validationCustom01" class="form-label">First name</label>
                <div class="valid-feedback">Looks good!</div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-outline">
                <input type="text" class="form-control" id="validationCustom02" value="Otto" required />
                <label for="validationCustom02" class="form-label">Last name</label>
                <div class="valid-feedback">Looks good!</div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="input-group form-outline">
                <span class="input-group-text" id="inputGroupPrepend">@</span>
                <input type="text" class="form-control" id="validationCustomUsername" aria-describedby="inputGroupPrepend" required />
                <label for="validationCustomUsername" class="form-label">Username</label>
                <div class="invalid-feedback">Please choose a username.</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-outline">
                <input type="text" class="form-control" id="validationCustom03" required />
                <label for="validationCustom03" class="form-label">City</label>
                <div class="invalid-feedback">Please provide a valid city.</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-outline">
                <input type="text" class="form-control" id="validationCustom05" required />
                <label for="validationCustom05" class="form-label">Zip</label>
                <div class="invalid-feedback">Please provide a valid zip.</div>
              </div>
            </div>
            <div class="col-12">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required />
                <label class="form-check-label" for="invalidCheck">Agree to terms and conditions</label>
                <div class="invalid-feedback">You must agree before submitting.</div>
              </div>
            </div>
            <div class="col-12">
              <button class="btn btn-primary" type="submit">Submit form</button>
            </div>
          </form>
        </div>
        <div class="card-footer text-muted">2 days ago</div>
      </div> 
    </div>
</div>
  <!-- end bmad -->

  <!-- sidebar -->
<!--Main Navigation-->
<header>
  <!-- Sidebar -->
  <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
    <div class="position-sticky">
      <div class="list-group list-group-flush mx-3 mt-4">
        <a
          href="#"
          class="list-group-item list-group-item-action py-2 ripple"
          aria-current="true"
        >
          <i class="fas fa-tachometer-alt fa-fw me-3"></i><span>Main dashboard</span>
        </a>
        <a href="#" class="list-group-item list-group-item-action py-2 ripple active">
          <i class="fas fa-chart-area fa-fw me-3"></i><span>Webiste traffic</span>
        </a>
        <a href="#" class="list-group-item list-group-item-action py-2 ripple"
          ><i class="fas fa-lock fa-fw me-3"></i><span>Password</span></a
        >
        <a href="#" class="list-group-item list-group-item-action py-2 ripple"
          ><i class="fas fa-chart-line fa-fw me-3"></i><span>Analytics</span></a
        >
        <a href="#" class="list-group-item list-group-item-action py-2 ripple">
          <i class="fas fa-chart-pie fa-fw me-3"></i><span>SEO</span>
        </a>
        <a href="#" class="list-group-item list-group-item-action py-2 ripple"
          ><i class="fas fa-chart-bar fa-fw me-3"></i><span>Orders</span></a
        >
        <a href="#" class="list-group-item list-group-item-action py-2 ripple"
          ><i class="fas fa-globe fa-fw me-3"></i><span>International</span></a
        >
        <a href="#" class="list-group-item list-group-item-action py-2 ripple"
          ><i class="fas fa-building fa-fw me-3"></i><span>Partners</span></a
        >
        <a href="#" class="list-group-item list-group-item-action py-2 ripple"
          ><i class="fas fa-calendar fa-fw me-3"></i><span>Calendar</span></a
        >
        <a href="#" class="list-group-item list-group-item-action py-2 ripple"
          ><i class="fas fa-users fa-fw me-3"></i><span>Users</span></a
        >
        <a href="#" class="list-group-item list-group-item-action py-2 ripple"
          ><i class="fas fa-money-bill fa-fw me-3"></i><span>Sales</span></a
        >
      </div>
    </div>
  </nav>
  <!-- Sidebar -->

  <!-- Navbar -->
  <nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
    <!-- Container wrapper -->
    <div class="container-fluid">
      <!-- Toggle button -->
      <button
        class="navbar-toggler"
        type="button"
        data-mdb-toggle="collapse"
        data-mdb-target="#sidebarMenu"
        aria-controls="sidebarMenu"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <i class="fas fa-bars"></i>
      </button>

      <!-- Brand -->
      <a class="navbar-brand" href="#">
        <img
          src="https://mdbcdn.b-cdn.net/img/logo/mdb-transaprent-noshadows.webp"
          height="25"
          alt="MDB Logo"
          loading="lazy"
        />
      </a>
      <!-- Search form -->
      <form class="d-none d-md-flex input-group w-auto my-auto">
        <input
          autocomplete="off"
          type="search"
          class="form-control rounded"
          placeholder='Search (ctrl + "/" to focus)'
          style="min-width: 225px;"
        />
        <span class="input-group-text border-0"><i class="fas fa-search"></i></span>
      </form>

      <!-- Right links -->
      <ul class="navbar-nav ms-auto d-flex flex-row">
        <!-- Notification dropdown -->
        <li class="nav-item dropdown">
          <a
            class="nav-link me-3 me-lg-0 dropdown-toggle hidden-arrow"
            href="#"
            id="navbarDropdownMenuLink"
            role="button"
            data-mdb-toggle="dropdown"
            aria-expanded="false"
          >
            <i class="fas fa-bell"></i>
            <span class="badge rounded-pill badge-notification bg-danger">1</span>
          </a>
          <ul
            class="dropdown-menu dropdown-menu-end"
            aria-labelledby="navbarDropdownMenuLink"
          >
            <li>
              <a class="dropdown-item" href="#">Some news</a>
            </li>
            <li>
              <a class="dropdown-item" href="#">Another news</a>
            </li>
            <li>
              <a class="dropdown-item" href="#">Something else here</a>
            </li>
          </ul>
        </li>

        <!-- Icon -->
        <li class="nav-item">
          <a class="nav-link me-3 me-lg-0" href="#">
            <i class="fas fa-fill-drip"></i>
          </a>
        </li>
        <!-- Icon -->
        <li class="nav-item me-3 me-lg-0">
          <a class="nav-link" href="#">
            <i class="fab fa-github"></i>
          </a>
        </li>

        <!-- Icon dropdown -->
        <li class="nav-item dropdown">
          <a
            class="nav-link me-3 me-lg-0 dropdown-toggle hidden-arrow"
            href="#"
            id="navbarDropdown"
            role="button"
            data-mdb-toggle="dropdown"
            aria-expanded="false"
          >
            <i class="flag-united-kingdom flag m-0"></i>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
            <li>
              <a class="dropdown-item" href="#"
                ><i class="flag-united-kingdom flag"></i>English
                <i class="fa fa-check text-success ms-2"></i
              ></a>
            </li>
            <li><hr class="dropdown-divider" /></li>
            <li>
              <a class="dropdown-item" href="#"><i class="flag-poland flag"></i>Polski</a>
            </li>
            <li>
              <a class="dropdown-item" href="#"><i class="flag-china flag"></i>中文</a>
            </li>
            <li>
              <a class="dropdown-item" href="#"><i class="flag-japan flag"></i>日本語</a>
            </li>
            <li>
              <a class="dropdown-item" href="#"><i class="flag-germany flag"></i>Deutsch</a>
            </li>
            <li>
              <a class="dropdown-item" href="#"><i class="flag-france flag"></i>Français</a>
            </li>
            <li>
              <a class="dropdown-item" href="#"><i class="flag-spain flag"></i>Español</a>
            </li>
            <li>
              <a class="dropdown-item" href="#"><i class="flag-russia flag"></i>Русский</a>
            </li>
            <li>
              <a class="dropdown-item" href="#"><i class="flag-portugal flag"></i>Português</a>
            </li>
          </ul>
        </li>

        <!-- Avatar -->
        <li class="nav-item dropdown">
          <a
            class="nav-link dropdown-toggle hidden-arrow d-flex align-items-center"
            href="#"
            id="navbarDropdownMenuLink"
            role="button"
            data-mdb-toggle="dropdown"
            aria-expanded="false"
          >
            <img
              src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img (31).webp"
              class="rounded-circle"
              height="22"
              alt="Avatar"
              loading="lazy"
            />
          </a>
          <ul
            class="dropdown-menu dropdown-menu-end"
            aria-labelledby="navbarDropdownMenuLink"
          >
            <li>
              <a class="dropdown-item" href="#">My profile</a>
            </li>
            <li>
              <a class="dropdown-item" href="#">Settings</a>
            </li>
            <li>
              <a class="dropdown-item" href="#">Logout</a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
    <!-- Container wrapper -->
  </nav>
  <!-- Navbar -->
</header>
<!--Main Navigation-->

<!--Main layout-->
<main style="margin-top: 58px;">
  <div class="container pt-4"></div>
</main>
<!--Main layout-->
  <!-- end sidebar -->
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

// validate form
// Example starter JavaScript for disabling form submissions if there are invalid fields
(() => {
  'use strict';

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  const forms = document.querySelectorAll('.needs-validation');

  // Loop over them and prevent submission
  Array.prototype.slice.call(forms).forEach((form) => {
    form.addEventListener('submit', (event) => {
      if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
      }
      form.classList.add('was-validated');
    }, false);
  });
})();

  </script>
@endsection
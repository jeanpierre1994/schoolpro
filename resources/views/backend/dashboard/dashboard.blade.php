
@extends('backend/include/layout')
<!-- title -->
@section('title') Dashboard || {{env('APP_NAME')}} @endsection

@section('fil-arial') 
<div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Accueil</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
      </ol>
    </nav>
  </div> 
@endsection

@section('contenu') 
@php
//Variable pour facilement récupérer le role du user 
   // $user = Auth()->user();
@endphp
<section class="section dashboard">
    <div class="row">
 
      <!-- Left side columns -->
      <div class="col-lg-12">
        <div class="row"> 
          <!-- Sales Card --> 
            <div class="col-xxl-4 col-md-3">
              <a href="#" style="text-decoration: none;">
              <div class="card info-card sales-card"> 
                <div class="card-body">
                  <h5 class="card-title">Dossiers en attente <span></span></h5> 
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="ri-user-3-fill"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{ $dossierEnAttente }}</h6> 
                    </div>
                  </div>
                </div> 
              </div>
            </a>
            </div>
          <!-- End Sales Card -->

          <!-- total Card -->
            <div class="col-xxl-4 col-md-3">
              <a href="#" style="text-decoration: none;">
              <div class="card info-card revenue-card">  
                <div class="card-body">
                  <h5 class="card-title">Dossiers validé <span></span></h5> 
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="ri-user-3-fill text-dark"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{ $dossierValide }}</h6>  
                    </div>
                  </div>
                </div>
  
              </div>
            </a>
            </div>
          
          <!-- End total Card -->
 
          <!--  Card -->
            <div class="col-xxl-3 col-md-3">
              <a href="#" style="text-decoration: none;">
              <div class="card info-card revenue-card">  
                <div class="card-body">
                  <h5 class="card-title">Dossiers rejetés <span></span></h5> 
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-person-x-fill"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{ $dossierRejete }}</h6> 
                    </div>
                  </div>
                </div>
  
              </div>
            </a>
            </div>
          
          <!-- End  Card --> 
 

        </div>
      </div><!-- End Left side columns --> 
 
    </div>
  </section>
 
@endsection

<!-- jsScript -->
@section('script-js')

<script>

      // remove menu active
      $("ul").removeClass('show');
      $("ul li a").removeClass('active');
      // active menu 
      $("#dashboard").removeClass('collapsed');
 
  

function ConvertMonth($month){
  switch ($month) {
    case "01":
      return "Janvier";
      break;

      case "02":
        return "Février";
      break;
      case "03":
        return "Mars";
      break;
      case "04":
        return "Avril";
      break;
      case "05":
        return "Mai";
      break;
      case "06":
        return "Juin";
      break;
      case "07":
        return "Juillet";
      break;
      case "08":
        return "Août";
      break;
      case "09":
        return "Septembre";
      break;
      case "10":
        return "Octobre";
      break;
      case "11":
        return "Novembre";
      break;
      case "12":
        return "Décembre";
      break;

    default:
      break;
  }
}
</script>
<!-- End Area Chart -->
@endsection
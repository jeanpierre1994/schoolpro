@extends('frontend.inc.user_layout')

@section('title')
    Nouveau Dossier Etudiant || {{ env('APP_NAME') }}
@endsection

@section('contenu') 
<section style="background-color: #eee;">
    <div class="container py-1">
      <div class="row">
        <div class="col">
          <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-4">
            <ol class="breadcrumb mb-0">
              <li class="breadcrumb-item"><a href="{{route('dashboard_etudiant')}}">Accueil</a></li> 
              <li class="breadcrumb-item"><a href="{{route('etudiant.dossiers')}}">Dossier</a></li> 
              <li class="breadcrumb-item active" aria-current="page"> Nouveau</li>
            </ol>
          </nav>
        </div>
      </div>
  
      <div class="row">
        <div class="col-lg-12">
          <div class="card mb-4">
            <h5 class="card-header">NOUVEAU DOSSIER</h5>
            <div class="card-body text-center">
              @if ($errors->any())
              <div class="alert alert-danger">
                  <strong>Error!</strong>
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
          @endif
      <form action="{{route('etudiant.dossierExpress-store')}}" method="POST" class="row g-3 needs-validation" novalidate enctype="multipart/form-data"> 
        @csrf
        <input type="hidden" name="etudiant_id" id="etudiant_id" class="form-control" value="{{$etudiant->id}}">
          
        <div class="form-row">
              <div class="col-md-6 mb-1">
                  <div class="input-group form-outline">
                      <span class="input-group-text" id="inputGroupPrepend"><i class="fas fa-user-alt fa-fw me-3"></i></span>
                      <input type="text" class="form-control" id="nom" value="{{ $etudiant->nom }}" required aria-describedby="inputGroupPrepend"
                          required name="nom" minlength="2" maxlength="150"/>
                      <label for="nom" class="form-label"><b>Nom <i class="text-danger">*</i></b></label>
                      <div class="invalid-feedback">Champ obligatoire.</div>
                      <div class="valid-feedback"></div>
                  </div>
              </div>
              <div class="col-md-6 mb-1">
                  <div class="input-group form-outline">
                      <span class="input-group-text" id="inputGroupPrepend"><i class="fas fa-user-alt fa-fw me-3"></i></span>
                      <input type="text" class="form-control" id="prenoms" required aria-describedby="inputGroupPrepend"
                          required name="prenoms" minlength="2" maxlength="150" value="{{ $etudiant->prenoms }}"/>
                      <label for="prenoms" class="form-label"><b>Prénoms <i class="text-danger">*</i></b></label>
                      <div class="invalid-feedback">Champ obligatoire.</div>
                  </div>
              </div>
          </div>
          <div class="form-row"> 
            <div class="col-md-6 mb-1">
                <label for="nom" class="form-label float-left"><b>Etablissement <i class="text-danger">*</i></b></label> 
                <select class="browser-default custom-select" name="etablissement_id" id="etablissement_id" required>
                  <option value="" selected>Choisissez l'établissement</option>  
                  @foreach ($etablissements as $item)
                  <option value="{{$item->id}}">{{$item->sigle}}</option>
                  @endforeach
                </select>                        
            </div>
            <div class="col-md-6 mb-1">
                <label for="site" class="form-label float-left"><b>Site <i class="text-danger">*</i></b></label> 
                <select class="browser-default custom-select" name="site_id" id="site_id" required>
                  <option value="" selected></option>   
                </select>                         
            </div>
          </div>
          <div class="form-row"> 
            <div class="col-md-6 mb-1">
                <label for="nom" class="form-label float-left"><b>Pôle <i class="text-danger">*</i></b></label> 
                <select class="browser-default custom-select" name="pole_id" id="pole_id" required>
                  <option value="" selected>Choisissez le pôle</option>  
                      @foreach ($poles as $item)
                        <option value="{{$item->id}}">{{$item->libelle}}</option>
                      @endforeach
                </select>                         
            </div>
            <div class="col-md-6 mb-1">
                <label for="nom" class="form-label float-left"><b>Filière <i class="text-danger">*</i></b></label> 
                <select class="browser-default custom-select" name="filiere_id" id="filiere_id" required>
                  <option value="" selected></option>   
                </select>                         
            </div>
          </div>
          <div class="form-row"> 
            <div class="col-md-6 mb-1">
                <label for="cycle" class="form-label float-left"><b>Cycle <i class="text-danger">*</i></b></label> 
                <select class="browser-default custom-select" name="cycle_id" id="cycle_id" required>
                  <option value="" selected>Choisissez le cycle</option>  
                      @foreach ($cycles as $item)
                        <option value="{{$item->id}}">{{$item->libelle}}</option>
                      @endforeach
                </select>                         
            </div>
            <div class="col-md-6 mb-1">
                <label for="niveau" class="form-label float-left"><b>Niveau <i class="text-danger">*</i></b></label> 
                <select class="browser-default custom-select" name="niveau_id" id="niveau_id" required>
                  <option value="" selected></option>   
                </select>                         
            </div>
          </div>
          <div class="form-row"> 
            <div class="col-md-6 mb-1">
                <label for="nom" class="form-label float-left"><b>Année <i class="text-danger">*</i></b></label> 
                <select class="browser-default custom-select" name="annee" id="annee" required>
                  <option value="" selected>Choisissez l'année</option>   
                  <option value="2023">2023</option>
                  <option value="2024">2024</option>
                  <option value="2025">2025</option>
                  <option value="2026">2026</option>
                  <option value="2027">2027</option>
                  <option value="2028">2028</option>
                </select>                         
            </div>
            <div class="col-md-6 mb-1">
                <label for="nom" class="form-label float-left"><b>Type sponsor <i class="text-danger">*</i></b></label> 
                <select class="browser-default custom-select" name="typesponsor_id" id="typesponsor_id" required>
                  <option value="" selected>Choisissez le type de sponsor</option>  
                      @foreach ($typesponsors as $item)
                        <option value="{{$item->id}}">{{$item->libelle}}</option>
                      @endforeach 
                </select>                         
            </div>
          </div>
          <div class="form-row"> 
                <div class="col-md-6 mb-1">
                  <div class="d-none" id="show_sponsor">
                    <div class="input-group form-outline">
                        <span class="input-group-text" id="inputGroupPrepend"><i class="fas fa-user-alt fa-fw me-3"></i></span>
                        <input type="text" class="form-control" id="sponsor" aria-describedby="inputGroupPrepend"
                           name="sponsor" minlength="2" maxlength="150" value=""/>
                        <label for="sponsor" class="form-label">Sponsor <i class="text-danger"></i></label>
                        <div class="invalid-feedback">Champ obligatoire.</div>
                    </div>
                  </div>
              </div>  
            <div class="col-md-6 mb-1">
                <button class="btn btn-primary" type="submit">Valider</button>
            </div> 
          </div> 
      </form> 
            </div>
          </div> 
        </div> 
      </div>
    </div>
  </section>
@endsection

@section('js-script')
    <script>
        $(document).ready(function() {
            
             // remove menu active 
             $("div a").removeClass('active');
            // active menu   
            $("#identite").addClass('active'); 

// si changement d'établissement, il faut charger la liste des sites associés
$('#etablissement_id').on('change', function() { 
var etablissement_id = parseInt($('#etablissement_id').val()); 
if (etablissement_id != "") {
    $('#site_id').empty();
    $('#site_id').append('<option value="" selected="selected">Choisissez le site</option>');
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


// si changement de pôle, il faut charger la liste des filières associées
$('#pole_id').on('change', function() { 
var pole_id = parseInt($('#pole_id').val()); 

if (pole_id != "") {
    $('#filiere_id').empty();
    $('#niveau_id').empty();
    $('#filiere_id').append('<option value="" selected="selected">Choisissez la filière</option>');
    $.ajax({
        url: "{{ route('ajax_requete') }}",
        data: {
          pole_change: "ok",
          pole_id: pole_id,
            _token: '{{csrf_token()}}'
        },
        type: 'POST',
        dataType: 'json',
        success: function(data, status) { 
            jQuery.each(data, function(key, value) {
                $('#filiere_id').append('<option value="' + value.id + '">' + value.libelle + '</option>');
            });
        },
        error: function(xhr, textStatus, errorThrown) {
             alert('Veuillez renseigner tous les champs'); 
            console.log(xhr); 
            console.log(textStatus);
            console.log(errorThrown);
        }
    });
}

});


// si changement de filière, il faut charger la liste des niveau associées si cycle existe
$('#filiere_id').on('change', function() { 
var filiere_id = parseInt($('#filiere_id').val()); 
//var cycle_id = parseInt($('#cycle_id').val()); 
if (filiere_id != "") { 
    $('#cycle_id').empty();
    $('#niveau_id').empty();
    $('#cycle_id').append('<option value="" selected="selected">Choisissez le cycle</option>');
    $.ajax({
        url: "{{ route('ajax_requete') }}",
        data: {
          filiere_change: "ok",
          filiere_id: filiere_id, 
            _token: '{{csrf_token()}}'
        },
        type: 'POST',
        dataType: 'json',
        success: function(data, status) { 
            jQuery.each(data, function(key, value) {
                $('#cycle_id').append('<option value="' + value.id + '">' + value.libelle + '</option>');
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



// si changement de filière, il faut charger la liste des niveau associées si cycle existe
$('#cycle_id').on('change', function() { 
var cycle_id = parseInt($('#cycle_id').val()); 
var filiere_id = parseInt($('#filiere_id').val()); 
if (filiere_id != "" && cycle_id != "") { 
    $('#niveau_id').empty();
    $('#niveau_id').append('<option value="" selected="selected">Choisissez le niveau</option>');
    $.ajax({
        url: "{{ route('ajax_requete') }}",
        data: {
          cycle_change: "ok",
          filiere_id: filiere_id,
          cycle_id: cycle_id,
            _token: '{{csrf_token()}}'
        },
        type: 'POST',
        dataType: 'json',
        success: function(data, status) { 
            jQuery.each(data, function(key, value) {
                $('#niveau_id').append('<option value="' + value.id + '">' + value.libelle + '</option>');
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

// si autre sponsor afficher le formulaire sponsor
$('#typesponsor_id').on('change', function() { 
var typesponsor_id = parseInt($('#typesponsor_id').val());  
if (typesponsor_id == 2) { 
    $('#sponsor').val("");
    if ($('#show_sponsor').hasClass("d-none")) { 
      $('#show_sponsor').removeClass("d-none");
  }  
}else{
  // vérifier si la classe n'existe pas
  if ($('#show_sponsor').hasClass("d-none")) {
    
  } else { 
  $('#show_sponsor').add("d-none"); 
  }
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

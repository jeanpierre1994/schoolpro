
@extends('backend/include/layout')
<!-- title -->
@section('title') Examens || {{env('APP_NAME')}} @endsection

@section('fil-arial')
<div class="pagetitle">
    <h1>Paramètres</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#" style="text-decoration: none;">Accueil</a></li>
        <li class="breadcrumb-item"><a href="{{route('admin.parametres')}}" style="text-decoration: none;">Paramètres</a></li>
        <li class="breadcrumb-item"><a href="{{ url()->previous() }}" style="text-decoration: none;">Liste Etudiants</a></li>
        <li class="breadcrumb-item active">Examens</li>
      </ol>
    </nav>
  </div>
@endsection

@section('contenu')
<section class="section">
    <div class="row">
      <div class="col-lg-12">
<div class="card">
    <div class="card-body">

      <h5 class="card-title">
        Liste des examens <br><br>
        Groupe pédagogique : <b style="color: black;">{{$gp->getPole->libelle}} {{$gp->getFiliere->libelle}} {{$gp->libelle_classe}} {{$gp->libelle_secondaire}}</b>
        <br><br>
        Etudiant : <b style="color: black;">{{ $etudiant->matricule }} {{ $etudiant->getDossier->getPersonne->nom }} {{ $etudiant->getDossier->getPersonne->prenoms }}</b>
    </h5>
      <!-- Bordered Table -->
      <div class="table-responsive" style="overflow: hidden;" >
      <table style="overflow-x:auto;" class="table table-striped table-hover table-bordered data-tables">
        <thead>
          <tr>
            <th scope="col">#</th>  
            <th scope="col">Type</th>
            <th scope="col">Libellé</th>
            <th scope="col">Date début</th> 
            <th scope="col">Date fin</th> 
            <th scope="col">Année</th> 
            <th scope="col">Pondér.</th>
            <th scope="col">Note max</th>
            <th scope="col">Moyen. min</th>
            <th scope="col">Moyen. max</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          @php
              $i = 1;
          @endphp
          @foreach ($examens as $item )
          <tr>
              <td class="text-center"><b>{{$item->code_examen}}</b></td> 
              {{--<td>{{$item->groupepedagogique_id ? $item->getGP->libelle_classe : ''}}</td>--}}
              <td>{{$item->examentype_id ? $item->getExamentype->libelle : ''}}</td>
              <td>{{$item->libelle}}</td>
              <td>{{$item->date_debut}}</td> 
              <td>{{$item->date_fin}}</td> 
              <td>{{$item->annee_academique}}</td> 
              <td>{{$item->ponderation}}</td> 
              <td>{{$item->note_max}}</td>
              <td>{{$item->min_moyenne}}</td>
              <td>{{$item->max_moyenne}}</td>
              <td class="text-center">
                <a target="_blank" href="{{route('pdf', ['id'=>\Crypt::encrypt($item->id),'gp_id'=>\Crypt::encrypt($gp->id),'etudiant_id'=>\Crypt::encrypt($etudiant->id)] )}}" title="Relevé de note"><button type="button" class="btn btn-sm btn-danger"><i class="bi bi-file-earmark-pdf text-white" style="color: white" aria-hidden="true"></i></button></a> 
                @if (request()->is('/admin/etudiant/releve'))
                  <a target="_blank" href="{{route('pdf', ['id'=>\Crypt::encrypt($item->id),'gp_id'=>\Crypt::encrypt($gp->id),'etudiant_id'=>\Crypt::encrypt($etudiant->id)] )}}" title="Relevé de note"><button type="button" class="btn btn-sm btn-primary"><i class="bi bi-envelope text-white" style="color: white" aria-hidden="true"></i></button></a> 

                @endif

              </td>
          </tr>
          @endforeach

      </tbody>
      </table>
    </div>
      <!-- End Bordered Table -->
 
    </div>
  </div>
</div>
</div>
</section>

  @endsection

<!-- jsScript -->
@section('script-js')
<script>
  $(document).ready(function() {

      // remove menu active
      $("ul").removeClass('show');
      $("ul li a").removeClass('active');
      // active menu
      $("#parametres").removeClass('collapsed');

      //Pour gérer l'activation et la désactivation d'un élément
      // desactivation
 $('a.confirmation-desactivation').confirm({
    title: "",
    content:
    "<div style='border-bottom: 1px solid #ddd;' class='text-center'><img width='100px' src='{{ asset('front-design/images/logo-white.svg') }}' alt='logo'></div> <br> "+
    "<div class='text-center'><p class='text-danger'>Désactivation de l'élément ?</p> <span class='text-center'>Cette action est irréversible.</span> </div>",
    type: 'red',
    typeAnimated: true,
    draggable: true,
    dragWindowBorder: false,
    fermer: function () {

        }
});

$('a.confirmation-desactivation').confirm({
    buttons: {
        hey: function(){
            location.href = this.$target.attr('href');
        }
    }
});

// activation
$('a.confirmation-activation').confirm({
    title: "",
    content:
    "<div style='border-bottom: 1px solid #ddd;' class='text-center'><img width='100px' src='{{ asset('front-design/images/logo-white.svg') }}' alt='logo'></div> <br> "+
    "<div class='text-center'><p class='text-danger'>Activation de l'élément ?</p> <span class='text-center'>Cette action est irréversible.</span> </div>",
    type: 'red',
    typeAnimated: true,
    draggable: true,
    dragWindowBorder: false,
    fermer: function () {

        }
});
$('a.confirmation-activation').confirm({
    buttons: {
        hey: function(){
            location.href = this.$target.attr('href');
        }
    }
});

  } );
</script>
@endsection

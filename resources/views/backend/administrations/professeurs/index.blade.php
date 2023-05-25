
@extends('backend/include/layout')
<!-- title -->
@section('title') Professeurs || {{env('APP_NAME')}} @endsection

@section('fil-arial')
<div class="pagetitle">
    <h1>Paramètres</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#" style="text-decoration: none;">Accueil</a></li>
        <li class="breadcrumb-item"><a href="{{route('admin.parametres')}}" style="text-decoration: none;">Paramètres</a></li>
        <li class="breadcrumb-item active">Professeurs</li>
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
      <h5 class="card-title">Liste des professeurs <a href="{{route('professeurs.create')}}" title="Ajouter"><button style="font-size: 5px;" type="button" class="btn btn-sm btn-outline-primary"><i class="bi bi-plus-circle" aria-hidden="true" style="font-size: 10px;"></i></button></a></h5>
      <!-- Bordered Table -->
      <div class="table-responsive">
      <table class="table table-striped table-hover table-bordered data-tables">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Nom</th>
            <th scope="col">Prénoms</th>
            <th scope="col">Genre</th>
            <th scope="col">Téléphone</th>
            <th scope="col">E-mail</th> 
            <th scope="col">Date modification</th> 
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          @php
              $i = 1;
          @endphp
          @foreach ($professeurs as $item )
          <tr>
              <td class="text-center"><b>{{$i++}}</b></td>
              <td>{{$item->nom}}</td>
              <td>{{$item->prenoms}}</td>
              <td>{{$item->libelle_genre}}</td>
              <td>{{$item->tel}}</td>
              <td>{{$item->email}}</td>  
              <td>{{$item->updated_at->format("d-m-Y à H:i:s")}}</td> 
              <td class="text-center">
                <a href="{{ route('professeurs.edit', Crypt::encrypt($item->id) ) }}" title="Modifier"><button type="button" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square" style="color: white" aria-hidden="true"></i></button></a>
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

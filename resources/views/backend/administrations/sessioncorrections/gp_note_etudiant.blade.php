@extends('backend/include/layout')
<!-- title -->
@section('title')
  Note étudiant || {{ env('APP_NAME') }}
@endsection

@section('fil-arial')
    <div class="pagetitle">
        <h1>Paramètres</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" style="text-decoration: none;">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.parametres') }}"
                        style="text-decoration: none;">Paramètres</a></li>
                <li class="breadcrumb-item active">Note étudiant </li>
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
                        <h5 class="card-title">Etudiant : <b>{{ $etudiant->getDossier->getPersonne->nom }} {{ $etudiant->getDossier->getPersonne->prenoms }} || {{ $etudiant->matricule }}</b>  </h5>
                        <form action="{{route('sessioncorrections.show-note',['id'=> $gp->id, 'etudiant_id' => $etudiant->id])}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Examen <i class="text-danger">*</i></label>
                                        <select class="form-select form-select-lg" name="examen_id" id="examen_id" required>
                                           <optgroup label="Valeur par défaut">
                                            @if ($choix_examen)
                                               <option value="{{$examen->id}}">{{$examen->code_examen}}</option>
                                            @else
                                                <option value="">- - - Choisissez un examen - - -</option>
                                            @endif
                                           </optgroup>
                                            <optgroup label="Liste disponible">
                                                @foreach ($examens as $item)
                                                <option value="{{$item->id}}">{{$item->code_examen}}</option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <label for="" class="form-label">Action</label><br>
                                    <button class="btn btn-primary" type="submit">Valider</button>
                                </div> 
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- saisie des notes -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Saisie des notes </h5>
                        @if ($choix_examen)
                        <form action="{{route("sessionscorrections.store")}}" method="POST">
                            @csrf
                            <input type="hidden" value="{{$etudiant->id}}" name="etudiant_id">
                            <input type="hidden" value="{{$examen->id}}" name="examen_id">
                            <input type="hidden" value="{{$gp->id}}" name="gp_id">

                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-bordered data-tables">
                                <thead>
                                    <tr class="text-center">
                                        <th scope="col">N°</th>
                                        <th scope="col">Matière</th> 
                                        <th scope="col">Note</th> 
                                        <th scope="col"><button type="submit" class="btn btn-primary btn-sm" title="Validation en max"><i class="bi bi-check text-white"></i> Validation Note</button></th>  
                                     </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($notes_etudiants_encours as $data)
                                        <tr> 
                                            <td class="text-center"><b>{{$i++}}</b></td>
                                            <td>{{ $data->libelle }}</td> 
                                            <td>
                                                <input type="number" name="note[]" value="{{$data->note}}" min="0" max="20" class="form-control">
                                                <input type="hidden" name="note_id[]" value="{{$data->id}}">
                                            </td>   
                                            <td><input type="text" name="commentaire[]" class="form-control" value="{{$data->commentaire}}"></td> 
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </form>
                    @else

                    <p class="text-center">Aucune note n'est dispnible</p>
                            
                    @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- end saisie des notes -->
    </section>
@endsection

<!-- jsScript -->
@section('script-js')
    <script>
        
        $(document).ready(function() {
 // Setup - add a text input to each footer cell
 $('#tableHead thead th').each(function () {
        var title = $(this).text();
        if (title == "Site") {
            $(this).html('<input type="text" placeholder="Search ' + title + '" />');
        }

        if (title == "Cycle") {
            $(this).html('<input type="text" placeholder="Search ' + title + '" />');
        }

        if (title == "Pôle") {
            $(this).html('<input type="text" placeholder="Search ' + title + '" />');
        }

        if (title == "Filière") {
            $(this).html('<input type="text" placeholder="Search ' + title + '" />');
        }

        if (title == "Libelle") {
            $(this).html('<input type="text" placeholder="Search ' + title + '" />');
        }
        
    });
            // remove menu active
            $("ul").removeClass('show');
            $("ul li a").removeClass('active');
            // active menu
            $("#parametres").removeClass('collapsed');

            //Pour gérer l'activation et la désactivation d'un élément
            // desactivation
            $('a.confirmation-desactivation').confirm({
                title: "",
                content: "<div style='border-bottom: 1px solid #ddd;' class='text-center'><img width='100px' src='{{ asset('front-design/images/logo-white.svg') }}' alt='logo'></div> <br> " +
                    "<div class='text-center'><p class='text-danger'>Désactivation de l'élément ?</p> <span class='text-center'>Cette action est irréversible.</span> </div>",
                type: 'red',
                typeAnimated: true,
                draggable: true,
                dragWindowBorder: false,
                fermer: function() {

                }
            });

            $('a.confirmation-desactivation').confirm({
                buttons: {
                    hey: function() {
                        location.href = this.$target.attr('href');
                    }
                }
            });

            // activation
            $('a.confirmation-activation').confirm({
                title: "",
                content: "<div style='border-bottom: 1px solid #ddd;' class='text-center'><img width='100px' src='{{ asset('front-design/images/logo-white.svg') }}' alt='logo'></div> <br> " +
                    "<div class='text-center'><p class='text-danger'>Activation de l'élément ?</p> <span class='text-center'>Cette action est irréversible.</span> </div>",
                type: 'red',
                typeAnimated: true,
                draggable: true,
                dragWindowBorder: false,
                fermer: function() {

                }
            });
            $('a.confirmation-activation').confirm({
                buttons: {
                    hey: function() {
                        location.href = this.$target.attr('href');
                    }
                }
            });

        });
    </script>
@endsection

@extends('backend/include/layout')
<!-- title -->
@section('title')
   Session correction || {{ env('APP_NAME') }}
@endsection

@section('fil-arial')
    <div class="pagetitle">
        <h1>Paramètres</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" style="text-decoration: none;">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.parametres') }}"
                        style="text-decoration: none;">Paramètres</a></li>
                <li class="breadcrumb-item active">Groupes Pédagogiques </li>
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
                        <h5 class="card-title">Liste des groupes pédagogiques</h5>
                        <!-- Bordered Table -->
                        <div class="table-responsive">
                            <table id="tableHead" class="table table-striped table-hover table-bordered data-tables">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Site</th>
                                        <th scope="col">Cycle</th>
                                        <th scope="col">Niveau</th>
                                        <th scope="col">Pôle</th>
                                        <th scope="col">Filière</th>
                                        <th scope="col">Libelle</th>
                                        <th scope="col">Libelle 2</th>
                                        <th scope="col">Description</th>  
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Site</th>
                                        <th scope="col">Cycle</th>
                                        <th scope="col">Niveau</th>
                                        <th scope="col">Pôle</th>
                                        <th scope="col">Filière</th>
                                        <th scope="col">Libelle</th>
                                        <th scope="col">Libelle 2</th>
                                        <th scope="col">Description</th>  
                                        <th scope="col">Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($gp as $item)
                                        <tr>
                                            <td class="text-center"><b>{{ $i++ }}</b></td>
                                            <td>
                                                <p class="fw-normal mb-1">{{$item->getSite->getEtablissement->sigle}}</p>
                                                <p class="text-muted mb-0">Site : {{$item->getSite->sigle}}</p>
                                            </td>
                                            <td>{{$item->getCycle->libelle}}</td>
                                            <td>{{$item->getNiveau->libelle}}</td>
                                            <td>
                                                {{$item->getPole->libelle}}
                                            </td>
                                            <td>{{$item->getFiliere->libelle}}</td>
                                            <td>{{ $item->libelle_classe }}</td>
                                            <td>{{ $item->libelle_secondaire }}</td>
                                            <td>{{ $item->description_classe }}</td>  
                                            <td class="text-center">
                                              <div class="d-flex justify-content-evenly"> 
                                                <a href="{{ route('sessioncorrections.gp-etudiants', $item->id) }}" title="Liste des étudiants">
                                                    <button type="button" class="btn btn-sm btn-primary"><i class="bi bi-person" style="color: white" aria-hidden="true"></i></button></a>   
                                              </div>
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

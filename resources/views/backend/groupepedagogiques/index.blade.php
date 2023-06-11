@extends('backend/include/layout')
<!-- title -->
@section('title')
    Liste des groupes pédagogiques || {{ env('APP_NAME') }}
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
                        <h5 class="card-title">Liste des groupes pédagogiques <a href="{{ route('groupepedagogiques.create') }}"
                                title="Ajouter"><button style="font-size: 5px;" type="button"
                                    class="btn btn-sm btn-outline-primary"><i class="bi bi-plus-circle" aria-hidden="true"
                                        style="font-size: 10px;"></i></button></a></h5>
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
                                        <th scope="col">Descripion</th> 
                                        <th scope="col">Date modification</th>
                                        <th scope="col">Modifié par</th>
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
                                        <th scope="col">Descripion</th> 
                                        <th scope="col">Date modification</th>
                                        <th scope="col">Modifié par</th>
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
                                            <td>{{ $item->updated_at->format('d-m-Y à H:i:s') }}</td>
                                            <td>{{ $item->updated_by ? $item->getUserUpdated->name : '' }}</td>
                                            <td class="text-center">
                                              <div class="d-flex justify-content-evenly"> 
                                                <a href="{{ route('groupepedagogiques.edit', $item->id) }}" title="Modifier"><button
                                                        type="button" class="btn btn-sm btn-warning"><i
                                                            class="bi bi-pencil-square" style="color: white"
                                                            aria-hidden="true"></i></button></a>
                                                <a href="#" class="page-constructionv" data-bs-toggle="modal"
                                                    data-bs-target="#myModal_{{ $item->id }}">
                                                    <button type="button" title="Supprimer"
                                                        class="btn btn-sm btn-danger"><i class="bi bi-trash"
                                                            style="color: white" aria-hidden="true"></i></button>
                                                </a>

                                                <!-- The Modal -->
                                                <div class="modal text-center" id="myModal_{{ $item->id }}">
                                                    <div class="modal-dialog modal-md modal-dialog-centered">
                                                        <div class="modal-content text-center">

                                                            <!-- Modal Header -->
                                                            <div class="modal-header">
                                                                <h4 class="modal-title text-center"
                                                                    style="text-align: center;">Confirmer l'action <i
                                                                        class="bi bi-trash text-danger"></i></h4>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"></button>
                                                            </div>

                                                            <!-- Modal body -->
                                                            <div class="modal-body">
                                                                <div class="row mt-2 mb-2">
                                                                    <div
                                                                        class="col-md-12 text-center font-weight-bold font-height-10">
                                                                        Voulez-vous vraiment supprimer cet élément ?
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Modal footer -->
                                                            <div class="modal-footer">

                                                                <form action="{{ route('groupepedagogiques.destroy', $item->id) }}"
                                                                    method="post">
                                                                    @method('DELETE')
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-danger btn-md"
                                                                        id="" value="">OUI
                                                                    </button>
                                                                    <button type="button" class="btn btn-md btn-secondary"
                                                                        data-bs-dismiss="modal">NON</button>
                                                                </form>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End modal -->
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

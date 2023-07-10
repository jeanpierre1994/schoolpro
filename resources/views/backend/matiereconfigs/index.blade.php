@extends('backend/include/layout')
<!-- title -->
@section('title')
    Liste Matières || {{ env('APP_NAME') }}
@endsection

@section('fil-arial')
    <div class="pagetitle">
        <h1>Paramètres</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" style="text-decoration: none;">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.parametres') }}"
                        style="text-decoration: none;">Paramètres</a></li>
                <li class="breadcrumb-item active">Matières </li>
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
                        <h5 class="card-title">Liste des Matières <a href="{{ route('matiereconfigs.create') }}"
                                title="Ajouter"><button style="font-size: 5px;" type="button"
                                    class="btn btn-sm btn-outline-primary"><i class="bi bi-plus-circle" aria-hidden="true"
                                        style="font-size: 10px;"></i></button></a></h5>
                        <!-- Bordered Table -->
                        <div class="table-responsive">
                            <table id="tableHead" class="table table-striped table-hover table-bordered data-tables">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Sigle</th>
                                        <th scope="col">Libellé</th>
                                        <th scope="col">Libellé secondaire</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Classe</th>
                                        <th scope="col">Statut</th> 
                                        <th scope="col">Modifié par</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($matiereconfigs as $item)
                                        <tr>
                                            <td class="text-center"><b>{{ $i++ }}</b></td>
                                            <td>{{ $item->sigle }}</td>
                                            <td>{{ $item->libelle }}</td>
                                            <td>{{ $item->libelle_secondaire }}</td>
                                            <td>{{ $item->description }}</td>
                                            <td>
                                                @foreach (getClasse($item->id) as $data)
                                       
                                                <span class="badge bg-warning">{{$data->getGp->getFiliere->libelle}} {{$data->getGp->libelle_classe}} {{ $data->getGp->libelle_secondaire }}</span>
                                            
                                                @foreach (getProfesseurMatiere($data->id) as $prof)
                                                <span class="badge bg-primary">{{getDataProfesseur($prof->professeur_id)->nom}} {{getDataProfesseur($prof->professeur_id)->prenoms}}</span>
                                                @endforeach
                                             
                                    @endforeach
                                            </td>
                                            <td class="text-center">
                                                @if ($item->getStatut->libelle == 'ACTIF')
                                                    <span class="badge badge-danger"
                                                        style="background-color: rgb(13, 155, 238)">{{ $item->getStatut->libelle }}</span>
                                                @else
                                                    <span class="badge badge-danger"
                                                        style="background-color: rgb(233, 29, 29)">{{ $item->getStatut->libelle }}</span>
                                                @endif
                                            </td> 
                                            <td>{{ $item->updated_by ? $item->getUserUpdated->name : '' }}</td>
                                            <td class="text-center">
                                              <div class="d-flex justify-content-evenly">
                                                <a href="{{ route('matiereconfigs.show', $item->id) }}" title="Modifier"><button
                                                        type="button" class="btn btn-sm btn-primary"><i
                                                            class="bi bi-list" style="color: white"
                                                            aria-hidden="true"></i></button></a>
                                                @if ($item->getStatut->libelle == 'ACTIF')
                                                    <a href="{{ route('admin.update-parametre', [$item->id, 'matiereconfigs', 'desactivation']) }}"
                                                        class="confirmation-desactivation" title="désactivation"><button
                                                            type="button" class="btn btn-sm btn-dark"><i
                                                                class="bi bi-eye-slash" aria-hidden="true"></i></button></a>
                                                @else
                                                    <a href="{{ route('admin.update-parametre', [$item->id, 'matiereconfigs', 'activation']) }}"
                                                        class="confirmation-activation" title="activation"><button
                                                            type="button" class="btn btn-sm btn-success"><i
                                                                class="bi bi-eye" aria-hidden="true"></i></button></a>
                                                @endif
                                                <a href="{{ route('matiereconfigs.edit', $item->id) }}" title="Modifier"><button
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

                                                                <form action="{{ route('matiereconfigs.destroy', $item->id) }}"
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
            /*$('#tableHead thead th').each(function() {
                var title = $(this).text();
                if (title == "Sigle") {
                    $(this).html('<input type="text" placeholder="Search ' + title + '" />');
                }

                if (title == "Libellé") {
                    $(this).html('<input type="text" placeholder="Search ' + title + '" />');
                }

                if (title == "Libellé secondaire") {
                    $(this).html('<input type="text" placeholder="Search ' + title + '" />');
                } 

            });*/

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

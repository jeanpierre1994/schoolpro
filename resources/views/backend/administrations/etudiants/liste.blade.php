<div class="table-responsive">
    <table id="table-etudiants" class="table table-striped table-hover table-bordered data-tables">
        <thead>
            <tr>
                <th>Matricule</th>
                <th>Nom</th>
                <th>Prénoms</th>
                <th>Email</th>
                <th>Naissance</th>
                <th>Parents</th>
                <th>Contact</th>
                <th>Nationnalité</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($etudiants as $etudiant)
                <tr>
                    <td class="scol text-center">
                        <b>{{ $etudiant->matricule }}</b>
                    </td>
                    <td>
                        {{ $etudiant->getDossier->getPersonne->nom }}
                    </td>
                    <td>
                        {{ $etudiant->getDossier->getPersonne->prenoms }}

                    </td>
                    <td>
                        {{ $etudiant->getDossier->getPersonne->email }}
                    </td>
                    <td>
                        {{ gmdate('d M Y', strtotime($etudiant->getDossier->getPersonne->ddn)) }}
                    </td>
                    <td>
                        {{ $etudiant->getDossier->getUserCreated->name }}
                    </td>
                    <td>
                        {{ $etudiant->getDossier->getPersonne->tel ?? 'N/A' }}
                    </td>
                    <td>
                        {{ $etudiant->getDossier->getPersonne->nationalite ?? 'N/A' }}
                    </td>
                    <td>
                        <div class="dropdown dropstart">
                            <a href="#!" class="btn-icon btn btn-ghost btn-sm rounded-circle"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i> </a>
                            <div class="dropdown-menu">
                                <form action="{{ route('admin.etudiant.edit', \Crypt::encrypt($etudiant->id)) }}" method="get">
                                    @csrf
                                    <button type="submit" class="dropdown-item d-flex align-items-center">
                                        <i class=" dropdown-item-icon" data-feather="edit"></i>Modifier Détails
                                    </button>
                                </form>

                                <form action="{{ route('admin.etudiants.destroy', \Crypt::encrypt($etudiant->id)) }}" method="POST">
                                    @csrf
                                    @method("DELETE")
                                    <button type="submit" class="dropdown-item d-flex align-items-center red">
                                        <i class=" dropdown-item-icon" data-feather="edit"></i>Supprimer
                                    </button>
                                </form>
{{--                                <a href="#" class="page-construction" data-bs-toggle="modal"--}}
{{--                                   data-bs-target="#myModal_{{ $etudiant->id }}">--}}
{{--                                    <button type="button" title="Supprimer" class="btn btn-sm btn-danger dropdown-item d-flex align-items-center">Supprimer / Delete--}}
{{--                                    </button>--}}
{{--                                </a>--}}

{{--                                <!-- The Modal -->--}}
{{--                                <div class="modal text-center" id="myModal_{{ $etudiant->id }}">--}}
{{--                                    <div class="modal-dialog modal-md modal-dialog-centered">--}}
{{--                                        <div class="modal-content text-center">--}}

{{--                                            <!-- Modal Header -->--}}
{{--                                            <div class="modal-header">--}}
{{--                                                <h4 class="modal-title text-center"--}}
{{--                                                    style="text-align: center;">Confirmer l'action <i--}}
{{--                                                        class="bi bi-trash text-danger"></i></h4>--}}
{{--                                                <button type="button" class="btn-close"--}}
{{--                                                        data-bs-dismiss="modal"></button>--}}
{{--                                            </div>--}}

{{--                                            <!-- Modal body -->--}}
{{--                                            <div class="modal-body">--}}
{{--                                                <div class="row mt-2 mb-2">--}}
{{--                                                    <div--}}
{{--                                                        class="col-md-12 text-center font-weight-bold font-height-10">--}}
{{--                                                        Voulez-vous vraiment supprimer cet élément ?--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}

{{--                                            <!-- Modal footer -->--}}
{{--                                            <div class="modal-footer">--}}

{{--                                                <form action="{{ route('admin.etudiants.destroy',$etudiant->id) }}"--}}
{{--                                                      method="post">--}}
{{--                                                    @method("DELETE")--}}
{{--                                                    @csrf--}}
{{--                                                    <button type="submit" class="btn btn-danger btn-md"--}}
{{--                                                            id=""--}}
{{--                                                            value="">OUI--}}
{{--                                                    </button>--}}
{{--                                                    <button type="button" class="btn btn-md btn-secondary"--}}
{{--                                                            data-bs-dismiss="modal">NON--}}
{{--                                                    </button>--}}
{{--                                                </form>--}}
{{--                                            </div>--}}

{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}


                                <div class="dropdown-divider"></div>
                                <form action="{{ route('admin.etudiant.releve',\Crypt::encrypt($etudiant->id)) }}" method="get">

                                    <button class="dropdown-item d-flex align-items-center" href="#!">
                                        <i class=" dropdown-item-icon" data-feather="printer"></i>Relevé de notes
                                    </button>
                                </form>
                                <div class="dropdown-divider"></div>
                                <form action="" method="post">
                                    @csrf
                                    @method('')
                                    <button class=" disabled dropdown-item d-flex align-items-center" href="#!">
                                        <i class=" dropdown-item-icon" data-feather="printer"></i>Parcours
                                    </button>
                                </form>



                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Inclure jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Inclure les fichiers CSS et JavaScript de DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialiser DataTables sur votre table avec les options de recherche
        $('#table-etudiants').DataTable({
            searching: true, // Activer la recherche en direct
            paging: true, // Activer la pagination
            // Plus d'options peuvent être ajoutées selon vos besoins
        });
    });
</script>

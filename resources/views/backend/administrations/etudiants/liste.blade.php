<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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

                                <form id="deleteForm" action="{{ route('admin.etudiants.destroy', \Crypt::encrypt($etudiant->id)) }}" method="POST">
                                    @csrf
                                    @method("DELETE")
                                    <input type="hidden" name="supprimerDossier" id="supprimerDossier" value="0">
                                    <button type="button" title="Supprimer" class="btn btn-sm btn-danger dropdown-item d-flex align-items-center delete_button">Supprimer / Delete
                                    </button>
                                </form>
{{--                                <a class="page-construction" id="delete_button" >--}}
{{--                                    --}}
{{--                                </a>--}}
                                <script>
                                    $(document).ready(function() {

                                        $('.delete_button').on('click', function(e) {
                                            e.preventDefault();
                                            console.log('ok')
                                            Swal.fire({
                                                title: 'Êtes-vous sûr?',
                                                text: "Vous ne pourrez pas revenir en arrière!",
                                                icon: 'warning',
                                                input: "checkbox",
                                                inputValue: 0,
                                                inputName: 'supprimerDossier',
                                                inputPlaceholder: 'Supprimer le dossier également ?',
                                                showCancelButton: true,
                                                confirmButtonColor: '#3085d6',
                                                cancelButtonColor: '#d33',
                                                confirmButtonText: 'Oui, supprimez-le!',
                                                cancelButtonText: 'Non, annulez!'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    // Swal.fire(
                                                    //     'Supprimé!',
                                                    //     'Votre fichier a été supprimé.',
                                                    //     'success'
                                                    // )
                                                    $('#supprimerDossier').val(result.value?1:0);
                                                    $('#deleteForm').submit();

                                                }
                                            })
                                        });
                                    });
                                </script>


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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Inclure jQuery -->
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

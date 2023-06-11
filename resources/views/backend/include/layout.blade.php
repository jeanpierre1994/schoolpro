<!DOCTYPE html>
<html lang="en">

<!-- head -->
@include('backend.include.head')
<!-- end head -->
<!-- summernote css/js -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">

<body>

  <!-- ======= Header menu horizontal ======= -->
  @include('backend.include.menu_horizontal')
  <!-- End Header menu horizontal -->

  <!-- ======= Sidebar menu vertical ======= -->
  @include('backend.include.menu_vertical')
  <!-- End Sidebar menu vertical-->

  <main id="main" class="main">

    <!-- fil-arial -->
    @yield('fil-arial')
    <!-- end fil-arial -->

    <!-- End Page Title -->

     <!-- insert style dynamic --> 
    <!-- flash message -->
    <div id="app" class="col" style="margin: 0">
        @include('flash-message')
    </div>
    <!-- end flash message -->

     <!-- Contenu -->
     @yield('contenu')
     <!-- End Contenu -->
 
  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  @include('backend.include.footer')
  <!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- jsfile -->
@include('backend.include.jsfile')
<!-- end jsfile -->

<!-- script js -->
@yield('script-js')
<!-- end script js -->
<!-- Script summernote -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
     
<script>
    $(document).ready(function() {  
  
    $('.data-tables').DataTable({ 
        initComplete: function () {
            // Apply the search
            this.api()
                .columns()
                .every(function () {
                    var that = this;
 
                    $('input', this.header()).on('keyup change clear', function () {
                        if (that.search() !== this.value) {
                            that.search(this.value).draw();
                        }
                    });
                });
        },
        "ordering": true,
             "language": {
                 "sProcessing": "Traitement en cours ...",
                 "sLengthMenu": "Afficher _MENU_ lignes",
                 "sZeroRecords": "Aucun résultat trouvé",
                 "sEmptyTable": "Aucune donnée disponible",
                 "sLengthMenu": "Afficher &nbsp; _MENU_ &nbsp;",
                 "sInfo": "_START_ ... _END_/_TOTAL_ &eacute;l&eacute;ments",
                 "sInfoEmpty": "Aucune ligne affichée",
                 "sInfoFiltered": "(Filtrer un maximum de _MAX_)",
                 "sInfoPostFix": "",
                 "sSearch": "Recherche",
                 "sUrl": "",
                 "sInfoThousands": ",",
                 "sLoadingRecords": "Chargement...",
                 "oPaginate": {
                     "sFirst": "Premier",
                     "sLast": "Dernier",
                     "sNext": "Suivant",
                     "sPrevious": "Précédent"
                 },
                 "oAria": {
                     "sSortAscending": ": Trier par ordre croissant",
                     "sSortDescending": ": Trier par ordre décroissant"
                 }
 
             },
             dom: '<"float-left"l><"float-right"f>Brti<"float-right"p>',
             lengthMenu: [
              [10, 50, 100, 250, 300, -1],
              ['10', '50', '100', '250', '300', 'Tout afficher'],
            ],
             stateSave : true, 
             order : [[ 0, "asc" ]], 
                processing: true,
                serverSide: false
    });

    });
</script>
</body>

</html>
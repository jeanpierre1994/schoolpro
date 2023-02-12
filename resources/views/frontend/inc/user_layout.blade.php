<!doctype html>
<html lang="en">

  <!-- inc head -->
  @include('frontend.inc.user_head')
  <!-- end head -->

      <!-- sidebar -->
    <!--Main Navigation-->
    <header>
        <!-- Sidebar -->
        @include('frontend.inc.user_sidebar')
        <!-- Sidebar -->

        <!-- Navbar -->
        @include('frontend.inc.user_navbar')
        <!-- Navbar -->
    </header>
    <!--Main Navigation-->
 
<body>
  
    <!--Main layout-->
    <main style="margin-top: 58px;">
        <div class="container pt-4">
            @yield("contenu")
        </div>
        <!-- footer -->
        @include('frontend.inc.user_footer')
        <!-- end footer -->
    </main>
    <!--Main layout-->


<script src="{{ asset("frontpage/assets/js/jquery-3.3.1.min.js") }}"></script>
<!-- //footer-28 block -->

</section>

<!-- script -->
@include('frontend.inc.jsfile')
<!-- //script -->

@yield("js-script")

<!-- inc flash-alert -->
@include('flash-message')
@include('sweetalert::alert')

<!-- end inc flash-alert -->

<!-- datatable js files -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function() { 
     
  
    $('.data-tables').DataTable({ 
       
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
          //   stateSave : true,
             order : [[ 0, "asc" ]], 
                processing: true,
                serverSide: false
    });
  
    });
  </script>
</body>

</html>
<!-- // grids block 5 -->
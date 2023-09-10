@extends('backend/include/layout')
<!-- title -->
@section('title')
    Liste || {{ env('APP_NAME') }}
@endsection

@section('fil-arial')
    <div class="pagetitle">
        <h1>Liste Etudiant</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" style="text-decoration: none;">Accueil</a></li>
                <li class="breadcrumb-item active">Etudiants </li>
                <li class="breadcrumb-item active">Liste </li>
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
                        <h5 class="card-title">Liste des étudiants enregistrés</h5>
                        <div class="card info-card sales-card">
                            <div class="card-body">

                                <div class="container">
                                    <div class="treeview">
                                        <ul>
                                            @foreach ($poles as $pole)
                                                <li class="node">{{ $pole->libelle }}
                                                    <ul>
                                                        @foreach ($pole->groupePedagogiques as $gp)
                                                            <li class="node groupe" data-id="{{ $gp->id }}">
                                                                {{ $gp->libelle_classe . ' ' . $gp->libelle_secondaire }}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="student-list">
                                        <!-- Ici, vous afficherez la liste des étudiants du groupe pédagogique sélectionné -->
                                    </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.treeview .node.parent').click(function() {
                $(this).children('ul').slideToggle();
                $('.treeview .node.parent').removeClass('selected');
                // Ajoutez la classe 'selected' à l'élément parent cliqué
                $(this).addClass('selected');
            });
            $('.treeview .groupe').click(function() {
                $('.treeview .groupe').removeClass('selected');
                $(this).addClass('selected');

                // Charger la liste des étudiants ici en fonction du groupe pédagogique sélectionné
                const groupePedagogique = $(this).data('id');
                loadStudentList(groupePedagogique);
            });

            function loadStudentList(groupePedagogique) {
                $.ajax({
                    url: '/load-students/' + encodeURIComponent(groupePedagogique),
                    success: function(response) {
                        $('.student-list').html(response);
                    }
                });
            }
        });
    </script>


    <style>
        .container {
            display: flex;
            align-items: stretch;
            width: 100%;
            padding: 1rem;
            box-sizing: border-box;
            float: left;
        }

        .treeview {
            flex: 1;
            align-items: left;
            font-family: Arial, sans-serif;
            float: left;
        }

        .node {
            cursor: pointer;
            list-style: none;
            padding-left: 1rem;
        }

        .student-list {
            flex: 2;
            font-family: Arial, sans-serif;
            margin-left: 1rem;
            border-left: 1px solid #ccc;
            padding-left: 1rem;
            box-sizing: border-box;
        }

        .selected {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        .hidden {
            display: none;
        }

        .treeview .node {
            font-size: 14px;
            /* Ajustez la taille du texte pour la treeview */
        }

        .student-list {
            font-size: 14px;
            /* Ajustez la taille du texte pour la liste d'étudiants */
        }
    </style>
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

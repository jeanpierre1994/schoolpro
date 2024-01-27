@extends('backend/include/layout')
<!-- title -->
@section('title')
    Consultation des Notes || {{ env('APP_NAME') }}
@endsection

@section('fil-arial')
    <div class="pagetitle">
        <h1>Paramètres</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" style="text-decoration: none;">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.parametres') }}"
                        style="text-decoration: none;">Paramètres</a></li>
                <li class="breadcrumb-item active">Consultation des Notes </li>
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
                        <h5 class="card-title">Liste des notes de <b>{{ $get_etudiant->getDossier->getPersonne->nom}} {{ $get_etudiant->getDossier->getPersonne->prenoms}} || {{ $get_etudiant->matricule}}</b>
                            
                        </h5>
                        <!-- Bordered Table -->
                        <div class="table-responsive"> 

                            <table id="tableHead" class="table table-striped table-hover table-bordered data-tables">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th> 
                                        <th scope="col">Matiere</th>
                                        <th scope="col">Note 1 (20)</th>
                                        <th scope="col">Note 2 (20)</th>
                                        <th scope="col">Devoir (60)</th>
                                        <th scope="col">Total (100)</th>
                                        <th scope="col">Moyenne (20)</th> 
                                    </tr>
                                </thead>
                                <tbody> 
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($liste_notes as $data)
                                        @php
                                           // $my = ceil( (($data->note_first+$data->note_second)/2 + ($data->devoir*$data->getExamenprog->getMatiere->coef) )/2);
                                           $my = $data->note_first+$data->note_second +$data->devoir;
                                       @endphp
                                            <tr>
                                                <td><b>{{ $i++ }}</b></td> 
                                                <td>{{ $data->examen_prog_id ? $data->getExamenprog->getMatiere->libelle : '' }}
                                                </td>
                                                <td>{{ $data->note_first ? $data->note_first : 0 }}</td>
                                                <td>{{ $data->note_second ? $data->note_second : 0 }}</td>
                                                <td>{{ $data->devoir ? $data->devoir : 0  }}</td>
                                                <td>{{$my}}</td>
                                                <td>{{ $data->moyenne ? $data->moyenne : 0  }}</td> 
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

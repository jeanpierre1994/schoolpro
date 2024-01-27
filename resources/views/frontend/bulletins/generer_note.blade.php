@extends('backend/include/layout')
<!-- title -->
@section('title')
    Generer Notes || {{ env('APP_NAME') }}
@endsection

@section('fil-arial')
    <div class="pagetitle">
        <h1>Paramètres</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" style="text-decoration: none;">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.parametres') }}"
                        style="text-decoration: none;">Paramètres</a></li>
                <li class="breadcrumb-item active">Generer Notes </li>
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
                        <h5 class="card-title"></h5>
                        <form action="{{ route('bulletins.save-note') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="label fw-bold">Classe</label>
                                        <select name="classe" id="classe" class="form-select">
                                            @if ($update)
                                            <option selected value="{{ $get_gp->id }}">{{ $get_gp->getCycle->libelle }}
                                                {{ $get_gp->getPole->libelle }} {{ $get_gp->getFiliere->libelle }}
                                                    {{ $get_gp->libelle_classe }} {{ $get_gp->libelle_secondaire }}
                                            </option>
                                            @else
                                            <option value="">--- Choisissez une valeur ---</option>
                                            @endif

                                            @foreach ($gp as $item)
                                                <option value="{{ $item->id }}">{{ $item->getCycle->libelle }}
                                                    {{ $item->getPole->libelle }} {{ $item->getFiliere->libelle }}
                                                    {{ $item->libelle_classe }} {{ $item->libelle_secondaire }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="label fw-bold">Bulletin</label>
                                        <select name="bulletin" id="bulletin" class="form-select">
                                            @if ($update)
                                            <option selected value="{{ $get_bulletin->code }}">{{ $get_bulletin->code }} {{ $get_bulletin->libelle_primaire }}</option>
                                            @else
                                            <option value="">--- Choisissez une valeur ---</option>                                            
                                            @endif

                                            @foreach ($bulletins as $item)
                                                <option value="{{ $item->code }}">{{ $item->code }}
                                                    {{ $item->libelle_primaire }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">

                                    <div class="form-group">
                                        <label for="label fw-bold">Action</label><br>
                                        <input type="submit" name="afficher" value="Afficher" class="btn btn-primary btn-sm">
                                        <button type="submit" class="btn btn-secondary btn-sm">Generer notes</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Liste des notes des notes
                            @if ($update)
                                Classe : {{ $get_gp->getCycle->libelle }} {{ $get_gp->getPole->libelle }}
                                {{ $get_gp->getFiliere->libelle }} {{ $get_gp->libelle_classe }}
                                {{ $get_gp->libelle_secondaire }} &nbsp;&nbsp;&nbsp;
                                Bulletin : {{ $get_bulletin->code_bulletin }} {{ $get_bulletin->libelle_primaire }}
                            @else
                            
                            Classe................ Bulletin ................

                            @endif
                        </h5>
                        <!-- Bordered Table -->
                        <div class="table-responsive">
                            <form action="{{ route('bulletins.save-note') }}" method="post">
                                @csrf
                                @method("post")
                                @if ($update == true)
                                 <input type="hidden" name="classe" value="{{ $get_gp->id }}">
                                <input type="hidden" name="bulletin" value="{{ $get_bulletin->code }}">
                                  
                                <button style="float: right" type="submit" class="btn btn-warning btn-sm text-white mb-2" name="valider_appreciation">Valider appreciation</button>
                                @endif
                            <table id="tableHead" class="table table-striped table-hover table-bordered data-tables">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Matricule</th>
                                        <th scope="col">Nom</th>
                                        <th scope="col">Prenoms</th>
                                        <th scope="col">Rang</th>
                                        <th scope="col">Moyenne</th>
                                        <th scope="col">Appreciation 1</th>
                                        <th scope="col">Appreciation 2</th> 
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($update == true)
                                    
                                      @php
                                        $i=1;
                                    @endphp
                                        @foreach ($liste_moyennes as $datas) 
                                       <tr>
                                        <td><b>{{ $i++ }}</b></td>
                                        <td>{{ $datas->etudiant_id ? $datas->getEtudiant->matricule : '' }}</td>
                                        <td>{{ $datas->etudiant_id ? $datas->getEtudiant->getDossier->getPersonne->nom : '' }}</td>
                                        <td>{{ $datas->etudiant_id ? $datas->getEtudiant->getDossier->getPersonne->prenoms : '' }}</td>
                                        <td>
                                            @if ($loop->first)
                                                {{$datas->rang}} er
                                            @else
                                           
                                            @if ($liste_moyennes[$loop->index - 1]->rang == $datas->rang)
                                            {{$datas->rang}} ex                                                
                                            @else
                                            {{$datas->rang}} eme                                                
                                            @endif

                                            @endif
                                        </td>
                                        <td>{{ $datas->moyenne ? $datas->moyenne : 0 }}</td>
                                        <td>
                                            <input type="hidden" name="bulletin_id[]" value="{{$datas->id}}" required>
                                            <input type="text" name="appreciation_fr[]" value="{{$datas->appreciation_fr}}" id="" class="form-control">
                                        </td>
                                        <td>
                                            <input type="text" name="appreciation_en[]" value="{{$datas->appreciation_en}}" id="" class="form-control">
                                        </td>
                                        <td>
                                            <a target="_blank"
                                                        href="{{ route('show-bulletin', ['id' => \Crypt::encrypt($datas->etudiant_id), 'codeBulletin'=>$datas->code_bulletin]) }}"
                                                        title="Bulletin"><button type="button"
                                                            class="btn btn-sm btn-danger"><i
                                                                class="bi bi-file-earmark-pdf text-white"
                                                                style="color: white" aria-hidden="true"></i></button></a>

                                            
                                                                <a target="_blank"
                                                                href="{{ route('bulletins.consultation-note', ['etudiant' => \Crypt::encrypt($datas->etudiant_id), 'gp'=>$get_gp->id,'bulletin'=>$datas->code_bulletin]) }}"
                                                                title="Bulletin détaillé"><button type="button"
                                                                    class="btn btn-sm btn-primary"><i
                                                                        class="bi bi-list text-white"
                                                                        style="color: white" aria-hidden="true"></i></button></a>
                                        </td>
                                       </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table> 
                        </form>
                            
 
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

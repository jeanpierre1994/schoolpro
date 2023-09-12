@extends('backend/include/layout')
<!-- title -->
@section('title')
    Enregistrement Rubrique|| {{ env('APP_NAME') }}
@endsection

@section('fil-arial')
    <div class="pagetitle">
        <h1>Paramètres</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" style="text-decoration: none;">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.parametres') }}"
                        style="text-decoration: none;">Paramètres</a></li>
                <li class="breadcrumb-item"><a href="{{ route('rubriques.index') }}"
                        style="text-decoration: none;">Rubriques</a> </li>
                <li class="breadcrumb-item active">Modification </li>
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
                        <h5 class="card-title">Enregistrement</h5>
                        <!-- General Form Elements -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Error!</strong>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('rubriques.update', $rubrique->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="col-sm-12 col-form-label">Famille Rubrique</label>
                                <div class="col-sm-12">
                                    <select class="form-select" name="famille_rubrique_id" id="gp_id" required>
                                        <option selected value="">Sélectionnez une option</option>
                                        @foreach ($familleRubriques as $familleRubrique)
                                            <option value="{{ $familleRubrique->id }}" {{ $familleRubrique->id == $rubrique->famille_rubrique_id ? 'selected' : '' }}>{{ $familleRubrique->libelle }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="inputText" class="col-sm-12 col-form-label">Libellé <i
                                            class="text-danger">*</i></label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" required name="libelle"
                                          value="{{ old('libelle', $rubrique->libelle) }}"  id="libelle" minlength="3" maxlength="50">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="inputText" class="col-sm-12 col-form-label">Libellé Secondaire <i
                                        class="text-danger">*</i></label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" required name="libelle_secondaire" id="libelle"
                                       value="{{ old('libelle', $rubrique->libelle_secondaire) }}" minlength="3" maxlength="50">
                                </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="inputText" class="col-sm-12 col-form-label">Montant <i
                                        class="text-danger">*</i></label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" required name="montant" id="montant"
                                       value="{{ old('montant', $rubrique->montant) }}" min="0">
                                </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="inputText" class="col-sm-12 col-form-label">Echéance <i
                                            class="text-danger">*</i></label>
                                    <div class="col-sm-12"> 
                                            <select class="form-select form-select-lg" name="echeance" id="echeance" required>
                                                <optgroup label="Valeur par défaut">
                                                    <option value="{{$rubrique->echeance}}">{{$rubrique->echeance}}</option>
                                                </optgroup>
                                                <optgroup label="Liste disponible">
                                                    <option value="Janvier">Janvier</option>
                                                    <option value="Février">Février</option>
                                                    <option value="Mars">Mars</option>
                                                    <option value="Avril">Avril</option>
                                                    <option value="Mai">Mai</option>
                                                    <option value="Juin">Juin</option>
                                                    <option value="Juillet">Juillet</option>
                                                    <option value="Août">Août</option>
                                                    <option value="Septembre">Septembre</option>
                                                    <option value="Octobre">Octobre</option>
                                                    <option value="Novembre">Novembre</option>
                                                    <option value="Décembre">Décembre</option>
                                                </optgroup>
                                                
                                            </select> 
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Validation</label>
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-warning">Enregistrer</button>
                                </div>
                            </div>
                        </form><!-- End General Form Elements -->
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

            // remove menu active
            $("ul").removeClass('show');
            $("ul li a").removeClass('active');
            // active menu 
            $("#parametres").removeClass('collapsed');
        });
    </script>
@endsection

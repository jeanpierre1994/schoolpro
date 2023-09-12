@extends('backend/include/layout')
<!-- title -->
@section('title')
    Modification de Ligne Tarifaire|| {{ env('APP_NAME') }}
@endsection

@section('fil-arial')
    <div class="pagetitle">
        <h1>Paramètres</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" style="text-decoration: none;">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.parametres') }}"
                        style="text-decoration: none;">Paramètres</a></li>
                <li class="breadcrumb-item"><a href="{{ route('famille_rubriques.index') }}"
                        style="text-decoration: none;">Ligne Tarifaire</a> </li>
                <li class="breadcrumb-item active">Enregistrement </li>
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
                        <h5 class="card-title">Modification</h5>
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
                        <form action="{{ route('ligne_tarifaires.update', $ligneTarifaire->id) }}" method="post">
                            @csrf
                            @method("put")
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Rubrique</label>
                                <div class="col-sm-10">
                                    <select class="form-select" name="rubrique_id" id="gp_id" required>
                                        <option selected value="">Sélectionnez une option</option>
                                        @foreach ($rubriques as $rubrique)
                                            <option value="{{ $rubrique->id }}" {{ $rubrique->id == $ligneTarifaire->rubrique_id ? 'selected' : '' }}>{{ $rubrique->libelle }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Grille Tarifaire</label>
                                <div class="col-sm-10">
                                    <select class="form-select" name="grille_tarifaire_id" id="gp_id" required>
                                        <option selected value="">Sélectionnez une option</option>
                                        @foreach ($grilleTarifaires as $grilleTarifaire)
                                            <option value="{{ $grilleTarifaire->id }}" {{ $grilleTarifaire->id == $ligneTarifaire->grille_tarifaire_id ? 'selected' : '' }}>
                                                {{ $grilleTarifaire->libelle . ' ' . $grilleTarifaire->libelle_secondaire }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-2 col-form-label">Montant <i
                                        class="text-danger">*</i></label>
                                <div class="col-sm-10">
                                    <input type="number" value="{{ old('montant', $ligneTarifaire->montant) }}" class="form-control" required name="montant" id="montant"
                                        minlength="3" maxlength="50">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-2 col-form-label">Obligatoire <i
                                        class="text-danger">*</i></label>
                                <div class="col-sm-10">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input ml-0" type="checkbox" id="flexSwitchCheckChecked" name="is_required" @if($ligneTarifaire->is_required) checked @endif>
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

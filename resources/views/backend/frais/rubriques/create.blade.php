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
                        <form action="{{ route('rubriques.store') }}" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-2 col-form-label">Libellé <i
                                        class="text-danger">*</i></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" required name="libelle"
                                        id="libelle" minlength="3" maxlength="50">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-2 col-form-label">Libellé Secondaire <i
                                        class="text-danger">*</i></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" required name="libelle_secondaire" id="libelle"
                                        minlength="3" maxlength="50">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Famille Rubrique</label>
                                <div class="col-sm-10">
                                    <select class="form-select" name="famille_rubrique_id" id="gp_id" required>
                                        <option selected value="">Sélectionnez une option</option>
                                        @foreach ($familleRubriques as $familleRubrique)
                                            <option value="{{ $familleRubrique->id }}">{{ $familleRubrique->libelle }}
                                            </option>
                                        @endforeach
                                    </select>
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

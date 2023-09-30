@extends('backend/include/layout')

@section('title')
   Ventilation || {{ env('APP_NAME') }}
@endsection

@section('fil-arial')
    <div class="pagetitle">
        <h1>Paramètres</h1>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard_parent') }}">Accueil</a></li> 
                <li class="breadcrumb-item active" aria-current="page"> Ventilation</li>
            </ol>
        </nav>
    </div>
@endsection

@section('contenu')
    <section style="background-color: #eee;">
        <div class="container py-1">

            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-4">
                        <h5 class="card-header">Ventilation des paiements</h5>
                        <div class="card-body text-center" style="font-size: 150%;">
                            Ventilation des paiements effectuée avec succès.
                            <div class="row justify-content-center align-items-center g-2">
                                 <div class="col-md-5 mx-auto mt-10" style="margin-top: 20px">
                                    <a href="{{$uri}}" class="btn btn-outline-dark">Retour à l'accueil</a> &nbsp; &nbsp; <a href="{{route("impression-recu",$reference)}}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-success"><i class="fa fa-file"></i> Télécharger le reçu</a>
                                 </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
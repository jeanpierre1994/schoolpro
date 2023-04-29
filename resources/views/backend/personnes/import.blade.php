@extends('backend.include.layout')

@section('title')
    Importation Personnes
@endsection

@section('fil-arial') 
<div class="pagetitle">
    <h1>Importations</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#" style="text-decoration: none;">Accueil</a></li>
        <li class="breadcrumb-item"><a href="" style="text-decoration: none;">Imports</a></li>
        <li class="breadcrumb-item"><a href="" style="text-decoration: none;">Personne</a> </li>
        <li class="breadcrumb-item active">Enregistrement fichier </li>
      </ol>
    </nav>
  </div> 
@endsection

@section('contenu')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Enregistrement pour Importations</h1>
            <a href="" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
        </div>
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
              <form action="{{route('upload-personnes')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="col-md-12 mb-3 mt-3">
                    <p>Please Upload CSV in Given Format <a href="{{ asset('files/sample-data-sheet.csv') }}" target="_blank">Sample CSV Format</a></p>
                </div>
                {{-- File Input --}}
                <div class="col-sm-12 mb-3 mt-3 mb-sm-0">
                    <span style="color:red;">*</span>File Input(Datasheet)</label>
                    <input 
                        type="file" 
                        class="form-control form-control-user @error('file') is-invalid @enderror" 
                        id="exampleFile"
                        name="file" 
                        value="{{ old('file') }}"> 

                <div class="card-footer">
                    <button type="submit" class="btn btn-success btn-user float-right mb-3">Upload Personnes</button>
                    <a class="btn btn-primary float-right mr-3 mb-3" href="">Cancel</a>
                </div>
              </form><!-- End General Form Elements -->
            </div>
        </div>
    </div>
@endsection
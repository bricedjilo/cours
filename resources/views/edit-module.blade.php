
@extends('layouts.app')

@section('content')
    
<div class="container">

    <div class="row justify-content-center">
        <div class="col-lg-6 col-sm-12">
            
            <h4>Editer</h4>
            <h5>Moodule {{ $module->number }}: {{ $module->title }}</h5>
            <h6>Matiere: {{ $module->subject->name }}</h6>
            <h6>Classe: {{ $module->subject->classe->name }}</h6>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('errors'))
                <div class="alert alert-danger">
                    {{ session('errors') }}
                </div>
            @endif

            <form id="edit-module" method="POST" action="{{ route('update-module', ['module' => $module]) }}">
                @csrf
                <div class="form-group">
                    <input type="text"
                        name="title"
                        class="form-control" 
                        id="chapter-title" 
                        value="{{ $module->title }}">
                </div>
                <div class="form-group">
                    <select class="form-control" id="module-number" name="number">
                        <option>Numero du module</option>
                        <option selected>{{ $module->number }}</option>
                        @foreach ($remaining_modules as $remaining_module)
                            <option value="{{ $remaining_module }}">{{ $remaining_module }}</option>
                        @endforeach
                    </select>
                </div>

                @method('PUT')
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <a href="{{ route('edit-subject', ['subject' => $module->subject]) }}" 
                    class="btn btn-secondary">
                    Annuler
                </a>
            </form>
            <hr>
            <form id="delete-module" 
                action="{{ route('delete-module', ['module' => $module]) }}" 
                method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    Supprimer
                </button>
            </form>
            <hr>
            <div class="form-group">
                <a href="{{ route('create-module', ['subject' => $module->subject]) }}">Ajouter un module</a>
            </div>
            <div class="form-group">
                <a href="{{ route('edit-subject', ['subject' => $module->subject]) }}">Ajouter un chapitre</a>
            </div>
            <div class="form-group">
                <a href="{{ route('home') }}">Retour au profile</a>
            </div>
        </div>
    </div>

    <hr>

    @include('list-of-module-chapters')

</div>

@endsection
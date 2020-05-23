
@extends('layouts.app')

@section('content')
    
<div class="container">

    <div class="row justify-content-center">
        <div class="col-lg-6 col-sm-12">
            
            <h4>Editer</h4>
            <h4><b>Chapitre {{ $chapter->number }}: {{ $chapter->title }}</b></h4>
            <h6>Matiere: {{ $chapter->module->subject->name }}</h6>
            <h6>Module {{ $chapter->module->number }}: {{ $chapter->module->title }}</h6>
            <h6>Classe: {{ $chapter->module->subject->classe->name }}</h6>

            @include('error-success-message')

            <form id="edit-module" 
                method="POST" 
                action="{{ route('update-chapter', ['chapter' => $chapter]) }}">
                @csrf
                <div class="form-group">
                    <input type="text"
                        name="title"
                        class="form-control" 
                        id="chapter-title" 
                        value="{{ $chapter->title }}">
                </div>
                <div class="form-group">
                    <select class="form-control" id="module-number" name="number">
                        <option>Numero du chapitre</option>
                        <option selected>{{ $chapter->number }}</option>
                        @foreach ($remaining_chapters as $remaining_chapter)
                            <option value="{{ $remaining_chapter }}">{{ $remaining_chapter }}</option>
                        @endforeach
                    </select>
                </div>

                @method('PUT')
                <button type="submit" class="btn btn-primary">Enregistrer</button>

                <a href="{{ route('edit-subject', ['subject' => $chapter->module->subject]) }}" 
                    class="btn btn-secondary">
                    Annuler
                </a>
            </form>
            <hr>
            <form id="delete-module" 
                action="{{ route('delete-chapter', ['chapter' => $chapter]) }}" 
                method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    Supprimer
                </button>
            </form>
            <hr>
            <div class="form-group">
                <a href="{{ route('create-lesson', ['chapter' => $chapter]) }}">
                    Ajouter une lecon
                </a>
            </div>
            <div class="form-group">
                <a href="{{ route('create-chapter-homework', ['chapter' => $chapter]) }}">
                    Ajouter un devoir
                </a>
            </div>
            <div class="form-group">
                <a href="{{ route('edit-module', ['module' => $chapter->module]) }}">Retour au module</a>
            </div>
            <div class="form-group">
                <a href="{{ route('home') }}">Retour au profile</a>
            </div>
        </div>
    </div>

    <hr>

    @include('list-of-chapter-lessons')
    @include('list-of-chapter-homeworks')

</div>

@endsection
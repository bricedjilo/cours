
@extends('layouts.app')

@section('content')
    
<div class="container">

    <div class="row justify-content-center">
        <div class="col-lg-6 col-sm-12">
            
            <h4>Ajouter une lecon</h4>
            <h5>Chapitre {{ $chapter->number }}: {{ $chapter->title }}</h5>

            <form method="POST" action="/lessons">
                @csrf
                <div class="form-group">
                    <input type="text"
                        name="title"
                        class="form-control" 
                        id="lesson-title" 
                        placeholder="Titre de la lecon">
                </div>
                <input type="hidden" name="chapter_id" id="chapter_id" value="{{ $chapter->id }}">
                <div class="form-group">
                    <input type="text"
                        name="{{ $chapter->module->subject->id }}"
                        class="form-control" disabled
                        id="subject-name" 
                        value="{{ $chapter->module->subject->name }} - {{ $chapter->module->subject->classe->name }}">
                </div>
                
                <div class="form-group">
                    <select class="form-control" id="lesson-number" name="number">
                        <option>Numero de la lecon</option>
                        @foreach ($remaining_lessons as $lesson_number)
                            <option value="{{ $lesson_number }}">{{ $lesson_number }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Ajouter</button>
                <a href="{{ route('edit-subject', ['subject' => $chapter->module->subject]) }}" 
                    class="btn btn-secondary">
                    Annuler
                </a>
            </form>
            <hr>
            <div class="form-group">
                <a href="{{ route('edit-subject', ['subject' => $chapter->module->subject]) }}">
                    Ajouter un chapitre
                </a>
            </div>
            <div class="form-group">
                <a href="{{ route('create-module', ['subject' => $chapter->module->subject]) }}">
                    Ajouter un module
                </a>
            </div>
            <div class="form-group">
                <a href="{{ route('home') }}">Retour au profile</a>
            </div>
        </div>
    </div>

    <hr>

    @include('list-of-chapter-lessons')
     
</div>

@endsection
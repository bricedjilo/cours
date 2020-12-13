@extends('layouts.app')

@section('content')

<div class="container">

    <div class="row justify-content-center">
        <div class="col-lg-6 col-sm-12">

            <h4>Ajouter une lecon a ce chapitre</h4>
            <h5>Chapitre {{ $chapter->number }}: {{ $chapter->title }}</h5>

            @include('error-success-message')

            <form method="POST" action="/lessons" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <input type="text" name="title" class="form-control" id="lesson-title"
                        placeholder="Titre de la lecon">
                </div>
                <input type="hidden" name="chapter_id" id="chapter_id" value="{{ $chapter->id }}">
                <div class="form-group">
                    <input type="text" name="{{ $chapter->module->subject->id }}" class="form-control" disabled
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

                <div class="form-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="customFile" name="lesson_files[]"
                            accept=".pdf,.txt,.jpg,.jpeg,.png" multiple>
                        <label class="custom-file-label" for="customFile">Ajouter un document</label>
                    </div>
                </div>
                <div class="form-group">
                    <ul id="file-names"></ul>
                </div>

                <button type="submit" class="btn btn-primary">Ajouter</button>
                <a href="{{ route('edit-subject', ['subject' => $chapter->module->subject]) }}"
                    class="btn btn-secondary">
                    Annuler
                </a>
            </form>
            <hr>
            <div class="form-group">
                <a href="{{ route('edit-chapter', ['chapter' => $chapter]) }}">
                    Retour au chapitre
                </a>
            </div>
            <div class="form-group">
                <a href="{{ route('home') }}">Retour au profile</a>
            </div>
        </div>
    </div>

    <hr>

    @include('lists.list-of-chapter-lessons')

</div>

@endsection
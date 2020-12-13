@extends('layouts.app')

@section('content')

<div class="container">

    <div class="row justify-content-center">
        <div class="col-lg-6 col-sm-12">

            <h4>Editer</h4>
            <h4><b>Lecon {{ $lesson->number }}: {{ $lesson->title }}</b></h4>
            <h6>Chapter {{ $lesson->chapter->number }}: {{ $lesson->chapter->title }}</h6>
            <h6>Module {{ $lesson->chapter->module->number }}: {{ $lesson->chapter->module->title }}</h6>
            <h6>Matiere: {{ $lesson->chapter->module->subject->name }}</h6>
            <h6>Classe: {{ $lesson->chapter->module->subject->classe->name }}</h6>

            @include('error-success-message')

            <form id="edit-lesson" method="POST" action="{{ route('update-lesson', ['lesson' => $lesson]) }}"
                enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <input type="text" name="title" class="form-control" id="lesson-title" value="{{ $lesson->title }}">
                </div>
                <div class="form-group">
                    <select class="form-control" id="lesson-number" name="number">
                        <option>Numero de la leçon</option>
                        <option selected>{{ $lesson->chapter->number }}</option>
                        @foreach ($remaining_lessons as $remaining_lesson)
                        <option value="{{ $remaining_lesson }}">{{ $remaining_lesson }}</option>
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

                @method('PUT')
                <button type="submit" class="btn btn-primary">Enregistrer</button>

                <a href="{{ route('edit-subject', ['subject' => $lesson->chapter->module->subject]) }}"
                    class="btn btn-secondary">
                    Annuler
                </a>
            </form>

            <hr>

            <form id="delete-lesson-file" action="{{ route('delete-lesson-up-file', ['lesson' => $lesson]) }}"
                method="POST">
                @csrf
                @method('DELETE')
                <div class="form-group">
                    <ul>
                        @foreach($lesson->uploadedFiles as $file)
                        <input type="hidden" name="up_file_id" value="{{ $file->id }}">
                        <input type="hidden" name="up_file_ext" value="{{ $file->extension }}">
                        <li><a href="{{ $file->url }}" target="_blank">{{ $file->name }}</a>
                            <button type="submit" class="btn btn-default">
                                <i class="far fa-trash-alt" style="color: red;"></i>
                            </button>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </form>

            <div class="form-group">
                <ul id="file-names"></ul>
            </div>

            <hr>

            <form id="delete-lesson" action="{{ route('delete-lesson', ['lesson' => $lesson]) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    Supprimer
                </button>
            </form>
            <hr>
            <div class="form-group">
                <a href="{{ route('create-lesson-homework', ['lesson' => $lesson]) }}">
                    Ajouter un devoir
                </a>
            </div>
            <div class="form-group">
                <a href="{{ route('edit-chapter', ['chapter' => $lesson->chapter]) }}">
                    Retour au chapitre
                </a>
            </div>
            <div class="form-group">
                <a href="{{ route('home') }}">Retour au profile</a>
            </div>
        </div>
    </div>

    <hr>

    @include('lists.list-of-lesson-homeworks')

</div>

@endsection
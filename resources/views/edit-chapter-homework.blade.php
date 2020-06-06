
@extends('layouts.app')

@section('content')
    
<div class="container">

    <div class="row justify-content-center">
        <div class="col-lg-6 col-sm-12">
            
            <h4>Editer</h4>
            <h5>Devoir {{ $homework->number }}: {{ $homework->title }}</h5>
            <h5>Chapter {{ $homework->chapter->number }}: {{ $homework->chapter->title }}</h5>
            <h5>Moodule {{ $homework->chapter->module->number }}: {{ $homework->chapter->module->title }}</h5>
            <h6>Matiere: {{ $homework->chapter->module->subject->name }}</h6>
            <h6>Classe: {{ $homework->chapter->module->subject->classe->name }}</h6> 

            @include('error-success-message')

            <form 
                id="edit-chapter-homework"
                method="POST"
                action="{{ route('update-homework', ['homework' => $homework]) }}"
                enctype="multipart/form-data"
            >
                @csrf
                <div class="form-group">
                    <input type="text"
                        name="title"
                        class="form-control" 
                        id="homework-title" 
                        value="{{ $homework->title }}">
                </div>
                <input type="hidden" name="chapter_id" id="chapter_id" value="{{ $homework->chapter->id }}">
                <div class="form-group">
                    <textarea 
                        class="form-control"
                        name="content"
                        rows="6"
                        id="homework-content">
                        {{ $homework->content }}
                    </textarea>
                </div>
                <div class="form-group">
                    <select class="form-control" id="homework-number" name="number">
                        <option>Numero du devoir</option>
                        <option selected>{{ $homework->number }}</option>
                        @foreach ($remaining_homeworks as $remaining_homework)
                            <option value="{{ $remaining_homework }}">{{ $remaining_homework }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Date butoire</label>
                    <input
                        type="date"
                        name="deadline"
                        max="3000-12-31"
                        min="2020-05-15"
                        class="form-control"
                        value="{{ $homework->deadline }}">
                </div>

                <div class="form-group">
                    <div class="custom-file">
                        <input 
                            type="file"
                            class="custom-file-input"
                            id="customFile"
                            name="chapter_hw_files[]"
                            accept=".pdf,.txt,.jpg,.jpeg,.png"
                            multiple
                        >
                        <label class="custom-file-label" for="customFile">Ajouter un document</label>
                    </div>
                </div>

                @method('PUT')
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <a href="{{ route('edit-chapter', ['chapter' => $homework->chapter]) }}" 
                    class="btn btn-secondary">
                    Annuler
                </a>
            </form>

            <hr>

            <form id="delete-module-hw-file" 
                action="{{ route('delete-homework-up-file', ['homework' => $homework]) }}"
                method="POST">
                @csrf
                @method('DELETE')
                <div class="form-group">
                    <ul>
                        @foreach($homework->uploadedFiles as $file)
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

            <form id="delete-homework" 
                action="{{ route('delete-homework', ['homework' => $homework]) }}" 
                method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    Supprimer
                </button>
            </form>
            <hr>
            <div class="form-group">
                <a href="{{ route('edit-chapter', ['chapter' => $homework->chapter]) }}">Retour au chapitre</a>
            </div>
            <div class="form-group">
                <a href="{{ route('home') }}">Retour au profile</a>
            </div>
        </div>
    </div>

    <hr>
    <?php $chapter = $homework->chapter; ?>
    @include('list-of-chapter-homeworks')

</div>

@endsection
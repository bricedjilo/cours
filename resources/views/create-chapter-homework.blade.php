
@extends('layouts.app')

@section('content')
    
<div class="container">

    <div class="row justify-content-center">
        <div class="col-lg-6 col-sm-12">

            @include('error-success-message')
            
            <h4>Ajouter un devoir a ce chapitre</h4>
            <h6>Chapitre {{ $chapter->number }}: {{ $chapter->title }}</h4>
            <h6>Module {{ $chapter->module->number }}: {{ $chapter->module->title }}</h4>

            <form
                method="POST"
                action="/homeworks"
                enctype="multipart/form-data"
            >
                @csrf
                <div class="form-group">
                    <input type="text"
                        name="{{ $chapter->module->subject->id }}"
                        class="form-control" disabled
                        id="chapter-name" 
                        value="{{ $chapter->module->subject->name }} - {{ $chapter->module->subject->classe->name }}">
                </div>
                <div class="form-group">
                    <input type="text"
                        name="title"
                        class="form-control" 
                        id="homework-title" 
                        placeholder="Titre du devoir">
                </div>
                <input type="hidden" name="chapter_id" id="chapter_id" value="{{ $chapter->id }}">
                <div class="form-group">
                    <textarea class="form-control"
                        name="content"
                        rows="6"
                        id="homework-content" 
                        placeholder="Contenu du devoir">
                    </textarea>
                </div>
                <div class="form-group">
                    <select class="form-control" id="module-number" name="number">
                        <option>Numero du devoir</option>
                        @foreach ($remaining_homeworks as $homework_number)
                            <option value="{{ $homework_number }}">{{ $homework_number }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Date limite</label>
                    <input 
                        type="date"
                        name="deadline"
                        max="3000-12-31"
                        min="2020-05-15"
                        class="form-control">
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
                <div class="form-group">
                    <ul id="file-names"></ul>
                </div>

                <hr>

                <button type="submit" class="btn btn-primary">Ajouter</button>
                <a href="{{ route('edit-chapter', ['chapter' => $chapter]) }}" 
                    class="btn btn-secondary">
                    Annuler
                </a>
            </form>
            <hr>
            <div class="form-group">
                <a href="{{ route('edit-chapter', ['chapter' => $chapter]) }}">Retour au chapitre</a>
            </div>
            <div class="form-group">
                <a href="{{ route('home') }}">Retour au profile</a>
            </div>
        </div>
    </div>

    <hr>
    
    @include('list-of-chapter-homeworks')
     
</div>

@endsection
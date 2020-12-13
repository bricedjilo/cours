@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-sm-12">

            <h4>Ajouter un chapitre a ce module</h4>
            <h6>Module {{ $module->number }}: {{ $module->title }}</h6>

            @include('error-success-message')

            <form method="POST" action="/chapters" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <input type="text" name="{{ $module->subject->id }}" class="form-control" disabled id="subject-name"
                        value="{{ $module->subject->name }} - {{ $module->subject->classe->name }}">
                </div>
                <div class="form-group">
                    <input type="text" name="title" class="form-control" id="chapter-title"
                        placeholder="Titre du chapitre">
                </div>
                <div class="form-group">
                    <select class="form-control" id="chapter-number" name="number">
                        <option>Numero du chapitre</option>
                        @foreach ($remaining_chapters as $chapter_number)
                        <option value="{{ $chapter_number }}">{{ $chapter_number }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <textarea class="form-control" name="description" rows="6" id="chapter-description"
                        placeholder="Description du chapitre">
                    </textarea>
                </div>
                <input type="hidden" name="module_id" id="module_id" value="{{ $module->id }}">
                <div class="form-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="customFile" name="chapter_files[]"
                            accept=".pdf,.txt,.jpg,.jpeg,.png" multiple>
                        <label class="custom-file-label" for="customFile">Ajouter un document</label>
                    </div>
                </div>
                <div class="form-group">
                    <ul id="file-names"></ul>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                    <a href="{{ route('home') }}" class="btn btn-secondary">
                        Annuler
                    </a>
                </div>
                <hr>
                <div class="form-group">
                    <a href="{{ route('edit-module', ['module' => $module]) }}">Retour au module</a>
                </div>
                <div class="form-group">
                    <a href="{{ route('home') }}">Retour au profile</a>
                </div>
            </form>
        </div>
    </div>

    <hr>

    @include('lists.list-of-module-chapters')

</div>
@endsection
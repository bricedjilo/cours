
@extends('layouts.app')

@section('content')
    
<div class="container">

    <div class="row justify-content-center">
        <div class="col-lg-6 col-sm-12">
            
            <h4>Ajouter un module</h4>

            <form method="POST" action="/modules">
                @csrf
                <div class="form-group">
                    <input type="text"
                        name="{{ $subject->id }}"
                        class="form-control" disabled
                        id="subject-name" 
                        value="{{ $subject->name }} - {{ $subject->classe->name }}">
                </div>
                <div class="form-group">
                    <input type="text"
                        name="title"
                        class="form-control" 
                        id="module-title" 
                        placeholder="Titre du module">
                </div>
                <input type="hidden" name="subject_id" id="subject_id" value="{{ $subject->id }}">
                <div class="form-group">
                    <select class="form-control" id="module-number" name="number">
                        <option>Numero du module</option>
                        @foreach ($remaining_modules as $module_number)
                            <option value="{{ $module_number }}">{{ $module_number }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="customFile" name="module_files" multiple>
                        <label class="custom-file-label" for="customFile">Ajouter un document</label>
                    </div>
                </div>
                <div class="form-group">
                    <ul id="file-names"></ul>
                </div>
                <button type="submit" class="btn btn-primary">Ajouter</button>
                <a href="{{ route('edit-subject', ['subject' => $subject]) }}" 
                    class="btn btn-secondary">
                    Annuler
                </a>
            </form>
            <hr>
            <div class="form-group">
                <a href="{{ route('home') }}">Retour au profile</a>
            </div>
        </div>
    </div>

    <hr>
    
    @include('list-of-modules')
     
</div>

@endsection
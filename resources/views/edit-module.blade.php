
@extends('layouts.app')

@section('content')
    
<div class="container">

    <div class="row justify-content-center">
        <div class="col-lg-6 col-sm-12">
            
            <h4>Editer</h4>
            <h5>Moodule {{ $module->number }}: {{ $module->title }}</h5>
            <h6>Matiere: {{ $module->subject->name }}</h6>
            <h6>Classe: {{ $module->subject->classe->name }}</h6>

            @include('error-success-message')

            <form
                id="edit-module"
                method="POST"
                action="{{ route('update-module', ['module' => $module]) }}"
                enctype="multipart/form-data"
            >
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

                <div class="form-group">
                    <div class="custom-file">
                        <input 
                            type="file"
                            class="custom-file-input"
                            id="customFile"
                            name="module_files[]"
                            accept=".pdf,.txt,.jpg,.jpeg,.png"
                            multiple
                        >
                        <label class="custom-file-label" for="customFile">Ajouter un document</label>
                    </div>
                </div>

                @method('PUT')
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <a href="{{ route('edit-subject', ['subject' => $module->subject]) }}" 
                    class="btn btn-secondary">
                    Annuler
                </a>
            </form>
            
            <hr>

            <form id="delete-module-file" 
                action="{{ route('delete-module-up-file', ['module' => $module]) }}"
                method="POST">
                @csrf
                @method('DELETE')
                <div class="form-group">
                    <ul>
                        @foreach($module->uploadedFiles as $file)
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
                <a href="{{ route('create-chapter', ['module' => $module]) }}">Ajouter un chapitre</a>
            </div>
            <div class="form-group">
                <a href="{{ route('create-module-homework', ['module' => $module]) }}">Ajouter un devoir</a>
            </div>
            <div class="form-group">
                <a href="{{ route('edit-subject', ['subject' => $module->subject]) }}">Retour a la matiere</a>
            </div>
            <div class="form-group">
                <a href="{{ route('home') }}">Retour au profile</a>
            </div>
        </div>
    </div>

    <hr>

    @include('list-of-module-chapters')
    @include('list-of-module-homeworks')

</div>

@endsection
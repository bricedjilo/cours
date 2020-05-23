@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-sm-12">
            
            <h4>Ajouter un chapitre a ce module</h4>
            <h6>Module {{ $module->number }}: {{ $module->title }}</h6>

            <form method="POST" action="/chapters">
                @csrf
                <div class="form-group">
                    <input type="text"
                        name="{{ $module->subject->id }}"
                        class="form-control" disabled
                        id="subject-name" 
                        value="{{ $module->subject->name }} - {{ $module->subject->classe->name }}">
                </div>
                <div class="form-group">
                    <input type="text"
                        name="title"
                        class="form-control" 
                        id="chapter-title" 
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
                    <textarea class="form-control"
                        name="description"
                        rows="6"
                        id="chapter-description" 
                        placeholder="Description du chapitre">
                    </textarea>
                </div>
                <div class="form-group">
                    <select class="form-control" id="chapter-module" name="module_id">
                        <option>Selectionner le module</option>
                        @foreach ($module->subject->modules->sortBy('number') as $module)
                            <option value="{{ $module->id }}">
                                {{ $module->number }}: - {{ $module->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                    <a href="{{ route('home') }}" 
                        class="btn btn-secondary">
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

    @include('list-of-module-chapters')

</div>
@endsection
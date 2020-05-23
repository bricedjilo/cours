
@extends('layouts.app')

@section('content')
    
<div class="container">

    <div class="row justify-content-center">
        <div class="col-lg-6 col-sm-12">

            @include('error-success-message')
            
            <h4>Ajouter un devoir a ce module</h4>
            <h6>Module {{ $module->number }}: {{ $module->title }}</h4>

            <form method="POST" action="/homeworks">
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
                        id="homework-title" 
                        placeholder="Titre du devoir">
                </div>
                <input type="hidden" name="module_id" id="module_id" value="{{ $module->id }}">
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
                <button type="submit" class="btn btn-primary">Ajouter</button>
                <a href="{{ route('edit-module', ['module' => $module]) }}" 
                    class="btn btn-secondary">
                    Annuler
                </a>
            </form>
            <hr>
            <div class="form-group">
                <a href="{{ route('edit-module', ['module' => $module]) }}">Retour au module</a>
            </div>
            <div class="form-group">
                <a href="{{ route('home') }}">Retour au profile</a>
            </div>
        </div>
    </div>

    <hr>
    
    @include('list-of-module-homeworks')
     
</div>

@endsection
@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row mb-4 justify-content-center">
        <div class="col-md-10">
            <a href="{{ Route('home') }}">Profile</a>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-10 col-sm-12 col-xs-12">
            <h2>Manager les eleves</h2>
            <hr>
            <h4><a href="{{ route('admin-create-student') }}">Ajouter un eleve</a></h4>
            <h4><a href="{{ route('admin-search') }}">Modifier un eleve</a></h4>
            <h4><a href="{{ route('admin-search') }}">Supprimer un eleve</a></h4>
        </div>
    </div>
    <div class="row justify-content-center mt-4">
        <div class="col-lg-6 col-md-10 col-sm-12 col-xs-12">
            <h2>Manager les Professeurs</h2>
            <hr>
            <h4><a href="{{ route('admin-create-professor') }}">Ajouter un prof</a></h4>
            <h4><a href="{{ route('admin-search') }}">Modifier un prof</a></h4>
            <h4><a href="{{ route('admin-search') }}">Supprimer un prof</a></h4>
        </div>
    </div>
    <div class="row justify-content-center mt-4">
        <div class="col-lg-6 col-md-10 col-sm-12 col-xs-12">
            <h2>Manager le Staff</h2>
            <hr>
            <h4><a href="{{ route('admin-create-staff') }}">Ajouter un membre du staff</a></h4>
            <h4><a href="{{ route('admin-search') }}">Modifier un membre du staff</a></h4>
            <h4><a href="{{ route('admin-search') }}">Supprimer un membre du staff</a></h4>
        </div>
    </div>
    <hr>
    <div class="row justify-content-center mt-4">
        <div class="col-lg-6 col-md-10 col-sm-12 col-xs-12">
            <h4><a href="{{ route('admin-search') }}">Rechercher un compte</a></h4>
        </div>
    </div>
</div>

@endsection
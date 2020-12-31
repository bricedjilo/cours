@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center mb-4">
        <div class="col-md-10">
            <a href="{{ Route('admin-home') }}">Admin home</a>
        </div>
    </div>
</div>
<hr>
@include('admin.partials.search')

<hr>
@if (!empty($user))
<div class="container">
    <h2>Resultats</h2>
    <div class="row justify-content-center">

    </div>
</div>
@endif

@endsection
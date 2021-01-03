@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mb-4">
        <div class="col-md-10">
            <a href="{{ Route('admin-home') }}">Admin home</a>
        </div>
    </div>
</div>
@include('auth.register')
@endsection
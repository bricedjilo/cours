@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-10">
            <a href="{{ Route('admin-home') }}">Admin home</a>
        </div>
    </div>
    @include('admin.partials.search')
</div>

@endsection
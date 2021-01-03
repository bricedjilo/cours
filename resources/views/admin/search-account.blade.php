@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-10">
            <a href="{{ Route('admin-home') }}">Admin home</a>
        </div>
    </div>
    @include('error-success-message')
    @include('admin.partials.search')

    @if (!empty($users) && count($users) > 0)
    <hr>
    <h2>Resultats</h2>

    <div class="form-group">
        <div class="row">
            <ul>
                @foreach($users->sortBy('first_name') as $user)
                <form id="delete-account-{{$user->id}}" action="{{ route('admin-delete-account', ['user' => $user]) }}"
                    method="POST">
                    @method('DELETE')
                    @csrf
                    <li class="mb-2">
                        <a href="{{ Route('admin-edit-account', ['user' => $user->id]) }}" target="_blank">
                            {{$user->first_name}} {{$user->last_name}} |
                            {{$user->email}}
                        </a>
                        <button type="submit" class="btn btn-default">
                            <i class="far fa-trash-alt" style="color: red;"></i>
                        </button>
                        <a href="{{ Route('admin-edit-account', ['user' => $user->id]) }}" target="_blank"
                            class="btn btn-light mx-3">
                            <i class="far fa-edit" style="color: grey;"></i>
                        </a>
                    </li>
                </form>
                @endforeach
            </ul>
        </div>
    </div>
    @endif
</div>

@endsection
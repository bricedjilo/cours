@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-10 col-sm-12 col-xs-12">
            <div class="card">
                <span class="card-header">
                    Nom: 
                    <b>{{ $user->first_name }} 
                    {{ $user->last_name }}</b>
                </span>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <td>Statut: </td>
                                <td>
                                    @if ($user->is_student)
                                        <div>{{ __('Eleve') }}</div>
                                    @else 
                                        <div>{{ __('Professeur') }}</div>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Classe(s): </td>
                                <td>
                                @if (!empty($user->classes))
                                    @foreach($user->classes as $class)
                                        {{ $class->name }},
                                    @endforeach
                                @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Matiere(s): </td>
                                <td>
                                    @if ($user->classes->count())
                                    <ul>
                                        @foreach ($user->classes as $class)
                                            @if($class->subjects->count())
                                                @foreach($class->subjects as $subject)
                                                <li>
                                                    <a href="/subjects/{{ $subject->id }}/edit">
                                                        {{ $subject->name }} - {{ $class->name }}
                                                    </a>
                                                </li>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </ul>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <hr>
</div>

@if ($user->classes->count())
<div class="container">
    <div class="row justify-content-center">
        @foreach ($user->classes as $class)

            @foreach ($class->subjects as $subject)
                @include('subject')
            @endforeach

        @endforeach
    </div>
</div>
@endif

@endsection

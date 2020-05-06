@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-10 col-sm-12 col-xs-12">
            <div class="card">
                <span class="card-header">
                    Nom: 
                    {{ $user->first_name }} 
                    {{ $user->last_name }}
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
                                        <div>Eleve</div>
                                    @else 
                                        <div>Professeur</div>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Classe: </td>
                                <td>
                                @if (!empty($user->classe))
                                    {{ $user->classe->name }}
                                @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Matieres: </td>
                                <td>
                                    @if (!empty($user->classe))
                                    <ul>
                                        @foreach ($classe->subjects as $subject)
                                            <li><a href="/subjects/{{ $subject->id }}/edit">
                                                {{ $subject->name }} - {{ $classe->name }}
                                            </a></li>
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

@if (!empty($user->classe))
<div class="container">
    <div class="row justify-content-center">
        @foreach ($classe->subjects as $subject)

            @include('subject')

        @endforeach
    </div>
</div>
@endif

@endsection

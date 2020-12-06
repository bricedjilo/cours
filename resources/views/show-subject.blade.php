@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-10 col-sm-12 col-xs-12">
            <div class="card">
                <span class="card-header">
                    Matiere:
                    <b>{{ $subject->name }} - {{ $subject->classe->name }}</b>
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
                                <td>Description: </td>
                                <td>
                                    {{ $subject->description }}
                                </td>
                            </tr>
                            <?php $user = $subject->user;?>
                            <tr>
                                <td>Professeur: </td>
                                <td>{{ $user->first_name }} {{ $user->last_name }} </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <hr>
    @include('list-of-modules')
</div>

@endsection
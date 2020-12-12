@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-10 col-sm-12 col-xs-12">
            <div class="card">
                <h5 class="card-header">
                    Homework <b>{{ $homework->number }}:
                        {{ $homework->title }}</b>
                </h5>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <td>Title: </td>
                                <td>
                                    {{ $homework->title }}
                                </td>
                            </tr>
                            <tr>
                                <td>Number: </td>
                                <td>
                                    {{ $homework->number }}
                                </td>
                            </tr>
                            <tr>
                                <td>Contenu: </td>
                                <td>
                                    {{ $homework->number }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
            @include('breadcrum')
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <h5 class="card-header">
                    Module <b>{{ $module->number }}:
                        {{ $module->title }}</b>
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
                                    {{ $module->title }}
                                </td>
                            </tr>
                            <tr>
                                <td>Number: </td>
                                <td>
                                    {{ $module->number }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <hr>
    @include('lists.list-of-module-chapters')
    <hr>
    @include('lists.list-of-module-homeworks')
</div>
@endsection
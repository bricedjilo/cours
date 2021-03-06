@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-10 col-sm-12 col-xs-12">
            @include('breadcrum')
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-10 col-sm-12 col-xs-12">
            <div class="card">
                <h5 class="card-header">
                    Leçon <b>{{ $lesson->number }}:
                        {{ $lesson->title }}</b>
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
                                    {{ $lesson->title }}
                                </td>
                            </tr>
                            <tr>
                                <td>Number: </td>
                                <td>
                                    {{ $lesson->number }}
                                </td>
                            </tr>
                            <tr>
                                <td>Description: </td>
                                <td>
                                    {{ $lesson->description }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <h4>Documents</h4>
    <div>
        @foreach($lesson->uploadedFiles as $file)
        <ul>
            <li>
                <a href="{{ $file->url }}" target="_blank">{{ $file->name }}</a>
            </li>
        </ul>
        @endforeach
    </div>
    <hr>
    @include('lists.list-of-lesson-homeworks')
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mb-4">
        <div class="col-lg-6 col-md-12 col-sm-12 mb-2">
            <a href="{{ Route('admin-home') }}">Admin home</a>
        </div>
    </div>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-12 col-sm-12 mb-2">
            <h2>Modifier ce compte</h2>
        </div>
    </div>
    <div class="row justify-content-center">

        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin-update-account', ['user' => $user]) }}">
                        @csrf
                        @include('error-success-message')
                        <div class="form-group row">
                            <label for="first_name" class="col-md-4 col-form-label text-md-right">{{ __('Prenom') }}
                            </label>

                            <div class="col-md-6">
                                <input id="first_name" type="text"
                                    class="form-control @error('first_name') is-invalid @enderror" name="first_name"
                                    value="{{ $user->first_name }}" required autocomplete="first_name" autofocus>

                                @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="last_name"
                                class="col-md-4 col-form-label text-md-right">{{ __('Nom de Famille') }}
                            </label>

                            <div class="col-md-6">
                                <input id="last_name" type="text"
                                    class="form-control @error('last_name') is-invalid @enderror" name="last_name"
                                    value="{{ $user->last_name }}" required autocomplete="last_name" autofocus>

                                @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ $user->email }}" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <fieldset class="form-group">
                            <div class="row">
                                <legend class="col-form-label col-md-4 col-sm-2 text-md-right pt-0">
                                    {{ __('Status') }}
                                </legend>
                                <div class="col-md-6 col-sm-10">
                                    @if($user->is_student)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="status-student"
                                            value="student" checked>
                                        <label class="form-check-label" for="statut-student">
                                            {{ __('Eleve') }}
                                        </label>
                                    </div>
                                    @elseif($user->is_teacher)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="status-prof"
                                            value="professor" checked>
                                        <label class="form-check-label" for="statut-prof">
                                            {{ __('Professeur') }}
                                        </label>
                                    </div>
                                    @else
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="status-staff"
                                            value="staff" checked>
                                        <label class="form-check-label" for="statut-staff">
                                            {{ __('Staff') }}
                                        </label>
                                    </div>
                                    @endif

                                    @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </fieldset>

                        @if($user->is_admin)
                        <fieldset class="form-group">
                            <div class="row">
                                <label class="col-form-label col-md-4 col-sm-2 text-md-right pt-0" for="is-admin">
                                    {{ __('Administrateur') }}
                                </label>
                                <div class="col-md-6 col-sm-10">
                                    <div class="form-check">
                                        <input type="checkbox" name='is_admin' class="form-check-input" id="is_admin"
                                            checked>
                                    </div>
                                </div>
                                @error('is_admin')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </fieldset>
                        @endif

                        <!-- <div class="form-group row">
                            <label for="password"
                                class="col-md-4 col-form-label text-md-right">{{ __('Mot de passe') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div> -->

                        <!-- <div class="form-group row">
                            <label for="password-confirm"
                                class="col-md-4 col-form-label text-md-right">{{ __('Confirmez le mot de passe') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password">

                                @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div> -->

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                @method('PUT')
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Modifier') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
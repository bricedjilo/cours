@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Create an account') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label 
                                for="first_name" 
                                class="col-md-4 col-form-label text-md-right">{{ __('First Name') }}
                            </label>

                            <div class="col-md-6">
                                <input 
                                    id="first_name" 
                                    type="text" 
                                    class="form-control @error('first_name') is-invalid @enderror" 
                                    name="first_name" value="{{ old('first_name') }}" 
                                    required autocomplete="first_name" autofocus>

                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label 
                                for="last_name" 
                                class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }}
                            </label>

                            <div class="col-md-6">
                                <input 
                                    id="last_name" 
                                    type="text" 
                                    class="form-control @error('last_name') is-invalid @enderror" 
                                    name="last_name" 
                                    value="{{ old('last_name') }}" 
                                    required autocomplete="last_name" 
                                    autofocus>

                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input
                                    id="email"
                                    type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required autocomplete="email"
                                >

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <fieldset class="form-group">
                            <div class="row">
                                <legend
                                    class="col-form-label col-md-4 col-sm-2 text-md-right pt-0"
                                >
                                    {{ __('Status') }}
                                </legend>
                                <div class="col-md-6 col-sm-10">
                                    <div class="form-check">
                                        <input
                                            class="form-check-input"
                                            type="radio"
                                            name="status"
                                            id="statut-student"
                                            value="student"
                                            checked
                                        >
                                        <label class="form-check-label" for="statut-student">
                                            {{ __('Student') }}
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="statut-prof" value="prof">
                                        <label class="form-check-label" for="statut-prof">
                                        {{ __('Professor') }}
                                        </label>
                                    </div>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </fieldset>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
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

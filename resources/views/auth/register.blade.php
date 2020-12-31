<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    {{ __('Ajouter un compte') }}
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        @include('error-success-message')
                        <div class="form-group row">
                            <label for="first_name" class="col-md-4 col-form-label text-md-right">{{ __('Prenom') }}
                            </label>

                            <div class="col-md-6">
                                <input id="first_name" type="text"
                                    class="form-control @error('first_name') is-invalid @enderror" name="first_name"
                                    value="{{ old('first_name') }}" required autocomplete="first_name" autofocus>

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
                                    value="{{ old('last_name') }}" required autocomplete="last_name" autofocus>

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
                                    name="email" value="{{ old('email') }}" required autocomplete="email">

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
                                    @if(Route::currentRouteName() == 'admin-create-student')
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="statut-student"
                                            value="student" checked>
                                        <label class="form-check-label" for="statut-student">
                                            {{ __('Eleve') }}
                                        </label>
                                    </div>
                                    @elseif(Route::currentRouteName() == 'admin-create-professor')
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="statut-prof"
                                            value="professor" checked>
                                        <label class="form-check-label" for="statut-prof">
                                            {{ __('Professeur') }}
                                        </label>
                                    </div>
                                    @else
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="statut-staff"
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

                        @if(Route::currentRouteName() == 'admin-create-professor')
                        <fieldset class="form-group">
                            <div class="row">
                                <label class="col-form-label col-md-4 col-sm-2 text-md-right pt-0" for="is-admin">
                                    {{ __('Administrateur') }}
                                </label>
                                <div class="col-md-6 col-sm-10">
                                    <div class="form-check">
                                        <input type="checkbox" name='is_admin' class="form-check-input" id="is_admin">
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

                        <div class="form-group row">
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
                        </div>

                        <div class="form-group row">
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
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Enregistrer') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
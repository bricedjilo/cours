<h2>Rechercher un compte</h2>
<hr>
<form method="POST" action="{{ route('admin-find-account') }}">
    @csrf
    <div class="form-group row">
        <label for="first-name" class="col-sm-3 col-form-label">Prenom</label>
        <div class="col-sm-9">
            <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror"
                name="first_name" value="{{ old('first_name') }}" autocomplete="first_name" autofocus>
            @error('first_name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="last-name" class="col-sm-3 col-form-label">Nom de famille</label>
        <div class="col-sm-9">
            <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror"
                name="last_name" value="{{ old('last_name') }}" autocomplete="last_name">
            @error('last_name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-10">
            <button type="submit" class="btn btn-primary">Rechercher</button>
        </div>
    </div>
</form>
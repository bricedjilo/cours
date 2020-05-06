
<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12" style="margin-bottom: 35px;">
    <div class="card">
    <a href="/subjects/{{ $subject->id }}">
        <img class="card-img-top" src="https://picsum.photos/200/100" alt="Card image cap">
    </a>
    <div class="card-body">
        <h5 class="card-title">
            <a href="/subjects/{{ $subject->id }}">{{ $subject->name }} - {{ $classe->name }}</a>
        </h5>
        <hr>
        <div>
            <p><b>Enseignant</b>: {{ $subject->user->first_name }} {{ $subject->user->last_name }}</p>
        </div>
        <hr>
        <div>
            <p class="card-text"><b>Description</b>: {{ $subject->description }}</p>
        </div>
        <hr>
        <a href="/subjects/{{ $subject->id }}" class="btn btn-primary">Plus d'information</a>
    </div>
    </div>
</div>
<?php $book = \App\Book::where([
    ['subject_id', '=', $subject->id],
    ['classe_id', '=', $subject->classe->id],
])->get()->first();?>

<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12" style="margin-bottom: 35px;">
    <div class="card">
        <a href="/subjects/{{ $subject->id }}/edit">
            @if($book)
            <img class="card-img-top img-fluid" src="{{ $book->image }}" height='125' alt="Card image cap">
            @else
            <img class="card-img-top" src="https://picsum.photos/200/100" alt="Card image cap">
            @endif
        </a>
        <div class="card-body">
            <h5 class="card-title">
                <a href="/subjects/{{ $subject->id }}/edit">{{ $subject->name }} - {{ $subject->classe->name }}</a>
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
            <div>
                @if ($book)
                <p class="card-text"><b>Book</b>: {{ $book->title }}</p>
                @endif
            </div>
            <hr>
            <a href="/subjects/{{ $subject->id }}/edit" class="btn btn-primary">Plus d'information</a>
        </div>
    </div>
</div>
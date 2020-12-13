<div>
    <h3>Liste des devoirs</h3>
    <ul class="list-of-lesson-homeworks">

        @foreach ($lesson->homeworks->sortBy('number') as $homework)

        <li>
            @if (auth()->user()->is_teacher)
            <a href="/homeworks/{{ $homework->id }}/lesson/edit">
                @else
                <a href="/homeworks/{{ $homework->id }}/lesson/show">
                    @endif
                    Devoir {{ $homework->number }}: {{ $homework->title }}
                </a>
        </li>

        @endforeach
    </ul>
</div>
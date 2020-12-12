<div>
    <h3>Liste des devoirs</h3>
    <ul class="list-of-chapter-homeworks">

        @foreach ($chapter->homeworks->sortBy('number') as $homework)

        <li>
            @if (auth()->user()->is_teacher)
            <a href="/homeworks/{{ $homework->id }}/chapter/edit">
                @else
                <a href="/homeworks/{{ $homework->id }}/chapter/show">
                    @endif
                    Devoir {{ $homework->number }}: {{ $homework->title }}
                </a>
        </li>

        @endforeach
    </ul>
</div>
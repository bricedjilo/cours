<div>
    <h3>Liste des leçons</h3>
    <ul class="list-of-chapter-lessons">

        @foreach ($chapter->lessons->sortBy('number') as $lesson)

        <li>
            @if (auth()->user()->is_teacher)
            <a href="/lessons/{{ $lesson->id }}/edit">
                @else
                <a href="/chapters/{{ $chapter->id }}/show">
                    @endif
                    Leçon {{ $lesson->number }}: {{ $lesson->title }}
                </a>
        </li>

        @endforeach
    </ul>
</div>
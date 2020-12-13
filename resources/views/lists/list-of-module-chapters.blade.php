<div>
    <h3>Liste des chapitres</h3>
    <ul class="list-of-module-chapters">

        @foreach ($module->chapters->sortBy('number') as $chapter)

        <li>
            @if (auth()->user()->is_teacher)
            <a href="/chapters/{{ $chapter->id }}/edit">
                @else
                <a href="/chapters/{{ $chapter->id }}/show">
                    @endif
                    Chapter {{ $chapter->number }}: {{ $chapter->title }}
                </a>
                <ul>
                    @foreach ($chapter->lessons->sortBy('number') as $lesson)
                    <li>
                        @if (auth()->user()->is_teacher)
                        <a href="/lessons/{{ $lesson->id }}/edit">
                            @else
                            <a href="/lessons/{{ $lesson->id }}/show">
                                @endif
                                Leçon {{ $lesson->number }}: {{ $lesson->title }}
                    </li>
                    @endforeach
                </ul>
        </li>

        @endforeach
    </ul>
</div>
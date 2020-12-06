<div class="container">
    <h3>Liste des modules</h3>
    <?php $logged_in_user = auth()->user();?>
    <ul class="list-modules-chapters">
        @foreach ($subject->modules->sortBy('number') as $module)
        <li>
            @if ($logged_in_user->is_teacher)
            <a href="/modules/{{ $module->id }}/edit">
                @else
                <a href="/modules/{{ $module->id }}/show">
                    @endif
                    Module {{ $module->number }}: {{ $module->title }}
                </a>
                @foreach ($module->chapters->sortBy('number') as $chapter)
                <ul>
                    <li>
                        <a href="/chapters/{{ $chapter->id }}/edit">
                            Chapter {{ $chapter->number }}: {{ $chapter->title }}
                        </a>

                        <ul>

                            @foreach ($chapter->lessons->sortBy('number') as $lesson)

                            <li>

                                <a href="/lessons/{{ $lesson->id }}/edit">
                                    Leçon {{ $lesson->number }}: {{ $lesson->title }}
                                </a>

                            </li>

                            @endforeach

                        </ul>

                    </li>
                </ul>
                @endforeach
        </li>
        @endforeach
    </ul>
</div>
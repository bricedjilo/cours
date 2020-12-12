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
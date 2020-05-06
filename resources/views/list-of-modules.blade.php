<div>
    <h3>Liste des modules</h3>
    <ul class="list-modules-chapters">
        @foreach ($subject->modules->sortBy('number') as $module)
            <li>
                <a href="/modules/{{ $module->id }}/edit">
                    Module {{ $module->number }}: {{ $module->title }}
                </a>
                @foreach ($module->chapters->sortBy('number') as $chapter)
                    <ul>
                        <li>
                            <a href="/chapters/{{ $chapter->id }}/edit">
                                Chapter {{ $chapter->number }}: {{ $chapter->title }}
                            </a>
                        </li>
                    </ul>
                @endforeach
            </li>
        @endforeach
    </ul>
</div>
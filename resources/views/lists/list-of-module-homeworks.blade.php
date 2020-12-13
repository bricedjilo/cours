<div>
    <h3>Liste des devoirs</h3>
    <ul class="list-of-module-homeworks">

        @foreach ($module->homeworks->sortBy('number') as $homework)

        <li>
            @if (auth()->user()->is_teacher)
            <a href="/homeworks/{{ $homework->id }}/module/edit">
                @else
                <a href="/homeworks/{{ $homework->id }}/module/show">
                    @endif
                    Devoir {{ $homework->number }}: {{ $homework->title }}
                </a>
        </li>

        @endforeach
    </ul>
</div>
<div>
    <h3>Liste des devoirs</h3>
    <ul class="list-of-module-homeworks">
        
        @foreach ($module->homeworks->sortBy('number') as $homework)
            
            <li>
                <a href="/homeworks/{{ $homework->id }}/module/edit">
                    Devoir {{ $homework->number }}: {{ $homework->title }}
                </a>
            </li>
            
        @endforeach
    </ul>
</div>
<div>
    <h3>Liste des devoirs</h3>
    <ul class="list-of-lesson-homeworks">
        
        @foreach ($lesson->homeworks->sortBy('number') as $homework)
            
            <li>
                <a href="/homeworks/{{ $homework->id }}/lesson/edit">
                    Devoir {{ $homework->number }}: {{ $homework->title }}
                </a>
            </li>
            
        @endforeach
    </ul>
</div>
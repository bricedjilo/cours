<div>
    <h3>Liste des devoirs</h3>
    <ul class="list-of-chapter-homeworks">
        
        @foreach ($chapter->homeworks->sortBy('number') as $homework)
            
            <li>
                <a href="/homeworks/{{ $homework->id }}/edit">
                    Devoir {{ $homework->number }}: {{ $homework->title }}
                </a>
            </li>
            
        @endforeach
    </ul>
</div>
<div>
    <h3>Liste des chapitres</h3>
    <ul class="list-of-module-chapters">
        
        @foreach ($module->chapters->sortBy('number') as $chapter)
            
            <li>
                <a href="/chapters/{{ $chapter->id }}/edit">
                    Chapter {{ $chapter->number }}: {{ $chapter->title }}
                </a>
            </li>
            
        @endforeach
    </ul>
</div>
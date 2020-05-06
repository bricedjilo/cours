<div>
    <h3>Liste des Lessons</h3>
    <ul class="list-of-chapter-lessons">
        
        @foreach ($chapter->lessons->sortBy('number') as $lesson)
            
            <li>
                <a href="/chapters/{{ $chapter->id }}/edit">
                    Lesson {{ $lesson->number }}: {{ $lesson->title }}
                </a>
            </li>
            
        @endforeach
    </ul>
</div>
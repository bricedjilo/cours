<div>
    <h3>Liste des leçons</h3>
    <ul class="list-of-chapter-lessons">
        
        @foreach ($chapter->lessons->sortBy('number') as $lesson)
            
            <li>
                <a href="/lessons/{{ $lesson->id }}/edit">
                    Lesson {{ $lesson->number }}: {{ $lesson->title }}
                </a>
            </li>
            
        @endforeach
    </ul>
</div>
<div class="mt-2 mb-4">
    <a href="/home">{{ auth()->user()->classes()->first()->name }}</a>

    @if(!empty($homework))

    @if(!empty($homework->lesson))
    <span class="font-weight-bold">
        <span class="mx-2">></span>
        <a href="/modules/{{$homework->lesson->chapter->module->id}}/show">{{__('Module')}}</a>
        <span class="mx-2">></span>
        <a href="/chapters/{{$homework->lesson->chapter->id}}/show">{{__('Chapitre')}}</a>
        <span class="mx-2">></span>
        <a href="/lessons/{{$homework->lesson->id}}/show">{{__('Leçon')}}</a>
    </span>
    <span class="mx-2">></span>{{__('Devoir')}}
    @endif
    @if(!empty($homework->chapter))
    <span class="font-weight-bold">
        <span class="mx-2">></span>
        <a href="/modules/{{$homework->chapter->module->id}}/show">{{__('Module')}}</a>
        <span class="mx-2">></span>
        <a href="/chapters/{{$homework->chapter->id}}/show">{{__('Chapitre')}}</a>
    </span>
    <span class="mx-2">></span>
    {{__('Devoir')}}
    @endif
    @if(!empty($homework->module))
    <span class="font-weight-bold">
        <span class="mx-2">></span>
        <a href="/modules/{{$homework->module->id}}/show">{{__('Module')}}</a>
    </span>
    <span class="font-weight-bold">
        <span class="mx-2">></span>
        {{__('Devoir')}}
    </span>
    @endif

    @endif

    @if(!empty($lesson))
    <span class="font-weight-bold">
        <span class="mx-2">></span>
        <a href="/modules/{{$lesson->chapter->module->id}}/show">{{__('Module')}}</a>
        <span class="mx-2">></span>
        <a href="/chapters/{{$lesson->chapter->id}}/show">{{__('Chapitre')}}</a>
        <span class="mx-2">></span>
        {{__('Leçon')}}
    </span>
    @endif

    @if(!empty($chapter))
    <span class="font-weight-bold">
        <span class="mx-2">></span>
        <a href="/modules/{{$chapter->module->id}}/show">{{__('Module')}}</a>
        <span class="mx-2">></span>{{__('Chapitre')}}
    </span>
    @endif

    @if(!empty($module))
    <span class="font-weight-bold">
        <span class="mx-2">></span>{{__('Module')}}
    </span>
    @endif

</div>
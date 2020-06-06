@if($model instanceof App\Question)
    @php
        $name = 'question';
        $firstURISegment = 'questions';
    @endphp
@elseif($model instanceof App\Answer)
    @php
        $name = 'answer';
        $firstURISegment = 'answers';
    @endphp
@endif

@php
    $formId = $name ."-". $model->id;
    $url = "/".$firstURISegment."/".$model->id."/vote";
@endphp

<div class="d-flex flex-column vote-controls">

    {{-- up vote <a> tag --}}
    <a title="This {{ $name }} is useful"
       class="vote-up {{ \Illuminate\Support\Facades\Auth::guest() ? 'off' : '' }}"
       onclick="event.preventDefault(); document.getElementById('up-vote-{{ $formId }}').submit();"
    >
        <i class="fas fa-caret-up fa-2x"></i>
    </a>

    {{-- up vote form --}}
    <form action="{{ $url }}" method="post" style="display: none" id="up-vote-{{ $formId }}">
        @csrf
        <input type="hidden" name="vote" value="1">
    </form>

    {{-- total votes --}}
    <span class="votes-count">{{ $model->votes_count }}</span>

    {{-- down vote <a> tag --}}
    <a title="This {{ $name }} is not useful"
       class="vote-down {{ \Illuminate\Support\Facades\Auth::guest() ? 'off' : '' }}"
       onclick="event.preventDefault(); document.getElementById('down-vote-{{ $formId }}').submit();"
    >
        <i class="fas fa-caret-down fa-2x"></i>
    </a>

    {{-- down vote form --}}
    <form action="{{ $url }}" method="post" style="display: none" id="down-vote-{{ $formId }}">
        @csrf
        <input type="hidden" name="vote" value="-1">
    </form>

    @if($model instanceof App\Question)
        @include('shared._favourite', ['model' => $question])
    @elseif($model instanceof App\Answer)
        @include('shared._accept', ['model' => $answer])
    @endif

</div>

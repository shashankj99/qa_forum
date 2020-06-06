{{-- accept answer policy check --}}
@can('accept', $model)
    {{-- mark as best answer <a>..</a> --}}
    <a title="Mark this answer as the best answer"
       class="{{ $model->status }} mt-2"
       onclick="event.preventDefault(); document.getElementById('accept-answer-{{ $model->id }}').submit();"
    >
        <i class="fas fa-check fa-2x"></i>
    </a>

    {{-- mark as best answer form --}}
    <form action="{{ route('answers.accept', $model->id) }}" method="post" style="display: none" id="accept-answer-{{ $model->id }}">
        @csrf
    </form>
@else
    @if($model->is_best)
        <a title="This answer was marked best by the question owner"
           class="{{ $model->status }} mt-2"
        >
            <i class="fas fa-check fa-2x"></i>
        </a>
    @endif
@endcan

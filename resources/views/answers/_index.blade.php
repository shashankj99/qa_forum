<div class="row mt-5">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    {{-- make handle the grammer of the text "Answer" based on total answers --}}
                    <h2>{{ $answers_count . " " . \Illuminate\Support\Str::plural('Answer', $question->answers_count) }}</h2>
                </div>
                <hr>

                {{-- include flash messages --}}
                @include('layouts._messages')

                @foreach ($answers as $answer)
                    <div class="media">

                        <div class="d-flex flex-column vote-controls">

                            {{-- up-vote a tag --}}
                            <a title="This answer is useful" class="vote-up">
                                <i class="fas fa-caret-up fa-2x"></i>
                            </a>

                            {{-- vote count --}}
                            <span class="votes-count">1230</span>

                            {{-- down-vote a tag --}}
                            <a title="This answer is not useful" class="vote-down off">
                                <i class="fas fa-caret-down fa-2x"></i>
                            </a>

                            {{-- accept answer policy check --}}
                            @can('accept', $answer)
                                {{-- mark as best answer <a>..</a> --}}
                                <a title="Mark this answer as the best answer"
                                   class="{{ $answer->status }} mt-2"
                                    onclick="event.preventDefault(); document.getElementById('accept-answer-{{ $answer->id }}').submit();"
                                >
                                    <i class="fas fa-check fa-2x"></i>
                                </a>

                                {{-- mark as best answer form --}}
                                <form action="{{ route('answers.accept', $answer->id) }}" method="post" style="display: none" id="accept-answer-{{ $answer->id }}">
                                    @csrf
                                </form>
                            @else
                                @if($answer->is_best)
                                    <a title="This answer was marked best by the question owner"
                                       class="{{ $answer->status }} mt-2"
                                    >
                                        <i class="fas fa-check fa-2x"></i>
                                    </a>
                                @endif
                            @endcan

                        </div>

                        <div class="media-body">

                            {!! $answer->body_html !!}

                            <div class="row">

                                <div class="col-4">
                                    <div class="ml-auto">

                                        {{-- update answer policy check --}}
                                        @can('update', $answer)
                                            <a href="{{ route('questions.answers.edit', [$question->id, $answer->id]) }}"
                                               class="btn btn-sm btn-outline-info">Edit</a>
                                        @endcan
                                        @can('delete', $answer)
                                            <form action="{{ route('questions.answers.destroy', [$question->id, $answer->id]) }}"
                                                  class="form-delete" method="post">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('Are You sure?')">Delete
                                                </button>
                                            </form>
                                        @endcan

                                    </div>
                                </div>

                                <div class="col-4"></div>

                                <div class="col-4">

                                    {{-- general Info column --}}
                                    <div class="float-right">
                                        <span class="text-muted">Answered {{ $answer->created_date }}</span>
                                        <div class="media mt-2">
                                            <a href="{{ $answer->user->url }}" class="pr-2">
                                                <img src="{{ $answer->user->avatar }}" alt="">
                                            </a>
                                            <div class="media-body mt-1">
                                                <a href="{{ $answer->user->url }}">{{ $answer->user->name }}</a>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>
                    <hr>
                @endforeach

            </div>

        </div>

    </div>

</div>

@if($answers_count > 0)
    <div class="row mt-5">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        {{-- handle the grammer of the text "Answer" based on total answers --}}
                        <h2>{{ $answers_count . " " . \Illuminate\Support\Str::plural('Answer', $question->answers_count) }}</h2>
                    </div>
                    <hr>

                    {{-- include flash messages --}}
                    @include('layouts._messages')

                    @foreach ($answers as $answer)
                        <div class="media">

                            {{-- include vote view --}}
                            @include('shared._vote', ['model' => $answer])

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
{{--                                        @include('shared._author', ['model' => $answer, 'label' => "Answered"])--}}
                                        <user-info :model="{{ $answer }}" label="Asked "></user-info>
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
@endif

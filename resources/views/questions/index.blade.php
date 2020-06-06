@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h2>Questions</h2>
                            <div class="ml-auto">
                                <a href="{{ route('questions.create') }}" class="btn btn-outline-secondary">Ask
                                    Questions</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        {{-- include flash messages --}}
                        @include('layouts._messages')

                        @forelse($questions as $question)
                            <div class="media">
                                <div class="d-flex flex-column counters">
                                    {{-- handle the grammer of the text "Votes" based on total Votes --}}
                                    <div class="vote">
                                        <strong>{{ $question->votes_count }}</strong>&nbsp;{{ \Illuminate\Support\Str::plural('vote', $question->votes_count) }}
                                    </div>

                                    {{-- add the CSS class based on answer &/or best answer --}}
                                    <div class="status {{ $question->status }}">
                                        {{-- handle the grammer of the text "Answer" based on total answers --}}
                                        <strong>{{ $question->answers_count }}</strong>&nbsp;{{ \Illuminate\Support\Str::plural('answer', $question->answers_count) }}
                                    </div>

                                    {{-- handle the grammer of the text "View" based on total views --}}
                                    <div class="view">
                                        {{ $question->views ." ". \Illuminate\Support\Str::plural('view', $question->views) }}
                                    </div>
                                </div>
                                <div class="media-body">
                                    <div class="d-flex align-items-center">
                                        <h3 class="mt-0"><a href="{{ $question->url }}">{{ $question->title }}</a></h3>
                                        <div class="ml-auto">

                                            {{-- edit/update question pollicy check --}}
                                            @can('update', $question)
                                                <a href="{{ route('questions.edit', $question->id) }}"
                                                   class="btn btn-sm btn-outline-info">Edit</a>
                                            @endcan

                                            {{-- delete question pollicy check --}}
                                            @can('delete', $question)
                                                <form action="{{ route('questions.destroy', $question->id) }}"
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

                                    <p class="lead">
                                        Asked by:
                                        <a href="{{ $question->user->url }}">{{ $question->user->name }}</a>
                                        <small class="text-muted">{{ $question->created_date }}</small>
                                    </p>
                                    {{ $question->excerpt(250) }}
                                </div>
                            </div>
                            <hr>
                        @empty
                            <div class="alert alert-warning">
                                <strong>Sorry!</strong> There are no questions available
                            </div>
                        @endforelse
                        {{ $questions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


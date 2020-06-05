@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <div class="d-flex align-items-center">
                                <h1>{{ $question->title }}</h1>
                                <div class="ml-auto">
                                    <a href="{{ route('questions.index') }}" class="btn btn-outline-secondary">Go
                                        Back</a>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="media">
                            <div class="d-flex flex-column vote-controls">

                                {{-- up vote <a> tag --}}
                                <a title="This question is useful" class="vote-up">
                                    <i class="fas fa-caret-up fa-2x"></i>
                                </a>

                                {{-- total votes --}}
                                <span class="votes-count">1230</span>

                                {{-- down vote <a> tag --}}
                                <a title="This question is not useful" class="vote-down off">
                                    <i class="fas fa-caret-down fa-2x"></i>
                                </a>

                                {{-- favourite a question --}}
                                <a title="Click to mark as favourite question (click again to undo)"
                                   class="favourite mt-2 favourited">
                                    <i class="fas fa-star fa-2x"></i>
                                    <span class="favourites-count">123</span>
                                </a>

                            </div>
                            <div class="media-body">
                                {!! $question->body_html !!}
                                <div class="float-right">

                                    {{-- general Info column --}}
                                    <span class="text-muted">Question asked {{ $question->created_date }}</span>
                                    <div class="media mt-2">
                                        <a href="{{ $question->user->url }}" class="pr-2">
                                            <img src="{{ $question->user->avatar }}" alt="">
                                        </a>
                                        <div class="media-body mt-1">
                                            <a href="{{ $question->user->url }}">{{ $question->user->name }}</a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- display all answers to the question --}}
        @include('answers._index', [
            'answers_count' => $question->answers_count,
            'answers' => $question->answers
        ])

        {{-- show form only if the user is authenticated --}}
        @auth
            @include('answers._create')
        @endauth
        @guest
            <div class="row mt-5">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-center bg-warning">
                            <h4>Sign In to answer !!!</h4>
                        </div>
                    </div>
                </div>
            </div>
        @endguest

    </div>
@endsection


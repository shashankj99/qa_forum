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
                            {{-- include vote view --}}
                            @include('shared._vote', ['model' => $question])

                            <div class="media-body">
                                {!! $question->body_html !!}
                                <div class="row">
                                    <div class="col-4"></div>
                                    <div class="col-4"></div>
                                    <div class="col-4">
                                        {{-- general Info column --}}
{{--                                        @include('shared._author', ['model' => $question, 'label' => "Question Asked"])--}}
                                        <user-info :model="{{ $question }}" label="Asked "></user-info>
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


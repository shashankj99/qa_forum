@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mt-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h2>Editing answer for question: <strong>{{ $question->title }}</strong></h2>
                        </div>
                        <hr>
                        <form action="{{ route('questions.answers.update', [$question->id, $answer->id]) }}" method="post">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <textarea name="body" rows="7" class="form-control {{ $errors->has('body') ? 'is-invalid' : '' }}">{{ old('body', $answer->body) }}</textarea>
                                @error('body')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <button class="btn btn-lg btn-outline-primary" type="submit">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

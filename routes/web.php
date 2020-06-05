<?php

Route::get('/', function () {
    return redirect()->route('questions.index');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {

    Route::get('/home', 'HomeController@index')->name('home');

    Route::resource('questions', 'QuestionsController')->except('show');
    Route::resource('questions.answers', 'AnswerController')->except(['index', 'create', 'show']);
    Route::get('/questions/{slug}', 'QuestionsController@show')->name('questions.show');
    Route::post('/answers/{answer}/accept', 'AcceptAnswerController')->name('answers.accept');
});


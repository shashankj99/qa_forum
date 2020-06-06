<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// welcome page route
Route::get('/', function () {
    return redirect()->route('questions.index');
});

// authentication routes
Auth::routes();

// home page route
Route::get('/home', 'HomeController@index')->name('home');

// Routes for Question CRUD
Route::resource('questions', 'QuestionsController')->except('show');

// Routes for Answer CRUD for each question
Route::resource('questions.answers', 'AnswerController')->except(['index', 'create', 'show']);

// Route to change the default question show route (id => slug)
Route::get('/questions/{slug}', 'QuestionsController@show')->name('questions.show');

// Route to accept the answer as most genuine answer
Route::post('/answers/{answer}/accept', 'AcceptAnswerController')->name('answers.accept');

// Route to favourite/unfavourite a question
Route::post('/questions/{question}/favourite', 'FavouriteController@store')->name('question.favourite');
Route::delete('/questions/{question}/favourite', 'FavouriteController@destroy')->name('question.unfavourite');

// Route to vote a question
Route::post('/questions/{question}/vote', 'VoteQuestionController');

// Route to vote an answer
Route::post('/answers/{answer}/vote', 'VoteAnswerController');

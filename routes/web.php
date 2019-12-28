<?php

Route::get('/', function () {
    return redirect()->route('questions.index');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {

    Route::get('/home', 'HomeController@index')->name('home');

    // Question Controller
    Route::resource('questions', 'QuestionsController')->except('show');
    Route::get('/questions/{slug}', 'QuestionsController@show')->name('questions.show');

});


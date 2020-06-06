<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 *
 * @package App
 * @author Shashank Jha shashankj677@gmail.com
 */

class User extends Authenticatable
{
    use Notifiable;

    // attributes that are mass assignable
    protected $fillable = ['name', 'email', 'password'];

    // attributes that should be hidden for arrays
    protected $hidden = ['password', 'remember_token'];

    // attributes that should be cast to native types.
    protected $casts = ['email_verified_at' => 'datetime'];

    // one to many relation with question
    public function questions() {
        return $this->hasMany(Question::class);
    }

    // function to replace the default show route
    public function getUrlAttribute() {
        return '#';
    }

    // one to many relation with answers
    public function answers() {
        return $this->hasMany(Answer::class);
    }

    // get random user avatar
    public function getAvatarAttribute() {
        $email = $this->email;
        $size = 32;

        return "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?s=" . $size;
    }

    // pivot table function
    public function favourites() {
        return $this->belongsToMany(Question::class, 'favourites')
            ->withTimestamps();
    }

    // many to many polymorphic relation with question for voting
    public function voteQuestions() {
        return $this->morphedByMany(Question::class, 'votable')
            ->withTimestamps();
    }

    // many to many polymorphic relation with answer for voting
    public function voteAnswers() {
        return $this->morphedByMany(Answer::class, 'votable');
    }

    // function to handle voting a question
    public function voteQuestion(Question $question, $vote){
        // assign the relationship method to a variable
        $voteQuestions = $this->voteQuestions();

        // check if the question is already voted by the user
        if($voteQuestions->where('votable_id', $question->id)->exists())
            // if voted then update existing record
            $voteQuestions->updateExistingPivot($question, ['vote' => $vote]);
        else
            // else create a new record
            $voteQuestions->attach($question, ['vote' => $vote]);

        // getting all the votes of a question using lazy eager loading
        $question->load('votes');

        // sum all the down votes
        $downVotes = (int) $question->downVotes()->sum('vote');

        // sum all the up votes
        $upVotes = (int) $question->upVotes()->sum('vote');

        // assign the sum of up votes and down votes in the votes count property of question
        $question->votes_count = $upVotes + $downVotes;

        // save the record
        $question->save();
    }

    // function to handle voting an answer
    public function voteAnswer(Answer $answer, $vote){
        // assign the relationship method to a variable
        $voteAnswers = $this->voteAnswers();

        // check if the answer is already voted by the user
        if($voteAnswers->where('votable_id', $answer->id)->exists())
            // if voted then update existing record
            $voteAnswers->updateExistingPivot($answer, ['vote' => $vote]);
        else
            // else create a new record
            $voteAnswers->attach($answer, ['vote' => $vote]);

        // getting all the votes of an answer using lazy eager loading
        $answer->load('votes');

        // sum all the down votes
        $downVotes = (int) $answer->downVotes()->sum('vote');

        // sum all the up votes
        $upVotes = (int) $answer->upVotes()->sum('vote');

        // assign the sum of up votes and down votes in the votes count property of answer
        $answer->votes_count = $upVotes + $downVotes;

        // save the record
        $answer->save();
    }

}

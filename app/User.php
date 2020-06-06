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

    private function _vote($relationship, $model, $vote) {
        // check if the question/answer is already voted by the user
        if($relationship->where('votable_id', $model->id)->exists())
            // if voted then update existing record
            $relationship->updateExistingPivot($model, ['vote' => $vote]);
        else
            // else create a new record
            $relationship->attach($model, ['vote' => $vote]);

        // getting all the votes of a question/answer using lazy eager loading
        $model->load('votes');

        // sum all the down votes
        $downVotes = (int) $model->downVotes()->sum('vote');

        // sum all the up votes
        $upVotes = (int) $model->upVotes()->sum('vote');

        // assign the sum of up votes and down votes in the votes count property of model
        $model->votes_count = $upVotes + $downVotes;

        // save the record
        $model->save();
    }

    // function to handle voting a question
    public function voteQuestion(Question $question, $vote){
        // assign the relationship method to a variable
        $voteQuestions = $this->voteQuestions();

        // call the vote function
        $this->_vote($voteQuestions, $question, $vote);
    }

    // function to handle voting an answer
    public function voteAnswer(Answer $answer, $vote){
        // assign the relationship method to a variable
        $voteAnswers = $this->voteAnswers();

        // call the vote function
        $this->_vote($voteAnswers, $answer, $vote);
    }

}

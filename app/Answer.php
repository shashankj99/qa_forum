<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Answer
 * @package App
 * @author Shashank Jha <shashankj677@gmail.com>
 */

class Answer extends Model
{
    // use the votable trait
    use VotableTrait;

    // add properties to insert items to DB in array form
    protected $fillable = ['body', 'user_id'];

    // append created date as the model property
    protected $appends = ['created_date'];

    // many to one relation with question
    public function question() {
        return $this->belongsTo(Question::class);
    }

    // many to one relation with user
    public function user() {
        return $this->belongsTo(User::class);
    }

    // function to convert the body text into markup language
    public function getBodyHtmlAttribute() {
        return \Parsedown::instance()->text($this->body);
    }

    // function to work in collaboration with the parent function
    public static function boot() {
        parent::boot();

        // increase the answer count on adding answer, called with store() function on controller
        static::created(function($answer) {
            $answer->question->increment('answers_count');
        });

        // decrease the answer count on deleting answer, called with destroy() function on controller
        static::deleted(function($answer) {
            $answer->question->decrement('answers_count');
        });
    }

    // function to convert date in human readable format
    public function getCreatedDateAttribute() {
        return $this->created_at->diffForHumans();
    }

    // function to dynamically add vote-accepted CSS class if the answer is marked as best answer
    public function getStatusAttribute() {
        return $this->isBest() ? 'vote-accepted' : '';
    }

    // function to GET whether the answer is best or not
    public function getIsBestAttribute() {
        return $this->isBest();
    }

    // function to CHECK whether the answer is best or not
    public function isBest() {
        return $this->id === $this->question->best_answer_id;
    }

}

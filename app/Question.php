<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * Class Question
 * @package App
 * @author Shashank Jha shashankj677@gmail.com
 */

class Question extends Model
{
    // use the votable trait
    use VotableTrait;

    // add properties to insert items to DB in array form
    protected $fillable = ['title', 'body'];

    // append created date as the model property
    protected $appends = ['created_date'];

    // many to one relation with user
    public function user() {
        return $this->belongsTo(User::class);
    }

    // function to set title attribute and add a slug
    public function setTitleAttribute($value) {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    // function to replace the default show route with a slug
    public function getUrlAttribute() {
        return route('questions.show', $this->slug);
    }

    // function to display date in the human readable format
    public function getCreatedDateAttribute() {
        return $this->created_at->diffForHumans();
    }

    // function to dynamically add the CSS classes based on the answers count
    public function getStatusAttribute() {
        if ($this->answers_count > 0) {
            return ($this->best_answer_id) ? "answer-accepted" : "answered";
        }
        return "unanswered";
    }

    // function to convert the body text into markup language
    public function getBodyHtmlAttribute() {
        return strip_tags($this->bodyHtml());
    }

    // one to many relation with answers
    public function answers() {
        // order answer by maximum no of votes
        return $this->hasMany(Answer::class)->orderBy('votes_count', 'DESC');
    }

    // function to accept the best answer
    public function acceptBestAnswer($answer) {
        $this->best_answer_id = $answer->id;
        $this->save();
    }

    // pivot table function
    public function favourites() {
        return $this->belongsToMany(User::class, 'favourites')
            ->withTimestamps();
    }

    // function to CHECK whether the question is marked favourite by the user
    public function isFavourite(){
        return $this->favourites()->where('user_id', Auth::id())->count() > 0;
    }

    // function to GET if the question is favourite
    public function getIsFavouriteAttribute(){
        return $this->isFavourite();
    }

    // function for favourite count of each question
    public function getFavouritesCountAttribute(){
        return $this->favourites->count();
    }

    // function to get the striped content
    public function getExcerptAttribute() {
        return $this->excerpt(250);
    }

    // function to strip tags
    public function excerpt($length){
        return Str::limit(strip_tags($this->bodyHtml()), $length);
    }

    // function to return mark up of the body text
    public function bodyHtml(){
        return \Parsedown::instance()->text($this->body);
    }
}

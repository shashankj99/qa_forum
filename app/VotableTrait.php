<?php


namespace App;

/**
 * Trait VotableTrait
 * @package App
 * @author Shashank Jha <shahsankj677@gmail.com>
 */

trait VotableTrait
{
    // many to many polymorphic relation with user for votes
    public function votes() {
        return $this->morphToMany(User::class, 'votable')
            ->withTimestamps();
    }

    // function to get all up votes
    public function upVotes(){
        return $this->votes()->wherePivot('vote', 1);
    }

    // function to get all down votes
    public function downVotes(){
        return $this->votes()->wherePivot('vote', -1);
    }
}

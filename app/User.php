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
//        return route('users.show', $this->id);
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

}

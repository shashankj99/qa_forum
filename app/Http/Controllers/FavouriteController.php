<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Support\Facades\Auth;

/**
 * Class FavouriteController
 * @package App\Http\Controllers
 * @author Shashank Jha <shashankj677@gmail.com>
 */

class FavouriteController extends Controller
{
    // constructor
    public function __construct(){
        $this->middleware('auth');
    }

    // function to make the question favourite
    public function store(Question $question) {
        // store the user id and question id to the favourites pivot table
        $question->favourites()->attach(Auth::id());

        return back();
    }

    // function to mark the question as unfavourite
    public function destroy(Question $question){
        // remove the user_id and question id from the favourites pivot table
        $question->favourites()->detach(Auth::id());

        return back();
    }
}

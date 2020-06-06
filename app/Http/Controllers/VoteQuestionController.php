<?php

namespace App\Http\Controllers;

use App\Question;

/**
 * Class VoteQuestionController
 * @package App\Http\Controllers
 * @author Shashank Jha <shashankj677@gmail.com>
 */

class VoteQuestionController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function __invoke(Question $question){
        // get the vote
        $vote = (int) request()->vote;

        // associate the vote with the question
        auth()->user()->voteQuestion($question, $vote);

        return back();
    }
}

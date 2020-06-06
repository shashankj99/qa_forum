<?php

namespace App\Http\Controllers;

use App\Answer;

/**
 * Class VoteAnswerController
 * @package App\Http\Controllers
 * @author Shashank Jha <shashankj677@gmail.com>
 */

class VoteAnswerController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function __invoke(Answer $answer){
        // get the vote
        $vote = (int) request()->vote;

        // associate the vote with the answer
        auth()->user()->voteAnswer($answer, $vote);

        return back();
    }
}

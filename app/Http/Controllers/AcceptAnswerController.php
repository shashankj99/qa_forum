<?php

namespace App\Http\Controllers;

use App\Answer;

/**
 * Class AcceptAnswerController
 * @package App\Http\Controllers
 * @author Shashank Jha shashankj677@gmail.com
 */

class AcceptAnswerController extends Controller
{
    public function __invoke(Answer $answer){
        // check if the user is authorized to vote the answer as best or not
        $this->authorize('accept', $answer);

        // accept the answer as best answer
        $answer->question->acceptBestAnswer($answer);

        return back();
    }
}

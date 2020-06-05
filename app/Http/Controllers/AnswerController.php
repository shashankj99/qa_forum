<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class AnswerController
 * @package App\Http\Controllers
 * @author Shashank Jha shashankj677@gmail.com
 */

class AnswerController extends Controller
{
    // function to store the answers to a particular question
    public function store(Request $request, Question $question) {
        // store answer made by the authenticated user if validation succeeds
        $question->answers()->create($request->validate([
                'body' => "required",
            ]) + ['user_id' => Auth::id()]);

        return back()->with('success', "Your answer has been submitted successfully");
    }

    // function to view the edit page with answer instance
    public function edit(Question $question, Answer $answer) {
        // check if the user is authorized to edit/update the answer or not
        $this->authorize('update', $answer);

        return view('answers._edit', compact('question', 'answer'));
    }

    // function to update an answer
    public function update(Request $request, Question $question, Answer $answer) {
        // check if the user is authorized to edit/update the answer or not
        $this->authorize('update', $answer);

        // if authorized then update the answer on validation success
        $answer->update($request->validate([
            'body' => "required"
        ]));

        return redirect()->route('questions.show', $question->slug)
            ->with('success', "Your answer was updated successfully");
    }

    // function to delete the answer
    public function destroy(Question $question, Answer $answer) {
        // check if the user is authorized to delete the answer
        $this->authorize('delete', $answer);

        // if authorized then delete
        $answer->delete();

        return redirect()->back()
            ->with('success', "Your answer was deleted successfully");
    }
}

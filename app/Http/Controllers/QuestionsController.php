<?php

namespace App\Http\Controllers;

use App\Http\Requests\AskQuestionRequest;
use App\Question;

/**
 * Class QuestionsController
 * @package App\Http\Controllers
 * @author Shashank Jha shashankj677@gmail.com
 */

class QuestionsController extends Controller
{
    // constructor for checking authentication
    public function __construct() {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    // function to direct user to the index page
    public function index()
    {
        return view('questions.index')->with('questions', Question::with('user')->latest()->paginate(10));
    }

    // function to view the create question page
    public function create()
    {
        // create the new question instance and pass it to the view page
        $question = new Question();

        return view("questions.create", compact('question'));
    }

    // function to store the question to the DB
    public function store(AskQuestionRequest $request)
    {
        // add question to the questions table with authorized user id
        $request->user()->questions()->create($request->only('title', 'body'));

        return redirect()->route('questions.index')->with('success', "Your question has been submitted");
    }

    // function to view the question and its related answers if any
    public function show(Question $question)
    {
        // increase the view count by 1 on per page visit
        $question->increment('views');

        return view('questions.show', compact('question'));
    }

    // function to load the edit question page with question instance
    public function edit(Question $question)
    {
        // check if the user is authorized to edit/update the question
        $this->authorize("update", $question);

        return view('questions.edit', compact('question'));
    }

    // function to update the question
    public function update(AskQuestionRequest $request, Question $question)
    {
        // check if the user is authorized to edit/update the question
        $this->authorize("update", $question);

        // update if authorized
        $question->update($request->only('title', 'body'));

        return redirect()->route('questions.index')->with('success', "Your questions has been updated");
    }

    // function to delete the question
    public function destroy(Question $question)
    {
        // check if the user is authorized to delete
        $this->authorize("delete", $question);

        // delete it authorized
        $question->delete();

        return redirect()->route('questions.index')->with('success', "Your questions has been deleted");
    }
}

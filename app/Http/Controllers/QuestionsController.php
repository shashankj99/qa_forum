<?php

namespace App\Http\Controllers;

use App\Http\Requests\AskQuestionRequest;
use App\Question;

/**
 * Class QuestionsController
 *
 * @package App\Http\Controllers
 * @author Shashank Jha shashankj677@gmail.com
 */

class QuestionsController extends Controller
{
    public function __construct() {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function index()
    {
        return view('questions.index')->with('questions', Question::with('user')->latest()->paginate(10));
    }

    public function create()
    {
        $question = new Question();
        return view("questions.create", compact('question'));
    }

    public function store(AskQuestionRequest $request)
    {
        $request->user()->questions()->create($request->only('title', 'body'));
        return redirect()->route('questions.index')->with('success', "Your question has been submitted");
    }

    public function show(Question $question)
    {
        $question->increment('views');
        return view('questions.show', compact('question'));
    }

    public function edit(Question $question)
    {
        $this->authorize("update", $question);
        return view('questions.edit', compact('question'));
    }

    public function update(AskQuestionRequest $request, Question $question)
    {
        $this->authorize("update", $question);
        $question->update($request->only('title', 'body'));
        return redirect()->route('questions.index')->with('success', "Your questions has been updated");
    }

    public function destroy(Question $question)
    {
        $this->authorize("delete", $question);
        $question->delete();
        return redirect()->route('questions.index')->with('success', "Your questions has been deleted");
    }
}

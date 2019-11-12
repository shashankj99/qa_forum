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
    public function index()
    {
        return view('questions.index')->with('questions', Question::with('user')->latest()->paginate(5));
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
        //
    }

    public function edit(Question $question)
    {
        return view('questions.edit', compact('question'));
    }

    public function update(AskQuestionRequest $request, Question $question)
    {
        $question->update($request->only('title', 'body'));
        return redirect()->route('questions.index')->with('success', "Your questions has been updated");
    }

    public function destroy(Question $question)
    {
        $question->delete();
        return redirect()->route('questions.index')->with('success', "Your questions has been deleted");
    }
}

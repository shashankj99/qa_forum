<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;

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
        return view('questions.index')->with('questions', Question::latest()->paginate(5));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Question $question)
    {
        //
    }

    public function edit(Question $question)
    {
        //
    }

    public function update(Request $request, Question $question)
    {
        //
    }

    public function destroy(Question $question)
    {
        //
    }
}

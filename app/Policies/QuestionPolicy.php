<?php

namespace App\Policies;

use App\User;
use App\Question;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class QuestionPolicy
 * @package App\Policies
 * @author Shashank Jha shasahnk.j677@gmail.com
 */

class QuestionPolicy
{
    use HandlesAuthorization;

    // policy to check edit/update feature
    public function update(User $user, Question $question)
    {
        return $user->id === $question->user_id;
    }

    // policy to check delete feature
    public function delete(User $user, Question $question)
    {
        return $user->id === $question->user_id && $question->answers_count < 1;
    }

}

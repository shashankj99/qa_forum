<?php

namespace App\Policies;

use App\User;
use App\Answer;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class AnswerPolicy
 * @package App\Policies
 * @author Shashank Jha shashankj677@gmail.com
 */

class AnswerPolicy
{
    use HandlesAuthorization;

    // policy to check edit/update feature
    public function update(User $user, Answer $answer) {
        return $user->id === $answer->user_id;
    }

    // policy to check answer accept feature
    public function accept(User $user, Answer $answer){
        return $user->id === $answer->question->user_id;
    }

    // policy to check delete feature
    public function delete(User $user, Answer $answer)
    {
        return $user->id === $answer->user_id;
    }

}

<?php

namespace App\Policies;

use App\Models\Question;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuestionPolicy
{
    use HandlesAuthorization;


    public function update(User $user, Question $question)
    {
        return $user->id === $question->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Question $question)
    {
        return $user->id === $question->user_id && $question->answers_count < 1;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Question $question)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Question $question)
    {
        //
    }
}

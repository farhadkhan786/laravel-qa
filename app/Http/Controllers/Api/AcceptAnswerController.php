<?php

namespace App\Http\Controllers\Api;

use App\Models\Answer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AcceptAnswerController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Answer $answer)
    {
        $this->authorize('accept', $answer);

        $answer->question->acceptBestAnswer($answer);

            return response()->json([
                'message' => "You have accepted this answer as best answer"
            ]);
        }
    }

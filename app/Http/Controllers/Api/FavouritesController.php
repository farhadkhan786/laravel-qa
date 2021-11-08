<?php

namespace App\Http\Controllers\Api;

use App\Models\Question;
use App\Http\Controllers\Controller;
use http\Env\Response;
use Illuminate\Http\Request;

class FavouritesController extends Controller {

    public function store(Question $question) {
        $question->favourites()->attach(auth()->id());
        return response()->json(null, 204);
    }

    public function destroy(Question $question) {
        $question->favourites()->detach(auth()->id());
    return response()->json(null, 204);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Question;
use http\Env\Response;
use Illuminate\Http\Request;

class FavouritesController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function store(Question $question) {
        $question->favourites()->attach(auth()->id());
        if (\request()->expectsJson()) {
            return \response()->json(null, 204);
        }
        return back();
    }

    public function destroy(Question $question) {
        $question->favourites()->detach(auth()->id());
        if (\request()->expectsJson()) {
            return \response()->json(null, 204);
        }
        return back();
    }
}

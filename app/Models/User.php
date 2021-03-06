<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
//use Illuminate\Support\Str;
//use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Laravel\Sanctum\HasApiTokens;
//use phpDocumentor\Reflection\Type;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, /*HasFactory,*/ Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $appends = ['url', 'avatar'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function questions () {
        return $this->hasMany(Question::class);
    }

    public function getUrlAttribute () {
//        return route("questions.show", $this->id);
        return '#';
    }

    public function answers () {
        return $this->hasMany(Answer::class);
    }

    public function getAvatarAttribute () {
        $email = $this->email;
        $size = 32;
        return "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?s=" . $size;
    }

    public function favourites () {
        return $this->belongsToMany(Question::class, 'favourites')->withTimeStamps();
    }

    public function voteQuestions () {
        return $this->morphedByMany(Question::class, 'votable');
    }

    public function voteAnswers () {
        return $this->morphedByMany(Answer::class, 'votable');
    }

    public function voteQuestion (Question $question, $vote) {
        $voteQuestions = $this->voteQuestions();

        return $this->_vote($voteQuestions, $question, $vote);
    }

    public function voteAnswer (Answer $answer, $vote) {
        $voteAnswers = $this->voteAnswers();

        return $this->_vote($voteAnswers, $answer, $vote);
    }

    private function _vote($relationship, $model, $vote) {
        if ($relationship->where('votable_id', $model->id)->exists()) {
            $relationship->updateExistingPivot($model, ['vote' => $vote]);
        }
        else {
            $relationship->attach($model, ['vote'=>$vote]);
        }

        $model->load('votes');
        $downVotes = (int) $model->downVotes()->sum('vote');
        $upVotes = (int) $model->upVotes()->sum('vote');

        $model->votes_count = $upVotes + $downVotes;
        $model->save();

        return $model->votes_count;
    }
}

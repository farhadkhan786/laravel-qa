<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Question extends Model
{
    use VotableTrait;
    use HasFactory;

    protected $fillable = ['title', 'body'];

    protected $appends = ['created_date', 'is_favourated', 'favourates_count', 'body_html'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function setTitleAttribute ($value) {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function getUrlAttribute () {
        return route("questions.show", $this->slug);
    }

    public function getCreatedDateAttribute () {
        return $this->created_at->diffForHumans();
    }

    public function getStatusAttribute () {
        if ( $this->answers_count > 0) {
            if ($this->best_answer_id) {
                return "answered_accepted";
            }
            return "answered";
        }
        return "unanswered";
    }

    public function getBodyHtmlAttribute () {
        return clean($this->bodyHtml());
    }

    public function answers () {
        return $this->hasMany(Answer::class)->orderBy('votes_count', 'DESC');;
    }

    public function acceptBestAnswer (Answer $answer) {
        $this->best_answer_id = $answer->id;
        $this->save();
    }

    public function favourites () {
        return $this->belongsToMany(User::class, 'favourites')->withTimeStamps();
    }

    public function isFavourited () {
        return $this->favourites()->where('user_id', auth()->id())->count() > 0;
    }

    public function getIsFavouratedAttribute () {
        return $this->isFavourited();
    }

    public function getFavouratesCountAttribute () {
        return $this->favourites->count();
    }

    public function getExcerptAttribute () {
        return $this->excerpt(250);
    }

    public function excerpt ($length) {
        return \Illuminate\Support\Str::limit(strip_tags($this->bodyHtml()), $length);
    }

    private function bodyHtml () {
        return \Parsedown::instance()->text($this->body);
    }
}

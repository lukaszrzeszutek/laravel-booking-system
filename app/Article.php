<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class Article extends Model
{
  protected $guarded = [];
  public $timestamps = false;

    use Enjoythetrip\Presenters\ArticlePresenter;

    public function user(){
      return $this->belongsTo('App\User');
    }

    public function users(){
      return $this->morphToMany('App\User','likeable');
    }

    public function comments(){
      return $this->morphMany('App\Comment','commentable');
    }

    public function object(){
      return $this->belongsTo('App\Obiekt','obiekt_id');
    }

    public function isLiked(){
      return $this->users()->where('user_id',Auth::user()->id)->exists();
    }
}

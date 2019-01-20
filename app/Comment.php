<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
  use Enjoythetrip\Presenters\CommentPresenter;

  public $timestamps = false;

  public function commentable(){
    return $this->morphTo();
  }

  public function user(){
    return $this->belongsTo('App\User');
  }

  public function photos(){
    return $this->morphMany('App\Photo','photoable');
  }
}

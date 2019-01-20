<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Obiekt extends Model
{
  public $timestamps = false;

  use Enjoythetrip\Presenters\ObjectPresenter;
    public function scopeOrdered($query){
    return $query->orderBy('name','asc');
    }

    public function city(){
      return $this->belongsTo('App\City');
    }

    public function photos(){
      return $this->morphMany('App\Photo','photoable');
    }

    public function comments(){
      return $this->morphMany('App\Comment','commentable');
    }

    public function users(){
      return $this->morphToMany('App\User','likeable');
    }

    public function user(){
      return $this->belongsTo('App\User');
    }

    public function addresses(){
      return $this->hasOne('App\Address');
    }

    public function rooms(){
      return $this->hasMany('App\Room');
    }

    public function articles(){
      return $this->hasMany('App\Article');
    }

    public function isLiked(){
      return $this->users()->where('user_id',Auth::user()->id)->exists();
    }

}

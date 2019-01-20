<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
public $timestamps = false;

  public function photos(){
    return $this->morphMany('App\Photo','photoable');
  }

  public function object(){
    return $this->belongsTo('App\Obiekt','obiekt_id');
  }

  public function reservations(){
    return $this->hasMany('App\Reservation');
  }
}

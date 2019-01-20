<?php

namespace App\Enjoythetrip\Presenters;

trait CommentPresenter {

  public function getRatingAttribute($value){

    $str = '';

    for($i=1;$i<=5;$i++){
      $negr = '';
      if($value == 1 && $i > 1)
      $negr = 'negative-rating';
      elseif($value == 2 && $i > 2)
      $negr = 'negative-rating';
      elseif($value == 3 && $i > 3)
      $negr = 'negative-rating';
      elseif($value == 4 && $i > 4)
      $negr = 'negative-rating';

      $str .= '<span class="glyphicon glyphicon-star '.$negr.'" aria-hidden="true"></span>';
    }

    return $str;
  }

}

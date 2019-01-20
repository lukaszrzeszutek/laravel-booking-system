<?php

namespace App\Enjoythetrip\Presenters;

trait ObjectPresenter {

  public function getLinkAttribute(){

    return route('object',['id'=>$this->id]);
  }

  public function getTypeAttribute(){

    return 'Obiekt: '.$this->name;
  }

}

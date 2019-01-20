<?php

namespace App\Enjoythetrip\Presenters;

trait ArticlePresenter {

  public function getLinkAttribute(){

    return route('article',['id'=>$this->id]);
  }

  public function getTypeAttribute(){

    return 'Artykuł: '.$this->title;
  }

}

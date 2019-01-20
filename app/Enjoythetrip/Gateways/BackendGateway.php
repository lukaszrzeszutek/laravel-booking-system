<?php

namespace App\Enjoythetrip\Gateways;

use App\Enjoythetrip\Interfaces\BackendRepositoryInterface;

class BackendGateway {

  use \Illuminate\Foundation\Validation\ValidatesRequests;

  public function __construct(BackendRepositoryInterface $bR){
    $this->bR = $bR;
  }

  public function getReservations($request)
  {
    if($request->user()->hasRole(['owner','admin']))
    {
        $objects = $this->bR->getOwnerReservations($request);
    }
    else
    {
      $objects = $this->bR->getTouristReservations($request);
    }

    return $objects;

  }

  public function createCity($request){
    $this->validate($request, [
      'name' => 'required|string|unique:cities'
    ]);

    $this->bR->createCity($request);

  }

  public function updateCity($request, $id){
    $this->validate($request, [
      'name' => 'required|string|unique:cities'
    ]);

    $this->bR->updateCity($request, $id);

  }

  public function saveUser($request){
    $this->validate($request, [
      'name' => 'required|string',
      'surname' => 'required|string',
      'email' => 'required|email',
    ]);

    if($request->hasFile('userPicture'))
    {
      $this->validate($request, [
        'userPicture' => 'image|max:100',
      ]);
    }
    return $this->bR->saveUser($request);
  }

  public function saveObject($id, $request){
    $this->validate($request, [
      'city' => 'required|string',
      'name' => 'required|string',
      'street' => 'required|string',
      'number' => 'required|integer',
      'description' => 'required|string|min:100',

    ]);

    if($id)
    {
      $object = $this->bR->updateObjectWithAddress($id,$request);
    }
    else
    {
      $object = $this->bR->createObjectWithAddress($request);
    }

    if($request->hasFile('objectPictures'))
    {
      $this->validate($request, \App\Photo::imageRules($request,'objectPictures'));

      foreach($request->file('objectPictures') as $picture){
        $path = $picture->store('objects','public');

        $this->bR->saveObjectPhotos($object,$path);
      }
    }

    return $object;

  }

  public function saveArticle($obiekt_id, $request){
    $this->validate($request, [
      'content' => 'required|min:10',
      'title' => 'required|min:3',

    ]);

    return $this->bR->saveArticle($obiekt_id, $request);
  }

  public function saveRoom($id,$request)
  {
  $this->validate($request, [
    'room_number' => 'required|integer',
    'room_size' => 'required|integer',
    'price' => 'required|integer',
    'description' => 'required|string|min:100',
  ]);

  if($id){
    $room = $this->bR->updateRoom($id,$request);
  } else {
    $room = $this->bR->createRoom($request);
  }

  if($request->hasFile('roomPictures'))
  {
    $this->validate($request, \App\Photo::imageRules($request,'roomPictures'));

    foreach($request->file('roomPictures') as $picture){
      $path = $picture->store('rooms','public');

      $this->bR->saveRoomPhotos($room,$path);
    }
  }
  return $room;
}

public function checkNotificationsStatus($request){
  set_time_limit(0);

  $memcached = new \Memcached();
  $memcached->addServer('localhost',11211) or die('Could not connect');

  $currentmodif = (int) $memcached->get('userid_' . $request->user()->id . '_notification_timestamp');

  $lastmodif = $request->input('timestamp') ?? 0;

  $start = microtime(true);
  $response = [];
  while($currentmodif<=$lastmodif){
    if((microtime(true) - $start) > 10){
      return json_encode($response);
}

    sleep(0.1);

    $currentmodif = (int) $memcached->get('userid_' . $request->user()->id . '_notification_timestamp');
  }
  return $currentmodif;
}

}

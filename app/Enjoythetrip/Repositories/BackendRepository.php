<?php

namespace App\Enjoythetrip\Repositories;
use App\Enjoythetrip\Interfaces\BackendRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use App\{Obiekt,Reservation,City,User,Photo,Address,Article,Room,Notification};

class BackendRepository implements BackendRepositoryInterface {

  public function getOwnerReservations($request){
    return Obiekt::with([

      'rooms' => function($q){
        $q->has('reservations');
      },
      'rooms.reservations.user',

    ])
            ->has('rooms.reservations')
            ->where('user_id',$request->user()->id)
            ->get();
  }

  public function getTouristReservations($request){
    return Obiekt::with([

        'rooms.reservations' => function($q) use($request){
          $q->where('user_id',$request->user()->id);
        },

        'rooms' => function($q) use($request){
          $q->whereHas('reservations',function($query) use($request){
            $query->where('user_id',$request->user()->id);
          });
        },
        'rooms.reservations.user'

    ])
            ->whereHas('rooms.reservations', function($q) use($request){
              $q->where('user_id',$request->user()->id);
            })
            ->get();
  }

  public function getReservationData($request){
    return Reservation::with('user','room')

              ->where('room_id',$request->input('room_id'))
              ->where('day_in', '<=' ,$request->input('date'))
              ->where('day_out', '>=' ,$request->input('date'))
              ->first();
  }

  public function getReservation($id){
    return Reservation::find($id);
  }

  public function deleteReservation(Reservation $reservation){
    return $reservation->delete();
  }

  public function confirmReservation(Reservation $reservation){
    return $reservation->update(['status'=>true]);
  }

  public function getCities(){
    return City::orderBy('name','asc')->get();
  }

  public function getCity($id){
    return City::find($id);
  }

  public function createCity($request){
    return City::create([
      'name'=>$request->input('name')
    ]);
  }

  public function updateCity($request, $id){
    return City::where('id',$id)->update([
      'name'=>$request->input('name')
    ]);
  }

  public function deleteCity($id){
    return City::where('id',$id)->delete();
  }

  public function saveUser($request){
    $user = User::find($request->user()->id);

    $user->name = $request->input('name');
    $user->surname = $request->input('surname');
    $user->email = $request->input('email');
    $user->save();

    return $user;
  }

  public function getPhoto($id){
    return Photo::find($id);
  }

  public function updateUserPhoto($user, $photo){
    return $user->photos()->save($photo);
  }

  public function createUserPhoto($user, $path){
    $photo = new Photo;
    $photo->path = $path;
    return $user->photos()->save($photo);
  }

  public function deletePhoto(Photo $photo){
    $path = $photo->storagepath;
    $photo->delete();
    return $path;
  }

  public function getObject($id){
  return Obiekt::find($id);
  }

  public function updateObjectWithAddress($id, $request){
  Address::where('obiekt_id',$id)->update([
    'street'=>$request->input('street'),
    'number'=>$request->input('number'),
  ]);

  $object = Obiekt::find($id);
  $object->name = $request->input('name');
  $object->city_id = $request->input('city');
  $object->description = $request->input('description');

  $object->save();
  return $object;

  }

  public function createObjectWithAddress($request){
  $object = new Obiekt;

  $object->user_id = $request->user()->id;
  $object->name = $request->input('name');
  $object->city_id = $request->input('city');
  $object->description = $request->input('description');

  $object->save();

  $address = new Address;
  $address->street = $request->input('street');
  $address->number = $request->input('number');
  $address->obiekt_id = $object->id;

  $address->save();
  $object->addresses()->save($address);

  return $object;
  }

  public function saveObjectPhotos(Obiekt $object, string $path){
    $photo = new Photo;
    $photo->path = $path;
    return $object->photos()->save($photo);
  }

  public function saveArticle($obiekt_id,$request){
    return Article::create([
      'title'=> $request->input('title'),
      'content'=> $request->input('content'),
      'user_id'=> $request->user()->id,
      'obiekt_id'=> $obiekt_id,
      'created_at'=> new \DateTime()
    ]);
  }

  public function getArticle($id){
    return Article::find($id);
  }

    public function deleteArticle(Article $article){
      return $article->delete();
    }

    public function getMyObjects($request){
      return Obiekt::where('user_id',$request->user()->id)->get();
    }

    public function deleteObject($id){
      return Obiekt::where('id',$id)->delete();
    }

    public function getRoom($id){
      return Room::find($id);
    }

    public function updateRoom($id,$request){
      $room = Room::find($id);
      $room->room_number = $request->input('room_number');
      $room->room_size = $request->input('room_size');
      $room->price = $request->input('price');
      $room->description = $request->input('description');

      $room->save();

      return $room;

    }

    public function createRoom($request){
      $room = new Room();
      $object = Obiekt::find($request->input('object_id'));
      $room->obiekt_id = $request->input('object_id');

      $room->room_number = $request->input('room_number');
      $room->room_size = $request->input('room_size');
      $room->price = $request->input('price');
      $room->description = $request->input('description');

      $room->save();

      $object->rooms()->save($room);

      return $room;

    }

    public function saveRoomPhotos(Room $room, string $path){
      $photo = new Photo;
      $photo->path = $path;
      return $room->photos()->save($photo);
    }

    public function deleteRoom(Room $room){
      return $room->delete();
    }

    public function setReadNotification($request){
      return Notification::where('id',$request->input('id'))->update(['status'=>1]);
    }

    public function getUserNotifications($id){
      return Notification::where('user_id',$id)->where('shown',0)->get();
    }

    public function SetShownNotifications($request){
      return Notification::whereIn('id',$request->input('idsOfNotShownNotifications'))->update(['shown'=>1]);
    }

    //for json mobile
    public function getNotifications(){
      return Notification::where('user_id',Auth::user()->id)->where('status',0)->get();
    }

}

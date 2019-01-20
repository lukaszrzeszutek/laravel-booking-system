<?php

namespace App\Enjoythetrip\Gateways;

use App\Enjoythetrip\Interfaces\FrontendRepositoryInterface;

class FrontendGateway {
  use \Illuminate\Foundation\Validation\ValidatesRequests;

  public function __construct(FrontendRepositoryInterface $fR){
    $this->fR = $fR;
  }

  public function searchCities($request){
    $term = $request->input('term');

    $result = [];

    $queries = $this->fR->getSearchCities($term);

    foreach($queries as $query){
      $result[] = ['id'=>$query->id,'value'=>$query->name];
    }

    return $result;
  }

  public function getSearchResults($request){
    $request->flash();
    if($request->input('city')!=null){
      $result = $this->fR->getSearchResults($request->input('city'));
      if($result){

        //start
        foreach($result->rooms as $k=>$room)
        {
          // Liczba pokoi
          if($request->input('room_size') > 0)
          {
            if($request->input('room_size') != $room->room_size)
            {
              $result->rooms->forget($k);
            }
          }

          // Rezerwacje
          foreach($room->reservations as $reservation)
          {
            if($request->input('day_in') >= $reservation->day_in && $request->input('day_in') <= $reservation->day_out){
              $result->rooms->forget($k);
            }
            elseif($request->input('day_out') >= $reservation->day_in && $request->input('day_out') <= $reservation->day_out){
              $result->rooms->forget($k);
            }
            elseif($request->input('day_in') <= $reservation->day_in && $request->input('day_out') >= $reservation->day_out){
              $result->rooms->forget($k);
            }
          }
        }
        //end
        if( count($result->rooms) > 0)
        return $result;
        else
        return false;
      }
    }
    return false;
  }

  public function addComment($commentable_id, $type, $request){
    $this->validate($request, [
      'content' => "required|string",
    ]);

    return $this->fR->addComment($commentable_id, $type, $request);
  }

  public function checkAvaiableReservations($room_id, $request){
    $reservations = $this->fR->getReservationsByRoomId($room_id);

    $avaiable = true;

    foreach($reservations as $reservation){
      if( $request->input('dayin') >= $reservation->day_in && $request->input('dayin') <= $reservation->day_out){
        $avaiable = false;break;
      }
      elseif( $request->input('dayout') >= $reservation->day_in && $request->input('dayout') <= $reservation->day_out){
        $avaiable = false;break;
      }
      elseif( $request->input('dayin') <= $reservation->day_in && $request->input('dayout') >= $reservation->day_out){
        $avaiable = false;break;
      }
    }

    return $avaiable;
  }

  public function makeReservation($room_id, $city_id, $request){
    $this->validate($request, [
      'dayin' => "required|string",
      'dayout' => "required|string"
    ]);

    return $this->fR->makeReservation($room_id, $city_id, $request);

  }


}

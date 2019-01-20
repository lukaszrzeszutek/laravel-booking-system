<?php

namespace App\Enjoythetrip\Traits;
use Illuminate\Http\Request;

trait Ajax  {

  public function ajaxGetReservationData(Request $request){

    $reservation = $this->bR->getReservationData($request);

    return response()->json([
      'room_number' => $reservation->room->room_number,
      'day_in' => $reservation->day_in,
      'day_out' => $reservation->day_out,
      'FullName' => $reservation->user->FullName,
      'userLink' => route('person',['id'=>$reservation->user->id]),
      'confirmResLink' => route('confirmReservation',['id'=>$reservation->id]),
      'deleteResLink' => route('deleteReservation',['id'=>$reservation->id]),
      'status' => $reservation->status,

    ]);
  }

  public function ajaxSetReadNotification(Request $request)
  {
    return $this->bR->setReadNotification($request);
  }

  public function ajaxGetNotShownNotifications(Request $request)
  {
    $currentmodif = $this->bG->checkNotificationsStatus($request);

    $response['timestamp'] = $currentmodif;
    $response['notifications'] = $this->bR->getUserNotifications($request->user()->id);

    return json_encode($response);
  }

  public function ajaxSetShownNotifications(Request $request){
    return $this->bR->SetShownNotifications($request);
  }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enjoythetrip\Interfaces\BackendRepositoryInterface;
use App\Enjoythetrip\Gateways\BackendGateway;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Events\ReservationConfirmedEvent;
use Illuminate\Support\Facades\Cache;

class BackendController extends Controller
{
  use \App\Enjoythetrip\Traits\Ajax;

  public function __construct(BackendRepositoryInterface $bR, BackendGateway $bG){
    $this->middleware('CheckOwner')->only(['myobjects','confirmReservation','saveobject','saveroom']);

    $this->bR = $bR;
    $this->bG = $bG;

  }

  public function index(Request $request){

    $objects = $this->bG->getReservations($request);

    return view('backend.index',['objects'=>$objects]);
  }

  public function myobjects(Request $request){
    $objects = $this->bR->getMyObjects($request);

    return view('backend.myobjects',compact('objects'));
  }

  public function profile(Request $request){
    if($request->isMethod('post'))
    {
      $user = $this->bG->saveUser($request);

      if($request->hasFile('userPicture'))
      {
        $path = $request->file('userPicture')->store('users','public');

        if(count($user->photos)!=0)
        {
          $photo = $this->bR->getPhoto($user->photos->first()->id);

          Storage::disk('public')->delete($photo->storagepath);

          $photo->path = $path;

          $this->bR->updateUserPhoto($user,$photo);
        }
        else
        {
          $this->bR->createUserPhoto($user,$path);
        }
      }
        Cache::flush();

      return redirect()->back();
    }

    return view('backend.profile',['user'=>Auth::user()]);
  }

  public function deletePhoto($id){
    $photo = $this->bR->getPhoto($id);

    $this->authorize('checkOwner',$photo);

    $path = $this->bR->deletePhoto($photo);

    Storage::disk('public')->delete($path);

    Cache::flush();

    return redirect()->back();

    return $id;
  }

  public function saveobject($id = null,Request $request){
    if($request->isMethod('post'))
    {
        if($id)
          $this->authorize('checkOwner',$this->bR->getObject($id));

          $this->bG->saveObject($id,$request);

          Cache::flush();

          if($id)
          return redirect()->back();
          else
          return redirect()->route('myObjects');
    }

    if($id)
    {
      return view('backend.saveobject',['object'=>$this->bR->getObject($id), 'cities'=>$this->bR->getCities()]);
    }
    else
    return view('backend.saveobject', ['cities'=>$this->bR->getCities()]);
  }

  public function saveroom($id = null, Request $request){

    if($request->isMethod('post'))
    {
        if($id)
          $this->authorize('checkOwner',$this->bR->getRoom($id));
        else
        $this->authorize('checkOwner',$this->bR->getObject($request->input('object_id')));

        $this->bG->saveRoom($id,$request);

        Cache::flush();
        if($id)
        return redirect()->back();
        else
        return redirect()->route('myObjects');
    }

    if($id)
    return view('backend.saveroom',['room'=>$this->bR->getRoom($id)]);
    else
    return view('backend.saveroom',['obiekt_id'=>$request->input('object_id')]);
  }

  public function deleteroom($id){
    $room = $this->bR->getRoom($id);

    $this->authorize('checkOwner',$room);

    $this->bR->deleteRoom($room);

    Cache::flush();
    return redirect()->back();

  }

  public function confirmReservation($id){
    $reservation = $this->bR->getReservation($id);

    $this->authorize('reservation',$reservation);

    $this->bR->confirmReservation($reservation);

    $this->flashMsg('success', __('Reservation has been confirmed'));

    event(new ReservationConfirmedEvent($reservation));

    if(!\Request::ajax())
    return redirect()->back();
  }

  public function deleteReservation($id){
    $reservation = $this->bR->getReservation($id);

    $this->authorize('reservation',$reservation);

    $this->bR->deleteReservation($reservation);

    $this->flashMsg('success', __('Reservation has been deleted'));

    if(!\Request::ajax())
    return redirect()->back();
  }

  public function deleteArticle($id){
    $article = $this->bR->getArticle($id);

    $this->authorize('checkOwner',$article);

    $this->bR->deleteArticle($article);

    Cache::flush();

    return redirect()->back();
  }

  public function saveArticle($obiekt_id = null, Request $request){
    if(!$obiekt_id)
    {
      $this->flashMsg('danger','Najpierw dodaj obiekt, aby dodać artykuł');
      return redirect()->back();
    }

    $this->authorize('checkOwner',$this->bR->getObject($obiekt_id));

    $this->bG->saveArticle($obiekt_id,$request);

    Cache::flush();

    return redirect()->back();
  }

  public function deleteObject($id){
    $this->authorize('checkOwner',$this->bR->getObject($id));
    $this->bR->deleteObject($id);

    Cache::flush();
    return redirect()->back();

  }
  // for json mobile
  public function getNotifications(){

    return response()->json( $this->bR->getNotifications() );
  }
//for json mobile
  public function setReadNotifications(Request $request){
    return $this->bR->setReadNotification($request);
  }

}

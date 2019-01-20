<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enjoythetrip\Interfaces\FrontendRepositoryInterface;
use App\Enjoythetrip\Gateways\FrontendGateway;
use App\Events\OrderPlacedEvent;
use Illuminate\Support\Facades\Cache;

class FrontendController extends Controller
{
  public function __construct(FrontendRepositoryInterface $fR, FrontendGateway $fG){

    $this->middleware('auth')->only(['like'.'unlike','addComment','makeReservation']);

    $this->fR = $fR;
    $this->fG = $fG;

  }

    public function index(){
      $objects = $this->fR->getObjectsForMainPage();
      // dd($objects);
      return view('frontend.index',['objects'=>$objects]);
    }

    public function article($id){
      $article = $this->fR->getArticle($id);
      return view('frontend.article',['article'=>$article]);
    }

    public function object($id){
      $object = $this->fR->getObject($id);
      // dd($object);

      return view('frontend.object',['object'=>$object]);
    }

    public function person($id){
      $user = $this->fR->getPerson($id);
      return view('frontend.person',['user'=>$user]);
    }

    public function room($id){
      $room = $this->fR->getRoom($id);
      return view('frontend.room',['room'=>$room]);
    }

    public function ajaxGetRoomReservations($id){
      $reservations = $this->fR->getReservationsByRoomId($id);

      return response()->json([
        'reservations' => $reservations
      ]);
    }

    public function roomsearch(Request $request){

      if($city = $this->fG->getSearchResults($request)){
        // dd($city);
        return view('frontend.roomsearch',['city'=>$city]);

      }else{
        if(!$request->ajax())
        return redirect('/')->with('norooms','No offers were found matching the criteria');
      }

    }

    public function searchCities(Request $request){

      $results = $this->fG->searchCities($request);

      return response()->json($results);
    }

    public function like($likeable_id, $type, Request $request){
        $this->fR->like($likeable_id, $type, $request);

        Cache::flush();

        return redirect()->back();
    }

    public function unlike($likeable_id, $type, Request $request){
        $this->fR->unlike($likeable_id, $type, $request);

        Cache::flush();

        return redirect()->back();
    }

    public function addComment($commentable_id, $type, Request $request){

        $this->fG->addComment($commentable_id, $type, $request);

        Cache::flush();

          return redirect()->back();
    }

    public function makeReservation($room_id, $city_id, Request $request){
      $avaiable = $this->fG->checkAvaiableReservations($room_id, $request);

      if(!$avaiable){

          if(!$request->ajax()){
            $request->session()->flash('reservationMsg', 'Brak wolnych miejsc');
            return redirect()->route('room',['id'=>$room_id,'#reservation']);
          }

        return response()->json(['reservation'=>false]);

      }else{
        $reservation = $this->fG->makeReservation($room_id, $city_id, $request);

        event(new OrderPlacedEvent($reservation));

        if(!$request->ajax())
        return redirect()->route('adminHome');
        else
        return response()->json(['reservation'=>$reservation]);
      }
    }
}

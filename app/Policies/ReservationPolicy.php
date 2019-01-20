<?php

namespace App\Policies;

use App\{User,Reservation};
use Illuminate\Auth\Access\HandlesAuthorization;

class ReservationPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function reservation(User $user, Reservation $reservation){
      if( $user->hasRole(['owner','admin']) )
      return $user->id === $reservation->room->object->user->id;
      else
      return $user->id === $reservation->user_id;
    }
}

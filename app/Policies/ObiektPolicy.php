<?php

namespace App\Policies;

use App\{User,Obiekt};
use Illuminate\Auth\Access\HandlesAuthorization;

class ObiektPolicy
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

    public function checkOwner(User $user, Obiekt $object){
      return $user->id === $object->user_id;
    }
}

<?php

namespace App\Policies;

use App\{User, Photo};
use Illuminate\Auth\Access\HandlesAuthorization;

class PhotoPolicy
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

    public function checkOwner(User $user, Photo $photo){


      if($photo->photoable_type == 'App\User')

      return $user->id === $photo->photoable_id;

      elseif($photo->photoable_type == 'App\Obiekt')

      return $user->id === $photo->photoable->user_id;

      elseif($photo->photoable_type == 'App\Room')

      return $user->id === $photo->photoable->object->user_id;
    }
}

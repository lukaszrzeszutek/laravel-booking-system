<?php

namespace App\Listeners;

use App\Events\ReservationConfirmedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notification;

class ReservationConfirmedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ReservationConfirmedEvent  $event
     * @return void
     */
    public function handle(ReservationConfirmedEvent $event)
    {
      Notification::create([
        'user_id' => $id = $event->reservation->user_id,
        'content' => __('Rezerwacja została potwierdzona dla pokoju :number w obiekcie :object. Data przyjazdu :dayin, data wyjazdu :dayout',[
          'number' => $event->reservation->room->room_number,
          'object' => $event->reservation->room->object->name,
          'dayin' => $event->reservation->day_in,
          'dayout' => $event->reservation->day_out,

        ]),
        'status' => 0
      ]);

      $memcached = new \Memcached();
      $memcached->addServer('localhost',11211) or die('Could not connect');

      $memcached->set('userid_' . $id. '_notification_timestamp',time());

    }
}

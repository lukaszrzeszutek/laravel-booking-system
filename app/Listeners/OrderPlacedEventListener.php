<?php

namespace App\Listeners;

use App\Events\OrderPlacedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notification;

class OrderPlacedEventListener
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
     * @param  OrderPlacedEvent  $event
     * @return void
     */
    public function handle(OrderPlacedEvent $event)
    {
      Notification::create([
        'user_id' => $id = $event->reservation->room->object->user_id,
        'content' => __('Rezerwacja została wykonana dla pokoju :number w :object obiekcie. Data przyjazdu :dayin , data wyjazdu :dayout',[
          'number' => $event->reservation->room->room_number,
          'object' => $event->reservation->room->object->name,
          'dayin' => $event->reservation->room->day_in,
          'dayout' => $event->reservation->room->day_out,

        ]),
        'status' => 0,
      ]);

      $memcached = new \Memcached();
      $memcached->addServer('localhost',11211) or die('Could not connect');

      $memcached->set('userid_' . $id. '_notification_timestamp',time());


    }
}

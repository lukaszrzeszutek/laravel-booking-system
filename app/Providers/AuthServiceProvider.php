<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        'App\Reservation' => 'App\Policies\ReservationPolicy',
        'App\Photo' => 'App\Policies\PhotoPolicy',
        'App\Obiekt' => 'App\Policies\ObiektPolicy',
        'App\Article' => 'App\Policies\ArticlePolicy',
        'App\Room' => 'App\Policies\RoomPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }

}

<?php

namespace App\Providers;

use App\Events\BalanceUpdate;
use App\Events\CreateOrder;
use App\Events\LeaderBoardUpdate;
use App\Jobs\BuyOrder;
use App\Listeners\SendBalanceStatusNotification;
use App\Listeners\SendBuyOrderNotification;
use App\Listeners\SendCreateOrderNotification;
use App\Listeners\SendLeaderboardUpdateNotification;
use App\Models\Order;
use App\Observers\OrderObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Order::observe(OrderObserver::class);
    }
}

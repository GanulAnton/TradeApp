<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\User;
use App\Notifications\OrderCreatedNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function creating(Order $order)
    {
        $users = User::all();
        Notification::send($users, new OrderCreatedNotification($order, 'order'));
    }

    /**
     * Handle the Order "updated" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function updated(Order $order)
    {
        //
    }

    /**
     * Handle the Order "deleted" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function deleting(Order $order)
    {
        $diamond_quantity = rand(1,500);
        $usd_quantity  = rand(1,500);
        $new_order = new Order();
        $new_order->diamond_quantity = $diamond_quantity;
        $new_order->usd_quantity = $usd_quantity;
        $new_order->rate = $diamond_quantity/$usd_quantity;
        $new_order->life_time = Carbon::now()->add(10800,'seconds');
        $new_order->order_type = $order->order_type;
        $new_order->save();

    }

    /**
     * Handle the Order "restored" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function restored(Order $order)
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function forceDeleted(Order $order)
    {
        //
    }
}

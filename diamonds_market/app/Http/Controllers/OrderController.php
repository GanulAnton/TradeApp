<?php

namespace App\Http\Controllers;

use App\Jobs\BuyOrder;
use App\Jobs\SellOrder;
use App\Models\Order;
use App\Models\User;
use App\Notifications\OrderCreatedNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class OrderController extends Controller
{


    public function getOrders(Request $request)
    {
        $arr = [];
        $this->makeOrders($arr, 'buy');
        $this->makeOrders($arr, 'sell');
        Order::insert($arr);
        $users = User::all();
        Notification::send($users, new OrderCreatedNotification($arr, 'order'));
        return Order::where('order_type', $request->order_type)->get();

    }

    public function clearExistOrders()
    {
        Order::where('life_time' ,'<=', now())->delete();
    }


    protected function makeOrders(&$arr, $type) {
        $to_create = 10 - Order::where('order_type', $type)
            ->whereNull('user_id')
            ->where('life_time', '>', now())
            ->count();
        for($i = 0; $i < $to_create; $i++) {
            $diamond_quantity = rand(1, 500);
            $usd_quantity = rand(1, 500);
            $arr[] = [
                'diamond_quantity' => $diamond_quantity,
                'usd_quantity' => $usd_quantity,
                'life_time' => Carbon::now()->add(rand(1, 10080), 'seconds'),
                'rate' => round($diamond_quantity / $usd_quantity, 2),
                'order_type' => $type,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ];
        }

    }

    public function buyOrder(Request $request, $orderId)
    {
        $order =  Order::where('order_type',$request->order_type)->findOrFail($orderId);
        $current_user = $request->user();
        $usd_diff = $current_user->usd_balance - $order->usd_quantity;
        $diamond_diff = $current_user->diamond_balance - $order->diamond_quantity;

        if($request->order_type == 'buy' and $usd_diff >= 0){

           BuyOrder::dispatch($order,$current_user);

        }elseif ($request->order_type == 'sell' and $diamond_diff >= 0){

           SellOrder::dispatch($order, $current_user);
        }
        return $current_user;
    }
}

<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\User;
use App\Notifications\BalanceUpdateNotification;
use App\Notifications\LeaderboardChangedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class SellOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order, $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order $order, User $user)
    {
        $this->user = $user;
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $current_user = $this->user;
        $order = $this->order;
        //SELECT * FROM users;
        $users = User::all();
        //UPDATE users ('diamond_balance', 'usd_balance') SET ('$current_user->diamond_balance - $order->diamond_quantity', '$current_user->usd_balance + $order->usd_quantity');
        $this->user->update([
            'diamond_balance' => $current_user->diamond_balance - $order->diamond_quantity,
            'usd_balance' =>  $current_user->usd_balance + $order->usd_quantity,
        ]);
        //DELETE FROM order WHERE id = $order->id;
        $this->order->delete();
        $balance_data = [
            'user_id' => $current_user->id,
            'diamond_balance' => $current_user->diamond_balance,
            'usd_balance' => $current_user->usd_balance,
        ];
        $leaderboard_data = [
            'user_id' => $current_user->id,
            'diamond_balance' => $current_user->diamond_balance,
        ];
        $current_user->notify( new BalanceUpdateNotification($balance_data, 'user'));
        Notification::send($users, new LeaderboardChangedNotification($leaderboard_data, 'order'));
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Order extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'user_id',
        'diamond_quantity',
        'usd_quantity',
        'life_time',
        'rate',
        'order_type',
    ];

    public function user()
    {
      return  $this->belongsTo(User::class);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getLeaderBoard()
    {
       return  User::select('username','diamond_balance')->get()->sortByDesc('diamond_balance')->take(10);
    }
}

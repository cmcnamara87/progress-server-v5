<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProgressController extends Controller
{
    public function __construct()
    {
        // Apply the jwt.auth middleware to all methods in this controller
        // except for the authenticate method. We don't want to prevent
        // the user from retrieving their token if they don't already have it
        $this->middleware('jwt.auth');
    }

    public function store(Request $request)
    {
        $user = JWTAuth::parseToken()->toUser();

        $diffInMinutes = min(Carbon::now()->diffInMinutes($user->updated_at), 5);
        $user->time = $user->time + $diffInMinutes;
        $user->save();

        return response()->json($user);
    }
}

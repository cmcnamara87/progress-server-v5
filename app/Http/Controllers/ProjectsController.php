<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

use App\Http\Requests;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProjectsController extends Controller
{
    public function __construct()
    {
        // Apply the jwt.auth middleware to all methods in this controller
        // except for the authenticate method. We don't want to prevent
        // the user from retrieving their token if they don't already have it
        $this->middleware('jwt.auth');
    }

    public function index()
    {
        $user = JWTAuth::parseToken()->toUser();
        $projects = Project::where('user_id', $user->id)->get();
        return response()->json($projects);
    }

    public function store(Request $request) {
        $user = JWTAuth::parseToken()->toUser();

        $data = $request->only('name');
        $data['user_id'] = $user->id;
        $project = Project::create($data);
        return response()->json($project);
    }

}

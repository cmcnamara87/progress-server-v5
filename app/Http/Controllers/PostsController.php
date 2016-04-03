<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

use App\Http\Requests;
use Tymon\JWTAuth\Facades\JWTAuth;

class PostsController extends Controller
{
    public function __construct()
    {
        // Apply the jwt.auth middleware to all methods in this controller
        // except for the authenticate method. We don't want to prevent
        // the user from retrieving their token if they don't already have it
        $this->middleware('jwt.auth');
    }

    public function index() {
        $posts = Post::orderBy('created_at', 'asc')->get();
        return response()->json($posts);
    }

    public function store(Request $request) {
        $data = $request->only('text');
        $user = JWTAuth::parseToken()->toUser();
        $data['user_id'] = $user->id;
        $post = Post::create($data);
        return response()->json($post);
    }
}

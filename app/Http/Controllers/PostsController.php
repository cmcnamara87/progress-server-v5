<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;
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
        $user = JWTAuth::parseToken()->toUser();
        $posts = Post::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(20)
            ->get()
            ->reverse()
            ->values()->all();
        return response()->json($posts);
    }

    public function getPublicPosts() {
        $user = JWTAuth::parseToken()->toUser();
        $posts = Post::where('text', 'LIKE', '%#public%')->orderBy('created_at', 'desc')
            ->take(20)
            ->get()
            ->reverse()
            ->values()->all();
        return response()->json($posts);
    }

    public function store(Request $request) {

        $data = $request->only('text');
        $user = JWTAuth::parseToken()->toUser();
        $data['user_id'] = $user->id;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . "-" . snake_case($file->getClientOriginalName());
            $path = public_path('posts/' . $fileName);

            Image::make($file)
//                ->resize(400, 300)
                ->save($path);
            $data['image_url'] = asset('posts/' . $fileName);
        }
        $post = Post::create($data);
        return response()->json($post);
    }
}

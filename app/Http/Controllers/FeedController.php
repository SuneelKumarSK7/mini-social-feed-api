<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;

class FeedController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // feed: all posts with author plus counts and whether current user liked the post or not	
        $posts = Post::with('author')->orderBy('created_at','desc')->paginate(10);

        return PostResource::collection($posts);
    }
}

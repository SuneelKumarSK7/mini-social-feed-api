<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\Auth\LikeService;
use Illuminate\Http\Request;

class LikeController extends Controller
{

    protected $likeService;

    public function __construct(LikeService $likeService)
    {
        $this->likeService = $likeService;
    }

    // Like a post
     public function like(Request $request, $id)
    {
        $response = $this->likeService->likePost($request->user(), $id);

        return response()->json($response, $response['status_code']);
    }

    // Unlike a post
    public function unlike(Request $request, $id)
    {
        $response = $this->likeService->unlikePost($request->user(), $id);
        return response()->json($response, $response['status_code']);
    }
}

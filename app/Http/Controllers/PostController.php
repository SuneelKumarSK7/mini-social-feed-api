<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use App\Services\Auth\PostService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }


    // list posts in reverse chronological order
    public function index()
    {
        $response = $this->postService->index();
        return response()->json($response, $response['status_code'] ?? 200);
    }

    public function show($id)
    {
        $response = $this->postService->show($id);
        return response()->json($response, $response['status_code'] ?? 200);
    }

    public function store(PostRequest $request)
    {
        $response = $this->postService->createPost($request->all(), $request->user());
        return response()->json($response, $response['status_code']);

    }

    public function destroy(Request $request, $id)
    {
        $response = $this->postService->deletePost($request->user()->id, $id);

        return response()->json($response, $response['status_code']);
    }
}

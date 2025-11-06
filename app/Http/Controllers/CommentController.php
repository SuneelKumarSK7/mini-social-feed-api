<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Services\Auth\CommentService;

class CommentController extends Controller
{
    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }


    // View	all	comments for a post.
    public function index($postId)
    {
        $response = $this->commentService->viewComments($postId);

        return response()->json($response, $response['status_code'] ?? 200);
    }

    // Add new comments
    public function store(CommentRequest $request, $postId)
    {
        $response = $this->commentService->addComment($request->user(), $postId, $request->comment);
        return response()->json($response, $response['status_code']);
    }
}

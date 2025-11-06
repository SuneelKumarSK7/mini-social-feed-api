<?php

namespace App\Services\Auth;

use App\Models\Post;
use App\Http\Resources\CommentResource;

use function PHPUnit\Framework\returnSelf;

class CommentService
{
    // View	all	comments for a post.
    public function viewComments($postId)
    {
        $post = Post::find($postId);
        if (!$post) {
            return [
                'success' => false,
                'message' => 'Post not found',
                'status_code' => 404,
            ];
        }

        $comments = $post->comments()->with('user')->orderBy('created_at', 'asc')->get();
        if ($comments->isEmpty()) {
            return [
                'success' => false,
                'message' => 'Comments not found for this post',
                'status_code' => 404,
            ];
        }
        return [
            'success' => true,
            'status_code' => 200,
            'data' => CommentResource::collection($comments),
        ];
    }

    // Add new comments
    public function addComment($user, $postId, $content)
    {
        // Logic to add comment to the post
        $post = Post::find($postId);
        if (!$post) {
            return [
                'success' => false,
                'message' => 'Post not found',
                'status_code' => 404,
            ];
        }

        $comment = $post->comments()->create([
            'user_id' => $user->id,
            'comment' => $content,
        ]);

        return [
            'success' => true,
            'message' => 'Comment added successfully',
            'status_code' => 200,
            'comment' => new CommentResource($comment),
        ];
    }
}

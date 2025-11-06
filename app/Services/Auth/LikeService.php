<?php

namespace App\Services\Auth;
use App\Models\Post;
use App\Models\User;
use App\Http\Resources\UserResource;

class LikeService
{
    // Like a post
    public function likePost($user, $postId)
    {
        $post = Post::find($postId);
        if (!$post) {
            return [
                'success' => false,
                'message' => 'Post not found',
                'status_code' => 404,
            ];
        }
        $exists = $post->likes()->where('user_id', $user->id)->exists();
        if ($exists) {
            return [
                'success' => false,
                'message' => 'Already liked',
                'status_code' => 400,
            ];
        }
        $post->likes()->create(['user_id' => $user->id]);
        return [
            'success' => true,
            'message' => 'Liked',
            'status_code' => 200,
        ];
      
    }

    // Unlike a post
    public function unlikePost($user, $postId)
    {
        $post = Post::find($postId);
        if (!$post) {
            return [
                'success' => false,
                'message' => 'Post not found',
                'status_code' => 404,
            ];
        }

        $deleted = $post->likes()->where('user_id', $user->id)->delete();

        if (!$deleted) {
            return [
                'success' => false,
                'message' => 'Not liked yet',
                'status_code' => 400,
            ];
        }

        return [
            'success' => true,
            'message' => 'Unliked',
            'status_code' => 200,
        ];
    }
}
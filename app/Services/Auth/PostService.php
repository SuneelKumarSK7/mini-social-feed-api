<?php

namespace App\Services\Auth;

use App\Models\Post;
use App\Models\User;
use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PostService
{
    // list posts in reverse chronological order for logged in user
    public function index()
    {
        $posts = Post::with('author')->orderBy('created_at', 'desc')->paginate(10);
        if ($posts->isEmpty()) {
            return ['success' => false, 'message' => 'No posts found', 'status_code' => 404];
        }

        return PostResource::collection($posts);
    }

    public function show($id)
    {

        $post = Post::with(['author', 'comments.user', 'likes'])->find($id);
        if (!$post) {
            return ['success' => false, 'message' => 'Post not found', 'status_code' => 404];
        }

        return [
            'success' => true,
            'data' => new PostResource($post),
            'status_code' => 200
        ];
    }


    // Create a new post
    public function createPost(array $data, $user)
    {
        if (isset($data['media_path'])) {
            $file = $data['media_path'];
            $path = $file->store('posts', 'public');
            $media_type = $file->getClientMimeType();
        }

        $post = Post::create([
            'user_id' => $user->id,
            'text' => $data['text'],
            'media_path' => $path ?? null,
            'media_type' => $media_type ?? null,
        ]);

        $post->load('author');

        return $post;
    }

    // Delete post
    public function deletePost($userId, $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return [
                'success' => false,
                'message' => 'Post not found',
                'status_code' => 404
            ];
        }
        // only owner can delete
        if ($post->user_id !== $userId) {
            return ['success' => false, 'message' => 'Forbidden', 'status_code' => 403];
        }
        // delete media file if exists
        if ($post->media_path) {
            Storage::disk('public')->delete($post->media_path);
        }
        $post->delete();
        return ['success' => true, 'message' => 'Post deleted', 'status_code' => 200];
    }
}

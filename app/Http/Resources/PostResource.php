<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = $request->user();

        return [
            'id' => $this->id,
            'author' => new UserResource($this->whenLoaded('author')),
            'text' => $this->text,
            'media_url' => $this->media_path ? url('storage/'.$this->media_path) : null,
            'media_type' => $this->media_type,
            'like_count' => $this->likes()->count(),
            'comment_count' => $this->comments()->count(),
            'liked_by_me' => $user ? $this->likes()->where('user_id', $user->id)->exists() : false,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}

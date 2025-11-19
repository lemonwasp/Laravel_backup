<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'body' => $this->body,
            '_links' => [
                'self' => [
                    'href' => route('api.comments.show', ['comment' => $this->id]),
                ],
            ],
            // whenLoaded: 관계가 로드되었을 때만 포함시켜 N+1 문제를 방지
            '_embedded' => [
                'user' => new UserResource($this->whenLoaded('user')),
            ],
        ];
    }
}

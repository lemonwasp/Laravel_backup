<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    // 최상위 리소스의 data 키 제거
    public static $wrap = null;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'created_at' => $this->created_at->toDateTimeString(),
            '_links' => [
                'self' => [
                    'href' => route('api.articles.show', ['article' => $this->id]),
                ],
            ],
            '_embedded' => [
                'user' => new UserResource($this->whenLoaded('user')),
                // 리소스 컬렉션을 사용하여 댓글 목록을 변환
                'comments' => CommentResource::collection($this->whenLoaded('comments')),
            ],
        ];
    }
}

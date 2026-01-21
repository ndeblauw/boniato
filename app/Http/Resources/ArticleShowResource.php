<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ArticleShowResource extends JsonResource
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
            'title' => $this->title,
            'text' => $this->content,
            'author' => new AuthorShowResource($this->author),
            'promo_url' => route('articles.show', ['article' => $this->id]),
            'comments' => CommentIndexResource::collection($this->whenLoaded('comments')),
        ];
    }
}

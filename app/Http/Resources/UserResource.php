<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            $this->mergeWhen(auth()->check() && auth()->id() == $this->id, [
                'email' => $this->email,
            ]),
            'follow' => $this->users()->count(),
            'followers' => $this->follows()->count(),
            'followed' => (bool)$this->follows()->where('user_id', auth()->id())->count(),
            'articles' => ArticleResource::collection(
                $this->whenLoaded('articles')
            ),
            'create_dates' => [
                'created_at_human' => $this->created_at->diffForHumans(),
                'created_at' => $this->created_at
            ]
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return array_merge(parent::toArray($request), [
            'storage' => $this->type == 'image' ? 'storage/' . $this->content : null,
            'user' => UserResource::make($this->whenLoaded('user')),
        ]);
    }
}

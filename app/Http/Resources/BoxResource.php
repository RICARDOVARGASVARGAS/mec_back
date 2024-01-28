<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BoxResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return array_merge(parent::toArray($request), [
            'storage' => $this->image ? 'storage/' . $this->image : null,
            'company' => CompanyResource::make($this->whenLoaded('company')),
            'movements' => MovementResource::collection($this->whenLoaded('movements')),
        ]);
    }
}

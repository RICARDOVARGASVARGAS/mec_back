<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return array_merge(parent::toArray($request), [
            'storage' => $this->image ? 'storage/' . $this->image : null,
        ]);
    }

    // public function with($request)
    // {
    //     return [
    //         'storage' => $this->image ? 'storage/' . $this->image : null,
    //     ];
    // }
}

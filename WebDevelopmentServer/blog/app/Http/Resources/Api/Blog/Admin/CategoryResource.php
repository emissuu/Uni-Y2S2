<?php

namespace App\Http\Resources\Api\Blog\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'parent_id' => $this->parent_id == 0 ? null : $this->parent_id,
            'parent_title' => $this->parent_id == 0 ? null : $this->parent_category?->title,
            'description' => $this->description,
            'date_updated' => $this->updated_at
        ];
    }
}

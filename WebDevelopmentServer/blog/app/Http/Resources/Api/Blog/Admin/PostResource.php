<?php

namespace App\Http\Resources\Api\Blog\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Трансформація ресурсу в масив.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // $this вказує на поточний об'єкт моделі BlogPost
        return [
            'id'             => $this->id,
            'title'          => $this->title,
            'slug'           => $this->slug,
            'is_published'   => (bool) $this->is_published,

            // Форматуємо дату для зручності фронтенду
            'date_published' => $this->published_at ?(date_create( $this->published_at))->format('Y-m-d H:i:s') : null,
            'date_updated' => $this->updated_at ?(date_create( $this->updated_at))->format('Y-m-d H:i:s') : null,

            'content' => $this->content_html,

            // Передаємо id зв'язаних сутностей
            'user_id'        => $this->user_id,
            'category_id'    => $this->category_id,

            // Приклад виведення зв'язку (якщо у моделі BlogPost налаштовано зв'язки category та user)
             'category_title' => $this->category?->title,
             'author_name'    => $this->user?->name,
            'author_image_url' => $this->user?->profile_photo_url
        ];
    }
}

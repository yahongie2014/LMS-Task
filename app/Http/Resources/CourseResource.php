<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
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
            'slug' => $this->slug,
            'description' => $this->description,
            'image' => $this->getFileByLabel('main_image') ? $this->getFileByLabel('main_image')->url : ($this->image ? (str_starts_with($this->image, 'http') ? $this->image : asset('storage/' . $this->image)) : null),
            'level' => $this->level,
            'price' => $this->price,
            'currency' => \App\Models\Setting::getValue('currency', '$'),
            'duration' => $this->duration,
            'is_published' => $this->is_published,
            'instructor' => new InstructorResource($this->whenLoaded('instructor')),
            'lessons' => LessonResource::collection($this->whenLoaded('lessons')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

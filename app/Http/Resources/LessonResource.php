<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LessonResource extends JsonResource
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
            'course' => new CourseResource($this->whenLoaded('course')),
            'course_id' => $this->course_id,
            'title' => $this->title,
            'description' => $this->description,
            'video_type' => $this->video_type,
            'video_url' => $this->getFileByLabel('lesson_video') ? $this->getFileByLabel('lesson_video')->url : $this->video_url,
            'material_url' => $this->getFileByLabel('lesson_material') ? $this->getFileByLabel('lesson_material')->url : null,
            'duration' => $this->duration,
            'order_column' => $this->order_column,
            'is_preview' => $this->is_preview,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

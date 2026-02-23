<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CertificateResource extends JsonResource
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
            'user' => [
                'id' => $this->whenLoaded('user', fn () => $this->user->id),
                'name' => $this->whenLoaded('user', fn () => $this->user->name),
            ],
            'course' => [
                'id' => $this->whenLoaded('course', fn () => $this->course->id),
                'title' => $this->whenLoaded('course', fn () => $this->course->title),
            ],
            'issued_at' => $this->issued_at,
            'download_url' => route('certificates.show', $this->id),
        ];
    }
}

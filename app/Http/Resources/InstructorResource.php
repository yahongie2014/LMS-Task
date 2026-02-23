<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InstructorResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'bio' => $this->bio,
            'specialty' => $this->specialty,
            'avatar' => $this->getFileByLabel('avatar') ? $this->getFileByLabel('avatar')->url : ($this->avatar ? (str_starts_with($this->avatar, 'http') ? $this->avatar : asset('storage/' . $this->avatar)) : null),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

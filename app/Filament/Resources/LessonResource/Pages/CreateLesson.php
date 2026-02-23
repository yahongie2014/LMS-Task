<?php

namespace App\Filament\Resources\LessonResource\Pages;

use App\Filament\Resources\LessonResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLesson extends CreateRecord
{
    protected static string $resource = LessonResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (isset($data['video_type']) && $data['video_type'] !== 'custom' && isset($data['video_url_link'])) {
            $data['video_url'] = $data['video_url_link'];
        }
        unset($data['video_url_link']);

        return $data;
    }
}

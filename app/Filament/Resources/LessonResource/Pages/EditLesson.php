<?php

namespace App\Filament\Resources\LessonResource\Pages;

use App\Filament\Resources\LessonResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLesson extends EditRecord
{
    protected static string $resource = LessonResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (isset($data['video_type']) && $data['video_type'] !== 'custom' && isset($data['video_url_link'])) {
            $data['video_url'] = $data['video_url_link'];
        }
        unset($data['video_url_link']);

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

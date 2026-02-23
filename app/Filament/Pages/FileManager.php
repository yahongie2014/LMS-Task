<?php

namespace App\Filament\Pages;

use App\Models\File as FileModel;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Storage;
use Filament\Notifications\Notification;
use Illuminate\Support\Str;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;

class FileManager extends Page implements HasForms, HasActions
{
    use InteractsWithForms;
    use InteractsWithActions;

    protected static ?string $navigationIcon = 'heroicon-o-folder-open';

    protected static string $view = 'filament.pages.file-manager';
    
    protected static ?string $navigationGroup = 'Management';

    public function getTitle(): string | \Illuminate\Contracts\Support\Htmlable
    {
        return __('messages.file_manager');
    }

    public static function getNavigationLabel(): string
    {
        return __('messages.file_manager');
    }

    public $currentPath = '';
    public $folders = [];
    public $files = [];

    public function mount()
    {
        $this->loadPath('');
    }

    public function loadPath($path)
    {
        $this->currentPath = $path;
        $disk = Storage::disk('public');

        $this->folders = collect($disk->directories($path))->map(function ($dir) {
            return [
                'name' => basename($dir),
                'path' => $dir,
            ];
        })->toArray();

        $this->files = collect($disk->files($path))->map(function ($file) use ($disk) {
            $model = FileModel::where('file_name', basename($file))->first();
            return [
                'name' => basename($file),
                'path' => $file,
                'url' => Storage::disk('public')->url($file),
                'size' => number_format($disk->size($file) / 1024, 2) . ' KB',
                'id' => $model?->id,
            ];
        })->toArray();
    }

    public function navigateTo($path)
    {
        $this->loadPath($path);
    }

    public function navigateUp()
    {
        if (empty($this->currentPath)) return;
        
        $parts = explode('/', $this->currentPath);
        array_pop($parts);
        $this->loadPath(implode('/', $parts));
    }

    public function createFolderAction(): Action
    {
        return Action::make('createFolder')
            ->label(__('messages.new_folder'))
            ->icon('heroicon-o-folder-plus')
            ->form([
                TextInput::make('name')
                    ->label(__('messages.folder_name'))
                    ->required()
                    ->maxLength(255),
            ])
            ->action(function (array $data) {
                $newPath = $this->currentPath ? $this->currentPath . '/' . $data['name'] : $data['name'];
                
                if (Storage::disk('public')->exists($newPath)) {
                    Notification::make()->title(__('messages.folder_exists'))->danger()->send();
                    return;
                }

                Storage::disk('public')->makeDirectory($newPath);
                
                Notification::make()->title(__('messages.folder_created'))->success()->send();
                $this->loadPath($this->currentPath);
            });
    }

    public function uploadFileAction(): Action
    {
        return Action::make('uploadFile')
            ->label(__('messages.upload_file'))
            ->icon('heroicon-o-cloud-arrow-up')
            ->color('primary')
            ->form([
                FileUpload::make('attachment')
                    ->label(__('messages.file'))
                    ->directory($this->currentPath ?: 'uploads')
                    ->preserveFilenames()
                    ->required(),
            ])
            ->action(function (array $data) {
                // The file is automatically moved by Filament FileUpload component
                // If it was linked to a model, we'd create a File record here
                
                Notification::make()->title(__('messages.file_uploaded'))->success()->send();
                $this->loadPath($this->currentPath);
            });
    }

    public function viewFileAction(): Action
    {
        return Action::make('viewFile')
            ->icon('heroicon-o-eye')
            ->iconButton()
            ->tooltip(__('messages.explore_course'))
            ->color('gray')
            ->modalHeading(fn (array $arguments) => basename($arguments['path']))
            ->modalContent(function (array $arguments) {
                $url = Storage::disk('public')->url($arguments['path']);
                $extension = strtolower(pathinfo($arguments['path'], PATHINFO_EXTENSION));
                $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp']);
                $isPDF = $extension === 'pdf';
                $isVideo = in_array($extension, ['mp4', 'webm', 'ogg']);

                return view('filament.pages.sections.file-preview', [
                    'url' => $url,
                    'isImage' => $isImage,
                    'isPDF' => $isPDF,
                    'isVideo' => $isVideo,
                    'extension' => $extension,
                ]);
            })
            ->modalSubmitAction(false)
            ->modalFooterActions([]);
    }

    public function renameFileAction(): Action
    {
        return Action::make('renameFile')
            ->icon('heroicon-o-pencil-square')
            ->iconButton()
            ->color('warning')
            ->form([
                TextInput::make('name')
                    ->label(__('messages.new_name'))
                    ->required()
                    ->maxLength(255),
            ])
            ->mountUsing(fn (\Filament\Forms\Form $form, array $arguments) => $form->fill([
                'name' => basename($arguments['path']),
            ]))
            ->action(function (array $data, array $arguments) {
                $oldPath = $arguments['path'];
                $dir = dirname($oldPath);
                $newPath = ($dir === '.' ? '' : $dir . '/') . $data['name'];

                if (Storage::disk('public')->exists($newPath)) {
                    Notification::make()->title(__('messages.file_exists'))->danger()->send();
                    return;
                }

                Storage::disk('public')->move($oldPath, $newPath);
                
                // Update database if exists
                FileModel::where('file_name', basename($oldPath))->update(['file_name' => $data['name']]);

                Notification::make()->title(__('messages.file_renamed'))->success()->send();
                $this->loadPath($this->currentPath);
            });
    }

    public function renameFolderAction(): Action
    {
        return Action::make('renameFolder')
            ->icon('heroicon-o-pencil-square')
            ->iconButton()
            ->color('warning')
            ->form([
                TextInput::make('name')
                    ->label(__('messages.new_name'))
                    ->required()
                    ->maxLength(255),
            ])
            ->mountUsing(fn (\Filament\Forms\Form $form, array $arguments) => $form->fill([
                'name' => basename($arguments['path']),
            ]))
            ->action(function (array $data, array $arguments) {
                $oldPath = $arguments['path'];
                $dir = dirname($oldPath);
                $newPath = ($dir === '.' ? '' : $dir . '/') . $data['name'];

                if (Storage::disk('public')->exists($newPath)) {
                    Notification::make()->title(__('messages.folder_exists'))->danger()->send();
                    return;
                }

                Storage::disk('public')->move($oldPath, $newPath);

                Notification::make()->title(__('messages.folder_renamed'))->success()->send();
                $this->loadPath($this->currentPath);
            });
    }

    public function deleteFile($path)
    {
        Storage::disk('public')->delete($path);
        FileModel::where('file_name', basename($path))->delete();

        Notification::make()->title(__('messages.file_deleted'))->success()->send();
        $this->loadPath($this->currentPath);
    }
    
    public function deleteFolder($path)
    {
        if (Storage::disk('public')->deleteDirectory($path)) {
            Notification::make()->title(__('messages.folder_deleted'))->success()->send();
        }
        $this->loadPath($this->currentPath);
    }
}

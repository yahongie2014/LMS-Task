<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Notifications\Notification;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Exceptions\Halt;

class Settings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $view = 'filament.pages.settings';

    protected static ?string $navigationGroup = 'Management';

    public ?array $data = [];

    public function mount(): void
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        $this->form->fill($settings);
    }

    public function getTitle(): string | \Illuminate\Contracts\Support\Htmlable
    {
        return __('messages.settings');
    }

    public static function getNavigationLabel(): string
    {
        return __('messages.settings');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('messages.general_settings'))
                    ->schema([
                        TextInput::make('currency')
                            ->label(__('messages.currency'))
                            ->placeholder('$, EGP, USD...')
                            ->required(),
                    ]),
                Section::make(__('messages.intro_popup_settings'))
                    ->schema([
                        Toggle::make('intro_enabled')
                            ->label(__('messages.intro_enabled'))
                            ->reactive(),
                        Select::make('intro_type')
                            ->label(__('messages.intro_type'))
                            ->options([
                                'image' => __('messages.image'),
                                'youtube' => __('messages.youtube'),
                                'video' => __('messages.video'),
                            ])
                            ->visible(fn ($get) => $get('intro_enabled'))
                            ->reactive()
                            ->required(),
                        FileUpload::make('intro_image')
                            ->label(__('messages.intro_image'))
                            ->image()
                            ->directory('settings')
                            ->visible(fn ($get) => $get('intro_enabled') && $get('intro_type') === 'image')
                            ->required(fn ($get) => $get('intro_enabled') && $get('intro_type') === 'image'),
                        TextInput::make('intro_youtube_link')
                            ->label(__('messages.intro_youtube_link'))
                            ->url()
                            ->visible(fn ($get) => $get('intro_enabled') && $get('intro_type') === 'youtube')
                            ->required(fn ($get) => $get('intro_enabled') && $get('intro_type') === 'youtube'),
                        FileUpload::make('intro_custom_video')
                            ->label(__('messages.intro_custom_video'))
                            ->directory('settings')
                            ->acceptedFileTypes(['video/mp4', 'video/webm', 'video/ogg'])
                            ->visible(fn ($get) => $get('intro_enabled') && $get('intro_type') === 'video')
                            ->required(fn ($get) => $get('intro_enabled') && $get('intro_type') === 'video'),
                    ]),
            ])
            ->statePath('data');
    }

    public function submit(): void
    {
        try {
            $data = $this->form->getState();

            foreach ($data as $key => $value) {
                Setting::setValue($key, $value);
            }

            Notification::make()
                ->title(__('messages.settings_saved'))
                ->success()
                ->send();
        } catch (Halt $exception) {
            return;
        }
    }
}

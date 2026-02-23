<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LessonResource\Pages;
use App\Filament\Resources\LessonResource\RelationManagers;
use App\Models\Lesson;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LessonResource extends Resource
{
    protected static ?string $model = Lesson::class;

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';

    protected static ?string $navigationGroup = null;

    public static function getNavigationGroup(): ?string
    {
        return __('messages.education');
    }

    public static function getModelLabel(): string
    {
        return __('messages.lesson');
    }

    public static function getPluralModelLabel(): string
    {
        return __('messages.lessons');
    }

    public static function getNavigationLabel(): string
    {
        return __('messages.lessons');
    }

    protected static ?string $recordTitleAttribute = 'title_en';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('course_id')
                    ->label(__('messages.course_title'))
                    ->relationship('course', 'title_en')
                    ->required(),
                Forms\Components\TextInput::make('title_en')
                    ->label(__('messages.title_en'))
                    ->required(),
                Forms\Components\TextInput::make('title_ar')
                    ->label(__('messages.title_ar'))
                    ->required(),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\RichEditor::make('description_en')
                    ->label(__('messages.description_en'))
                    ->columnSpanFull(),
                Forms\Components\RichEditor::make('description_ar')
                    ->label(__('messages.description_ar'))
                    ->columnSpanFull(),
                Forms\Components\Select::make('video_type')
                    ->label(__('messages.type'))
                    ->options([
                        'custom' => __('messages.custom_video'),
                        'youtube' => 'YouTube',
                        'plyr' => __('messages.plyr'),
                    ])
                    ->default('custom')
                    ->live()
                    ->required(),
                Forms\Components\FileUpload::make('video_url')
                    ->label(__('messages.upload_file'))
                    ->directory('lessons/videos')
                    ->acceptedFileTypes(['video/*'])
                    ->visible(fn (\Filament\Forms\Get $get) => $get('video_type') === 'custom')
                    ->required(fn (\Filament\Forms\Get $get) => $get('video_type') === 'custom'),
                Forms\Components\TextInput::make('video_url_link')
                    ->label(__('messages.video_url_link'))
                    ->maxLength(255)
                    ->visible(fn (\Filament\Forms\Get $get) => in_array($get('video_type'), ['youtube', 'plyr']))
                    ->formatStateUsing(fn ($record) => $record?->video_type !== 'custom' ? $record?->video_url : null)
                    ->required(fn (\Filament\Forms\Get $get) => in_array($get('video_type'), ['youtube', 'plyr'])),
                Forms\Components\TextInput::make('order_column')
                    ->label(__('messages.order_column'))
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('duration')
                    ->label(__('messages.duration_minutes'))
                    ->numeric()
                    ->suffix('minutes'),
                Forms\Components\Toggle::make('is_preview')
                    ->label(__('messages.is_preview'))
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('preview')
                    ->label(__('messages.preview_certificate'))
                    ->disk('public')
                    ->getStateUsing(fn ($record) => $record->getFileByLabel('lesson_video')?->file_name),
                Tables\Columns\TextColumn::make('course.title')
                    ->label(__('messages.course_title'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('title_en')
                    ->label(__('messages.title_en'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('title_ar')
                    ->label(__('messages.title_ar'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('order_column')
                    ->label(__('messages.order_column'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('duration')
                    ->label(__('messages.duration_minutes'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('is_preview')
                    ->label(__('messages.is_preview')),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            \App\Filament\RelationManagers\FilesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLessons::route('/'),
            'create' => Pages\CreateLesson::route('/create'),
            'edit' => Pages\EditLesson::route('/{record}/edit'),
        ];
    }
}

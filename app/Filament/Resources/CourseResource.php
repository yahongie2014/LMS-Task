<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseResource\Pages;
use App\Filament\Resources\CourseResource\RelationManagers;
use App\Models\Course;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationGroup = null;

    public static function getNavigationGroup(): ?string
    {
        return __('messages.education');
    }

    public static function getModelLabel(): string
    {
        return __('messages.explore_course');
    }

    public static function getPluralModelLabel(): string
    {
        return __('messages.courses');
    }

    public static function getNavigationLabel(): string
    {
        return __('messages.courses');
    }

    protected static ?string $recordTitleAttribute = 'title_en';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
                Forms\Components\FileUpload::make('image')
                    ->label(__('messages.image'))
                    ->image()
                    ->directory('courses'),
                Forms\Components\Select::make('level')
                    ->label(__('messages.level'))
                    ->options([
                        'beginner' => __('messages.beginner'),
                        'intermediate' => __('messages.intermediate'),
                        'advanced' => __('messages.advanced'),
                    ])
                    ->required()
                    ->default('beginner'),
                Forms\Components\TextInput::make('price')
                    ->label(__('messages.price'))
                    ->numeric()
                    ->prefix(\App\Models\Setting::getValue('currency', '$')),
                Forms\Components\TextInput::make('duration')
                    ->label(__('messages.duration_minutes'))
                    ->numeric()
                    ->suffix('minutes'),
                Forms\Components\Select::make('instructor_id')
                    ->label(__('messages.instructor'))
                    ->relationship('instructor', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Toggle::make('is_published')
                    ->label(__('messages.is_published'))
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('instructor.name')
                    ->label(__('messages.instructor'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('title_en')
                    ->label(__('messages.title_en'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title_ar')
                    ->label(__('messages.title_ar'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image')
                    ->label(__('messages.image'))
                    ->disk('public'),
                Tables\Columns\BadgeColumn::make('level')
                    ->label(__('messages.level'))
                    ->colors([
                        'primary' => 'beginner',
                        'warning' => 'intermediate',
                        'danger' => 'advanced',
                    ])
                    ->formatStateUsing(fn ($state) => __('messages.' . $state))
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->label(__('messages.price'))
                    ->suffix(' ' . \App\Models\Setting::getValue('currency', '$'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('duration')
                    ->label(__('messages.duration_minutes'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('is_published')
                    ->label(__('messages.is_published')),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label(__('messages.is_published')),
                Tables\Filters\SelectFilter::make('level')
                    ->label(__('messages.level'))
                    ->options([
                        'beginner' => __('messages.beginner'),
                        'intermediate' => __('messages.intermediate'),
                        'advanced' => __('messages.advanced'),
                    ]),
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
            RelationManagers\LessonsRelationManager::class,
            \App\Filament\RelationManagers\FilesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCourses::route('/'),
            'create' => Pages\CreateCourse::route('/create'),
            'edit' => Pages\EditCourse::route('/{record}/edit'),
        ];
    }
}

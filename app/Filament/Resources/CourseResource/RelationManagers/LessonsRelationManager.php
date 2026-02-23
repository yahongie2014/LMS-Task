<?php

namespace App\Filament\Resources\CourseResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\Concerns\Translatable;

class LessonsRelationManager extends RelationManager
{
    use Translatable;

    protected static string $relationship = 'lessons';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label(__('messages.title'))
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->label(__('messages.description'))
                    ->rows(3),
                Forms\Components\TextInput::make('video_url')
                    ->label(__('messages.video_url'))
                    ->maxLength(255),
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

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(__('messages.title'))
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
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}

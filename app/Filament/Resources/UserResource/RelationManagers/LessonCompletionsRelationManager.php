<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LessonCompletionsRelationManager extends RelationManager
{
    protected static string $relationship = 'lessonCompletions';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('course_id')
                    ->label(__('messages.course_title'))
                    ->relationship('course', 'title_en')
                    ->required(),
                Forms\Components\Select::make('lesson_id')
                    ->label(__('messages.title'))
                    ->relationship('lesson', 'title_en')
                    ->required(),
                Forms\Components\DateTimePicker::make('started_at'),
                Forms\Components\DateTimePicker::make('completed_at'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('lesson.title')
            ->columns([
                Tables\Columns\TextColumn::make('course.title')
                    ->label(__('messages.course_title'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lesson.title')
                    ->label(__('messages.title'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('completed_at')
                    ->label(__('messages.completed_at'))
                    ->dateTime()
                    ->sortable(),
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

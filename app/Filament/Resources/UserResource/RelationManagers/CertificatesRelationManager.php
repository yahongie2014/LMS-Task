<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CertificatesRelationManager extends RelationManager
{
    protected static string $relationship = 'certificates';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('course_id')
                    ->label(__('messages.course_title'))
                    ->relationship('course', 'title_en')
                    ->required(),
                Forms\Components\DateTimePicker::make('issued_at')
                    ->label(__('messages.issued_at'))
                    ->default(now())
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('course.title')
            ->columns([
                Tables\Columns\TextColumn::make('course.title')
                    ->label(__('messages.course_title'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('issued_at')
                    ->label(__('messages.issued_at'))
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
                Tables\Actions\Action::make('download_ar')
                    ->label('Download (AR)')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->url(fn (\App\Models\Certificate $record) => route('admin.certificates.download', ['certificate' => $record->id, 'lang' => 'ar']))
                    ->openUrlInNewTab(),
                Tables\Actions\Action::make('download_en')
                    ->label('Download (EN)')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('info')
                    ->url(fn (\App\Models\Certificate $record) => route('admin.certificates.download', ['certificate' => $record->id, 'lang' => 'en']))
                    ->openUrlInNewTab(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}

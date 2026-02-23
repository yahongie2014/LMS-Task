<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CertificateResource\Pages;
use App\Filament\Resources\CertificateResource\RelationManagers;
use App\Models\Certificate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CertificateResource extends Resource
{
    protected static ?string $model = Certificate::class;

    protected static ?string $navigationIcon = 'heroicon-o-trophy';

    protected static ?string $navigationGroup = null;

    public static function getNavigationGroup(): ?string
    {
        return __('messages.management');
    }

    public static function getModelLabel(): string
    {
        return __('messages.certificates');
    }

    public static function getPluralModelLabel(): string
    {
        return __('messages.certificates');
    }

    public static function getNavigationLabel(): string
    {
        return __('messages.certificates');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label(__('messages.user'))
                    ->relationship('user', 'name')
                    ->required(),
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('messages.user'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('course.title')
                    ->label(__('messages.course_title'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('issued_at')
                    ->label(__('messages.issued_at'))
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('download_ar')
                    ->label('Download (AR)')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->url(fn (Certificate $record) => route('admin.certificates.download', ['certificate' => $record->id, 'lang' => 'ar']))
                    ->openUrlInNewTab(),
                Tables\Actions\Action::make('download_en')
                    ->label('Download (EN)')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('info')
                    ->url(fn (Certificate $record) => route('admin.certificates.download', ['certificate' => $record->id, 'lang' => 'en']))
                    ->openUrlInNewTab(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCertificates::route('/'),
            'create' => Pages\CreateCertificate::route('/create'),
            'edit' => Pages\EditCertificate::route('/{record}/edit'),
        ];
    }
}

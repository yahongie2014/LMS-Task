<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EnrollmentResource\Pages;
use App\Filament\Resources\EnrollmentResource\RelationManagers;
use App\Models\Enrollment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use App\Models\Certificate;
use Filament\Notifications\Notification;

class EnrollmentResource extends Resource
{
    protected static ?string $model = Enrollment::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-plus';

    protected static ?string $navigationGroup = null;

    public static function getNavigationGroup(): ?string
    {
        return __('messages.management');
    }

    public static function getModelLabel(): string
    {
        return __('messages.enrollment');
    }

    public static function getPluralModelLabel(): string
    {
        return __('messages.enrollments');
    }

    public static function getNavigationLabel(): string
    {
        return __('messages.enrollments');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label(__('messages.user'))
                    ->relationship('user', 'name')
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('course_id')
                    ->label(__('messages.course_title'))
                    ->relationship('course', 'title_en')
                    ->searchable()
                    ->required(),
                Forms\Components\DateTimePicker::make('enrolled_at')
                    ->label(__('messages.enrolled_at'))
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
                Tables\Columns\TextColumn::make('enrolled_at')
                    ->label(__('messages.enrolled_at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('generateCertificate')
                    ->label(__('messages.generate_certificate'))
                    ->icon('heroicon-o-document-text')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function (Enrollment $record) {
                        $exists = Certificate::where('user_id', $record->user_id)
                            ->where('course_id', $record->course_id)
                            ->exists();

                        if ($exists) {
                            Notification::make()
                                ->title(__('messages.duplicate_certificate'))
                                ->warning()
                                ->send();
                            return;
                        }

                        Certificate::create([
                            'user_id' => $record->user_id,
                            'course_id' => $record->course_id,
                            'issued_at' => now(),
                        ]);

                        Notification::make()
                            ->title(__('messages.certificate_generated'))
                            ->success()
                            ->send();
                    }),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEnrollments::route('/'),
            'create' => Pages\CreateEnrollment::route('/create'),
            'edit' => Pages\EditEnrollment::route('/{record}/edit'),
        ];
    }
}

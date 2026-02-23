<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = null;

    public static function getNavigationGroup(): ?string
    {
        return __('messages.security');
    }

    protected static ?string $recordTitleAttribute = 'name';

    public static function getModelLabel(): string
    {
        return __('messages.user');
    }

    public static function getPluralModelLabel(): string
    {
        return __('messages.students');
    }

    public static function getNavigationLabel(): string
    {
        return __('messages.students');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('messages.name'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->label(__('messages.email'))
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\TextInput::make('password')
                    ->label(__('messages.password'))
                    ->password()
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => $context === 'create')
                    ->maxLength(255),
                Forms\Components\TextInput::make('wallet_balance')
                    ->label(__('messages.wallet_balance'))
                    ->formatStateUsing(fn ($record) => $record ? \App\Models\Setting::getValue('currency', '$') . number_format($record->balance, 2) : \App\Models\Setting::getValue('currency', '$') . '0.00')
                    ->disabled()
                    ->dehydrated(false)
                    ->visibleOn('edit')
                    ->suffixActions([
                        Forms\Components\Actions\Action::make('edit_balance')
                            ->label(__('messages.edit'))
                            ->icon('heroicon-m-pencil-square')
                            ->form([
                                Forms\Components\TextInput::make('new_balance')
                                    ->numeric()
                                    ->required()
                                    ->default(fn ($record) => $record->balance ?? 0)
                            ])
                            ->action(function ($record, array $data, Forms\Set $set) {
                                if ($record) {
                                    $wallet = $record->wallet()->firstOrCreate([], ['balance' => 0]);
                                    $wallet->balance = (float)$data['new_balance'];
                                     $wallet->save();
                                    
                                    $set('wallet_balance', \App\Models\Setting::getValue('currency', '$') . number_format($wallet->balance, 2));
                                    \Filament\Notifications\Notification::make()->title(__('messages.balance_updated'))->success()->send();
                                }
                            }),
                        Forms\Components\Actions\Action::make('reset_balance')
                            ->label(__('messages.reset'))
                            ->icon('heroicon-m-arrow-path')
                            ->color('danger')
                            ->requiresConfirmation()
                            ->action(function ($record, Forms\Set $set) {
                                if ($record) {
                                    $wallet = $record->wallet()->firstOrCreate([], ['balance' => 0]);
                                    $wallet->balance = 0;
                                     $wallet->save();
                                    
                                    $set('wallet_balance', \App\Models\Setting::getValue('currency', '$') . '0.00');
                                    \Filament\Notifications\Notification::make()->title(__('messages.balance_reset'))->success()->send();
                                }
                            })
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar')
                    ->label(__('messages.avatar'))
                    ->circular()
                    ->disk('public')
                    ->getStateUsing(fn ($record) => $record->getFileByLabel('avatar')?->file_name),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('messages.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('messages.email'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('balance')
                    ->label(__('messages.wallet_balance'))
                    ->getStateUsing(fn ($record) => \App\Models\Setting::getValue('currency', '$') . number_format($record->balance, 2)),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable(),
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
            RelationManagers\EnrollmentsRelationManager::class,
            RelationManagers\LessonCompletionsRelationManager::class,
            RelationManagers\CertificatesRelationManager::class,
            \App\Filament\RelationManagers\FilesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FilesRelationManager extends RelationManager
{
    protected static string $relationship = 'files';

    public function form(Form $form): Form
    {
        $ownerModelName = Str::plural(Str::snake(class_basename($this->getOwnerRecord())));

        return $form
            ->schema([
                Forms\Components\FileUpload::make('file_name')
                    ->label(__('messages.file'))
                    ->directory($ownerModelName)
                    ->preserveFilenames()
                    ->required()
                    ->columnSpanFull()
                    ->live()
                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                        if ($state instanceof \Illuminate\Http\UploadedFile) {
                            $set('label', $state->getClientOriginalName());
                            $set('file_type', $state->getClientOriginalExtension());
                            $set('file_size', $state->getSize());
                        } elseif (is_string($state)) {
                            $set('label', basename($state));
                            $set('file_type', pathinfo($state, PATHINFO_EXTENSION));
                        }
                    }),
                Forms\Components\TextInput::make('label')
                    ->label(__('messages.label'))
                    ->placeholder(__('messages.auto_from_name'))
                    ->disabled()
                    ->dehydrated()
                    ->required(),
                Forms\Components\TextInput::make('folder')
                    ->label(__('messages.folder'))
                    ->default($ownerModelName)
                    ->disabled()
                    ->dehydrated()
                    ->required(),
                Forms\Components\TextInput::make('file_type')
                    ->label(__('messages.type'))
                    ->placeholder(__('messages.auto'))
                    ->disabled()
                    ->dehydrated(),
                Forms\Components\TextInput::make('file_size')
                    ->label(__('messages.size_bytes'))
                    ->placeholder(__('messages.auto'))
                    ->disabled()
                    ->dehydrated(),
                Forms\Components\TextInput::make('notes')
                    ->label(__('messages.notes')),
                Forms\Components\TextInput::make('order')
                    ->label(__('messages.order'))
                    ->numeric()
                    ->default(1),
                Forms\Components\Toggle::make('is_active')
                    ->label(__('messages.is_active'))
                    ->default(true),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('label')
            ->columns([
                Tables\Columns\ImageColumn::make('file_name')
                    ->label(__('messages.preview'))
                    ->disk('public')
                    ->circular(),
                Tables\Columns\TextColumn::make('label')
                    ->label(__('messages.label'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('file_name')
                    ->label(__('messages.system_name'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('file_type')
                    ->label(__('messages.type'))
                    ->badge(),
                Tables\Columns\TextColumn::make('file_size')
                    ->label(__('messages.size'))
                    ->formatStateUsing(fn ($state) => $state ? number_format($state / 1024, 2) . ' KB' : '-'),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label(__('messages.is_active')),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        return $this->processFileData($data);
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        return $this->processFileData($data);
                    }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    protected function processFileData(array $data): array
    {
        if (isset($data['file_name'])) {
            $path = $data['file_name'];
            $data['file_type'] = pathinfo($path, PATHINFO_EXTENSION);
            
            if (Storage::disk('public')->exists($path)) {
                $data['file_size'] = Storage::disk('public')->size($path);
            }
        }
        return $data;
    }
}

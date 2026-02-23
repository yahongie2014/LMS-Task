<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class BestStudents extends BaseWidget
{
    protected static ?int $sort = 4;
    
    protected static ?string $heading = 'Top Performers (Most Certificates)';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                User::withCount('certificates')
                    ->orderByDesc('certificates_count')
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Student Name'),
                Tables\Columns\TextColumn::make('certificates_count')
                    ->label('Certificates Earned')
                    ->badge()
                    ->color('success'),
            ]);
    }
}

<?php

namespace App\Filament\Widgets;

use App\Models\Enrollment;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestEnrollments extends BaseWidget
{
    protected static ?int $sort = 2;
    
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Enrollment::query()->latest()->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Student'),
                Tables\Columns\TextColumn::make('course.title')
                    ->label('Course'),
                Tables\Columns\TextColumn::make('enrolled_at')
                    ->dateTime()
                    ->label('Enrolled At'),
            ]);
    }
}

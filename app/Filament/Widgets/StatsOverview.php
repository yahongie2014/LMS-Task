<?php

namespace App\Filament\Widgets;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::count())
                ->description('Total registered students')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),
            Stat::make('Total Courses', Course::count())
                ->description('Active courses in catalog')
                ->descriptionIcon('heroicon-m-book-open')
                ->color('info'),
            Stat::make('Total Enrollments', Enrollment::count())
                ->description('Course enrollments to date')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('primary'),
        ];
    }
}

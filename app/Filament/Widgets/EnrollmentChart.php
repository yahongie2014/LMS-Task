<?php

namespace App\Filament\Widgets;

use App\Models\Enrollment;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class EnrollmentChart extends ChartWidget
{
    protected static ?string $heading = 'Enrollments Over Time';
    
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $data = Enrollment::select(DB::raw('date(enrolled_at) as date'), DB::raw('count(*) as count'))
            ->where('enrolled_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Enrollments',
                    'data' => $data->pluck('count')->toArray(),
                    'fill' => 'start',
                ],
            ],
            'labels' => $data->pluck('date')->map(fn ($date) => Carbon::parse($date)->format('M d'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}

<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\ChartWidget;

class Graph extends ChartWidget
{
    protected static ?string $heading = 'Test Chart';

    protected function getData(): array
    {
        $userCount = User::count();
       $previousMonthUserCount = User::whereMonth('created_at', now()->subMonth()->month)->count();
        

      

        $data = [
            'labels' => [
                'Previous Month',
                'Current Month'
            ],
            'datasets' => [[
                'label' => 'User Count',
                'data' => [$previousMonthUserCount, $userCount],
                'backgroundColor' => [
                    'rgb(255, 99, 132)',
                    'rgb(75, 192, 192)'
                ]
            ]]
        ];

        return $data;
    }

    protected function getConfig(): array
    {
        return [
            'type' => 'bar',
            'data' => $this->getData(),
            'options' => [
                'scales' => [
                    'yAxes' => [
                        ['ticks' => ['beginAtZero' => true]]
                    ]
                ]
            ]
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}

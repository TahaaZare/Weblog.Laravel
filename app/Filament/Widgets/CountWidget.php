<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use App\Models\User;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CountWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Users', User::all()->count())
                ->description('Total Number of Users')
                ->descriptionIcon('heroicon-s-users', IconPosition::Before)
                ->chart([10, 20, 30, 40, 50, 60, 70, 80, 90, 100])
                ->color('info')
            ,
            Stat::make('Articles', Article::all()->count())
                ->description('Total Number of Articles')
                ->chart([10, 20, 30, 40, 50, 60, 70, 80, 90, 100])
                ->color('primary')
        ];
    }
}

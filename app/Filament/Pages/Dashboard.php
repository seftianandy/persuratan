<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    // protected static string $view = 'filament.pages.dashboard';

    protected static ?string $title = 'Dashboard';

    protected static ?string $slug = '/';

    public function getHeaderWidgets(): array
    {
        return [
            \app\Filament\Resources\IncomingMailResource\Widgets\TotalIncomingMailWidget::class,
            \app\Filament\Resources\IncomingMailResource\Widgets\IncomingMailWidget::class,
        ];
    }
}

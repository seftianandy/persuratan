<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    // protected static string $view = 'filament.pages.dashboard';

    protected static ?string $title = 'Dashboard';

    protected static ?string $slug = '/';

    // public function getHeaderWidgets(): array
    // {
    //     return [
    //         \App\Filament\Widgets\TotalIncomingMailWidget::make(),
    //         \App\Filament\Widgets\IncomingMailWidget::make(),
    //         \App\Filament\Widgets\OutcomingMailWidget::make(),
    //         \App\Filament\Widgets\IncomingMailTableDataWidget::make(),
    //     ];
    // }
}

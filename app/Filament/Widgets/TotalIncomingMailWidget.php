<?php

namespace App\Filament\Widgets;

use App\Models\IncomingMail;
use App\Models\OutcomingMail;
use App\Models\Setting;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class TotalIncomingMailWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $user = Auth::user();
        $totalIncomingMail = IncomingMail::count();
        $totalOutcomingMail = OutcomingMail::count();
        $nameOrganization = Setting::find(1);


        return [
            Stat::make('Selamat Datang', $user->name ?? 'Admin')
                ->description($nameOrganization->name ?? 'Organisasi'),
            Stat::make('Jumlah Surat Keluar', number_format($totalOutcomingMail))
                ->description('Lihat detail')
                ->descriptionIcon('heroicon-m-arrow-right')
                ->color('info')
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                    'onclick' => "window.location.href='/admin/master/senders'",
                ]),
            Stat::make('Jumlah Surat Masuk', number_format($totalIncomingMail))
                ->description('Lihat detail')
                ->descriptionIcon('heroicon-m-arrow-right')
                ->color('info')
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                    'onclick' => "window.location.href='/admin/incoming-mails'",
                ]),
        ];
    }
}

<?php

namespace App\Filament\Resources\IncomingMailResource\Widgets;

use App\Models\IncomingMail;
use App\Models\Sender;
use App\Models\Reciver;
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
        $totalSender = Sender::count();
        $totalReciver = Reciver::count();
        $nameOrganization = Setting::find(1);


        return [
            Stat::make('Selamat Datang', $user->name ?? 'Admin')
                ->description($nameOrganization->name ?? 'Organisasi'),
            Stat::make('Jumlah Surat Masuk', number_format($totalIncomingMail))
                ->description('Lihat detail')
                ->descriptionIcon('heroicon-m-arrow-right')
                ->color('info')
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                    'onclick' => "window.location.href='/admin/incoming-mails'",
                ]),
            Stat::make('Jumlah Pengirim', number_format($totalSender))
                ->description('Lihat detail')
                ->descriptionIcon('heroicon-m-arrow-right')
                ->color('info')
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                    'onclick' => "window.location.href='/admin/master/senders'",
                ]),
            Stat::make('Jumlah Penerima', number_format($totalReciver))
                ->description('Lihat detail')
                ->descriptionIcon('heroicon-m-arrow-right')
                ->color('info')
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                    'onclick' => "window.location.href='/admin/master/recivers'",
                ]),
        ];
    }
}

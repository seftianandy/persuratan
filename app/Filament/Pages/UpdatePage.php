<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

use App\Filament\Clusters\Settings;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Artisan;

class UpdatePage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-arrow-path';

    protected static ?string $cluster = Settings::class;

    protected static ?string $navigationLabel = 'Update Aplikasi';

    protected static string $view = 'filament.pages.update-pages';

    public function runUpdateApp()
    {
        $output = shell_exec('cd ' . base_path() . ' && git stash && git clean -df && git pull origin main && composer update 2>&1');
        Artisan::call('migrate');

        Notification::make()
                ->title("Update Aplikasi Berhasil")
                ->body(nl2br($output))
                ->success()
                ->send();
    }
}

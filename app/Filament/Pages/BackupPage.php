<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

use App\Filament\Clusters\Settings;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class BackupPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';

    protected static ?string $cluster = Settings::class;

    protected static ?string $navigationLabel = 'Backup Data';

    protected ?string $heading = 'Backup Data';

    protected static string $view = 'filament.pages.backup-page';


    public function runBackup()
    {
        Artisan::call('backup:run');

        Notification::make()
                ->title("Backup berhasil dijalankan")
                ->success()
                ->send();
    }

    public function getBackupFiles()
    {
        return collect(Storage::disk('local')->files('E-Arsip'))
                ->sortByDesc(function ($file) {
                    return Storage::disk('local')->lastModified($file);
                })
                ->values()
                ->all();
    }

    public function deleteBackup($file)
    {
        $filePath = "E-Arsip/{$file}"; // Hilangkan "private/"

        if (!Storage::disk('local')->exists($filePath)) {
            Notification::make()
                ->title("File backup tidak ditemukan: $filePath")
                ->danger()
                ->send();
            return;
        }

        if (Storage::disk('local')->delete($filePath)) {
            Notification::make()
                ->title("Backup $file berhasil dihapus!")
                ->success()
                ->send();
        } else {
            Notification::make()
                ->title("Gagal menghapus backup: $filePath")
                ->danger()
                ->send();
        }
    }
}

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IncomingMailController;
use App\Http\Controllers\OutcomingMailController;
use App\Filament\Pages\BackupPage;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return redirect()->route('filament.admin.auth.login');
});

// Route::get('/download-file/{id}', [IncomingMailController::class, 'downloadFile'])->name('incoming-mails.download');
Route::get('/admin/incoming-mails/preview/{id}', [IncomingMailController::class, 'previewFile'])
    ->name('incoming-mails.preview');

Route::get('/admin/outcoming-mails/preview/{id}', [OutcomingMailController::class, 'previewFile'])
    ->name('outcoming-mails.preview');

Route::get('/backup', BackupPage::class)->name('admin.settings.backup-page');
// Route::get('/backup/download/{file}', [BackupPage::class, 'downloadBackup'])->name('admin.settings.backup-download');
Route::get('/backup/download/{file}', function ($file) {
    $filePath = storage_path("app/private/E-Arsip/{$file}");

    if (!file_exists($filePath)) {
        abort(404, 'File backup tidak ditemukan.');
    }

    return response()->download($filePath);
})->where('file', '.*')->name('admin.settings.backup-download');


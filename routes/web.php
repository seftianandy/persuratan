<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IncomingMailController;
use App\Http\Controllers\OutcomingMailController;
use App\Http\Controllers\PublicOutcomingMailController;
use App\Http\Controllers\ExampleOutcomingMailController;
use App\Filament\Pages\BackupPage;
use Illuminate\Support\Facades\Storage;
use App\Models\OutcomingMail;

Route::get('/', function () {
    return redirect()->route('filament.admin.auth.login');
});

Route::get('/admin/incoming-mails/preview/{id}', [IncomingMailController::class, 'previewFile'])
    ->name('incoming-mails.preview');

Route::get('/admin/outcoming-mails/preview/{id}', [OutcomingMailController::class, 'previewFile'])
    ->name('outcoming-mails.preview');

Route::get('/admin/master/example-outcoming-mails/preview/{uuid}', [ExampleOutcomingMailController::class, 'previewFile'])
    ->name('example-outcoming-mails.preview');

Route::get('/backup', BackupPage::class)->name('admin.settings.backup-page');
Route::get('/backup/download/{file}', function ($file) {
    $filePath = storage_path("app/private/E-Arsip/{$file}");

    if (!file_exists($filePath)) {
        abort(404, 'File backup tidak ditemukan.');
    }

    return response()->download($filePath);
})->where('file', '.*')->name('admin.settings.backup-download');

Route::get('/outcoming-mails/public/{uuid}', [PublicOutcomingMailController::class, 'previewByUuid'])
    ->name('outcoming-mails.public');

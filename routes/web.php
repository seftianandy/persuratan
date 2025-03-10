<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IncomingMailController;

Route::get('/', function () {
    return redirect()->route('filament.admin.auth.login');
});

// Route::get('/download-file/{id}', [IncomingMailController::class, 'downloadFile'])->name('incoming-mails.download');
Route::get('/admin/incoming-mails/preview/{id}', [IncomingMailController::class, 'previewFile'])
    ->name('incoming-mails.preview');

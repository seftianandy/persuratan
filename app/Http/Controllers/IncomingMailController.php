<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IncomingMail;

class IncomingMailController extends Controller
{
    public function previewFile($id)
    {
        $mail = IncomingMail::findOrFail($id);
        $file_contents = base64_decode($mail->file);

        if (!$mail->file) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        return response($file_contents)
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0')
            ->header('Content-Type', 'application/pdf'); // Menggunakan content-type PDF tanpa 'attachment'
    }


}

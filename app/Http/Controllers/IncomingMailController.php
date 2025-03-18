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

        // Cek apakah file adalah PDF atau Gambar
        if ($mail->file_type === 'application/pdf') {
            return response($file_contents)
                ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0')
                ->header('Content-Type', 'application/pdf'); // Menampilkan langsung PDF
        } elseif (in_array($mail->file_type, ['image/jpeg', 'image/png', 'image/jpg'])) {
            return response($file_contents)
                ->header('Content-Type', $mail->file_type); // Menampilkan gambar sesuai tipe
        } else {
            return back()->with('error', 'Format file tidak didukung.');
        }
    }

}

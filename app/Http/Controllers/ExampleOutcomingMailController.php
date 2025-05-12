<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExampleOutcomingMail;


class ExampleOutcomingMailController extends Controller
{
    public function previewFile($uuid)
    {
        $mail = ExampleOutcomingMail::where('uuid', $uuid)->firstOrFail();
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
        } elseif (in_array($mail->file_type, ['application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])) {
            // doc = msword, docx = openxmlformats
            return response($file_contents)
                ->header('Content-Type', $mail->file_type)
                ->header('Content-Disposition', 'attachment; filename="' . $mail->name . '"');
        } else {
            return back()->with('error', 'Format file tidak didukung.');
        }
    }
}

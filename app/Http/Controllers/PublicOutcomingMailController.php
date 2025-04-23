<?php

namespace App\Http\Controllers;

use App\Models\OutcomingMail;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class PublicOutcomingMailController extends Controller
{
    public function previewByUuid($uuid)
    {
        $mail = OutcomingMail::where('uuid', $uuid)->firstOrFail();

        $decoded = base64_decode($mail->file); // file sudah otomatis base64 dari accessor

        return response($decoded, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="Surat-' . $mail->reference_number . '.pdf"',
        ]);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class ExampleOutcomingMail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'mail_code',
        'name',
        'type',
        'file',
        'file_type',
    ];

    protected $dates = ['deleted_at'];

    protected function file(): Attribute
    {
        return Attribute::make(
            set: function ($value) {
                if ($value instanceof UploadedFile) {
                    return file_get_contents($value->getRealPath()); // Ambil isi file
                }
                return $value;
            },
            get: fn ($value) => base64_encode($value) // Ubah ke base64 saat ditampilkan
        );
    }

    protected static function booted(): void
    {
        static::creating(function ($mail) {
            $mail->uuid = Str::uuid();
        });
    }
}

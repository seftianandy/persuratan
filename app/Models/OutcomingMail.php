<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;


class OutcomingMail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'sender_id',
        'reciver_id',
        'reference_number',
        'subject',
        'date',
        'implementation_date',
        'description',
        'file',
        'file_type'
    ];

    protected $dates = ['deleted_at'];

    protected $hidden = [
        'qrcode',
    ];

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

    public function sender(): BelongsTo
    {
        return $this->belongsTo(Sender::class, 'sender_id');
    }

    public function reciver(): BelongsTo
    {
        return $this->belongsTo(Reciver::class, 'reciver_id');
    }

    protected static function booted(): void
    {
        static::creating(function ($mail) {
            $mail->uuid = Str::uuid();
        });
    }
}

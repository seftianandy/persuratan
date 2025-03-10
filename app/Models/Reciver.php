<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reciver extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
    ];

    public function incomingMails()
    {
        return $this->hasMany(IncomingMail::class);
    }
}

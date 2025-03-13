<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sender extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'address',
    ];

    protected $dates = ['deleted_at'];

    public function incomingMails()
    {
        return $this->hasMany(IncomingMail::class);
    }
}

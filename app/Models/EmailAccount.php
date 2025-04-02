<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class EmailAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'email', 'imap_server', 'imap_port',
        'smtp_server', 'smtp_port', 'username', 'password', 'use_ssl'
    ];

    // Encrypt password before saving
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Crypt::encryptString($value);
    }

    // Decrypt password when retrieving
    public function getPasswordAttribute($value)
    {
        return Crypt::decryptString($value);
    }
}

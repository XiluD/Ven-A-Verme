<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Admin extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'email',
        'password',
        'api_token',
    ];
    protected $hidden = [
        'password',
        'api_token',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdealistaCards extends Model
{
    use HasFactory;
    protected $fillable = [
        'cardLink',
        'placeLink',
        'cardTitle',
        'cardPrice',
        'cardDetail',
        'cardDescription',
        'cardContact',
        'cardImage',
        'cardType'
    ];
}

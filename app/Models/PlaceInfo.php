<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlaceInfo extends Model
{
    use HasFactory;
    protected $table = 'placeinfo';
    public $timestamps = false;

    protected $fillable = [
        'placeLink',
        'provincia',
        'municipio',
        'linkType',
        'expirationDate'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poble extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'comarca',
        'provincia',
        'descripcio',
        'foto',
        'latitud',
        'longitud',
        'altitud',
        'superficie',
        'poblacio',
        'codi',
        'codiComarca',
        'updated',
    ];
}

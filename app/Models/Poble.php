<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poble extends Model
{
    use HasFactory;
    // Definir los campos que son asignables en masa (mass assignment)
    protected $fillable = [
        'nom',
        'comarca',
        'provincia',
        'descripcio',
        'foto',
        'lagitud',
        'longitud',
        'altitud',
        'superficie',
        'poblacio',
        
    ];
}

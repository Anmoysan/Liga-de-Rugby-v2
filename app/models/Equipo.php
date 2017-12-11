<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipo extends Model {
    protected $table = 'equipo';
    protected $fillable = ['nombre', 'imagen', 'comunidad', 'entrenador', 'liga', 'puntuacion'];
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase Equipo
 *
 * @package App\Models
 */
class Equipo extends Model {
    protected $table = 'equipo';
    protected $fillable = ['nombre', 'imagen', 'comunidad', 'entrenador', 'liga', 'puntuacion'];
}
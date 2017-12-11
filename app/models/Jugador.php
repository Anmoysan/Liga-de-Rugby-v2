<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jugador extends Model {
    protected $table = 'jugador';
    protected $fillable = ['imagen', 'nombre', 'apellido', 'edad', 'altura', 'peso', 'posicion', 'partidos', 'ensayos', 'amarillas', 'rojas', 'equipo'];
}
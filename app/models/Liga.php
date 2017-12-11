<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Liga extends Model {
    protected $table = 'liga';
    protected $fillable = ['nombre', 'imagen', 'max_equipos', 'inicio_liga', 'fin_liga'];
}
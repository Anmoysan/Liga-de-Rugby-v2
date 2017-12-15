<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase Usuario
 *
 * @package App\Models
 */
class Usuario extends Model{

    protected $table = "usuario";
    protected $fillable = ['nombre', 'email', 'password', 'equipos_fav'];

}
<?php
namespace App\Controllers;

use App\Models\Distro;
use App\Models\Equipo;
use App\Models\Jugador;
use App\Models\Liga;

class ApiController
{

    /**
     * @param null $id
     * @return string
     */
    public function getLigas($id = null)
    {
        if (is_null($id)) {
            $ligas = Liga::all();

            header('Content-Type: application/json');
            return json_encode($ligas);
        } else {
            $liga = Liga::find($id);

            header('Content-Type: application/json');
            return json_encode($liga);
        }
    }

    /**
     * @param null $id
     * @return string
     */
    public function getEquipos($id = null)
    {
        if (is_null($id)) {
            $equipos = Equipo::all();

            header('Content-Type: application/json');
            return json_encode($equipos);
        } else {
            $equipo = Equipo::find($id);

            header('Content-Type: application/json');
            return json_encode($equipo);
        }
    }

    /**
     * @param null $id
     * @return string
     */
    public function getJugadores($id = null)
    {
        if (is_null($id)) {
            $jugadores = Jugador::all();

            header('Content-Type: application/json');
            return json_encode($jugadores);
        } else {
            $jugador = Jugador::find($id);

            header('Content-Type: application/json');
            return json_encode($jugador);
        }
    }
}
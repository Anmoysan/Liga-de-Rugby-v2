<?php
namespace App\Controllers;

use App\Models\Distro;
use App\Models\Equipo;
use App\Models\Jugador;
use App\Models\Liga;

class ApiController
{

    /**
     * Ruta raíz [GET] /ligas para la dirección home de la aplicacion
     * En este caso se muestra la lista de ligas
     *
     * @return string - Devuelve todas las ligas
     *
     * Ruta [GET] /ligas/{id} que muestra la página de detalle de la liga
     *
     * @param $id - Código de la liga
     *
     * @return string - Devuelve todos los datos de la liga
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
     * Ruta raíz [GET] /equipos para la dirección home de la aplicacion
     * En este caso se muestra la lista de equipos
     *
     * @return string - Devuelve todos los equipos
     *
     * Ruta [GET] /equipos/{id} que muestra la página de detalle del equipo
     *
     * @param $id - Código del equipo
     *
     * @return string - Devuelve todos los datos del equipo
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
     * Ruta raíz [GET] /jugadores para la dirección home de la aplicacion
     * En este caso se muestra la lista de jugadores
     *
     * @return string - Devuelve todos los jugadores
     *
     * Ruta [GET] /jugadores/{id} que muestra la página de detalle del jugador
     *
     * @param $id - Código del jugador
     *
     * @return string - Devuelve todos los datos del jugador
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
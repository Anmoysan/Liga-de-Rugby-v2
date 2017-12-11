<?php
namespace App\Controllers;

use App\Controllers\Auth\LoginController;
use App\Controllers\Auth\RegistroController;

class HomeController {

    /**
     * Ruta / donde se muestra la página de inicio del proyecto.
     *
     * @return string Render de la página
     */
    public function getIndex(){
        $ligas = new LigasController();

        return $ligas->getIndex();
    }

    public function getSearch(){
        return 'Información de busqueda';
    }

    public function getLogin(){
        $login = new LoginController();

        return $login->getLogin();
    }

    public function postLogin(){
        $login = new LoginController();

        return $login->postLogin();
    }

    public function getRegistro(){
        $registro = new RegistroController();

        return $registro->getRegistro();
    }

    public function postRegistro(){
        $registro = new RegistroController();

        return $registro->postRegistro();
    }

    public function getLogout(){
        $login = new LoginController();

        return $login->getLogout();
    }
}
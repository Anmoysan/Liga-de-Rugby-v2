<?php
namespace App\Controllers;

use App\Controllers\Auth\LoginController;
use App\Controllers\Auth\RegistroController;

class HomeController {

    /**
     * Ruta / donde se muestra la página de inicio del proyecto
     *
     * @return string - Envia a la pagina de ligas
     */
    public function getIndex(){
        $ligas = new LigasController();

        return $ligas->getIndex();
    }

    /**
     * Ruta /search todavia en construccion
     *
     * @return string - Envia a la pagina de busqueda
     */
    public function postIndex(){
        echo "No funcional";
        /*$ligasController = new LigasController();
        $equiposController = new EquiposController();
        $jugadoresController = new JugadoresController();

        setcookie('lastSearch', $_POST['q'], time() + 60);

        $ligas = $ligasController->search($_POST['q']);
        $equipos = $equiposController->search($_POST['q']);
        $jugadores = $jugadoresController->search($_POST['q']);

        $webInfo = [
            'title' => 'Buscador Rugby',
            'h1' => 'Resultados de la búsqueda'
        ];

        return $this->render('search.twig', [
            'ligas' => $ligas,
            'equipos' => $equipos,
            'jugadores' => $jugadores,
            'webInfo' => $webInfo
        ]);*/
    }

    /**
     * Ruta /login donde se puede iniciar sesion con un usuario creado
     *
     * @return string - Envia a la pagina de login
     */
    public function getLogin(){
        $login = new LoginController();

        return $login->getLogin();
    }

    /**
     * Ruta /login donde se puede iniciar sesion con un usuario creado
     *
     * @return null|string - Envia a la pagina de login
     */
    public function postLogin(){
        $login = new LoginController();

        return $login->postLogin();
    }

    /**
     * Ruta /registro donde se puede registrar un usuario
     *
     * @return string - Envia a la pagina de registro
     */
    public function getRegistro(){
        $registro = new RegistroController();

        return $registro->getRegistro();
    }

    /**
     * Ruta /registro donde se puede registrar un usuario
     *
     * @return string - Envia a la pagina de registro
     */
    public function postRegistro(){
        $registro = new RegistroController();

        return $registro->postRegistro();
    }

    /**
     * Permite cerrar la sesion iniciada
     */
    public function getLogout(){
        $login = new LoginController();

        return $login->getLogout();
    }
}
<?php

namespace App\Controllers;

use App\Models\Distro;
use App\Models\Equipo;
use App\Models\Liga;
use Phroute\Phroute\RouteCollector;
use Sirius\Validation\Validator;
use Sirius\Validation\Helper;

class LigasController extends BaseController
{

    /**
     * Ruta [GET] /distros/new que muestra el formulario de añadir una nueva distribución.
     *
     * @return string Render de la web con toda la información.
     */
    public function getNew()
    {

        $errors = array();  // Array donde se guardaran los errores de validación
        $error = false;     // Será true si hay errores de validación.

        $webInfo = [
            'h1' => 'Añadir Liga',
            'submit' => 'Añadir',
            'method' => 'POST'
        ];

        // Se construye un array asociativo $distro con todas sus claves vacías
        $liga = array_fill_keys(["nombre", "imagen", "max_equipos", "inicio_liga", "fin_liga"], "");

        return $this->render('formLiga.twig', [
            'liga' => $liga,
            'errors' => $errors,
            'webInfo' => $webInfo
        ]);
    }

    /**
     * Ruta [POST] /distros/new que procesa la introducción de una nueva distribución.
     *
     * @return string Render de la web con toda la información.
     */
    public function postNew()
    {

        $errors = array();  // Array donde se guardaran los errores de validación

        $webInfo = [
            'h1' => 'Añadir Liga',
            'submit' => 'Añadir',
            'method' => 'POST'
        ];

        if (!empty($_POST)) {
            $validator = new Validator();

            $requiredFieldMessageError = "El {label} es requerido";
            $numberFieldMessageError = "El {label} debe ser un numero entero";
            $rangeEquiposFieldMessageError = "El rango del campo Equipos Maximos es entre 12 y 32";
            $imagenFieldMessageError = "La imagen no es valida o que el formato no es jpg, jpeg, png o gif";

            $validator->add('nombre:Nombre', 'required', [], $requiredFieldMessageError);
            $validator->add('imagen:Imagen', 'required', [], $requiredFieldMessageError);
            //$validator->add('imagen:Imagen', 'File\Image', 'jpg,jpeg,png,gif', $imagenFieldMessageError);
            $validator->add('max_equipos:Equipos Maximos', 'required', [], $requiredFieldMessageError);
            $validator->add('max_equipos:Equipos Maximos', 'Integer', [], $numberFieldMessageError);
            $validator->add('max_equipos', 'between', array('min' => 12, 'max' => 32), $rangeEquiposFieldMessageError);
            $validator->add('inicio_liga:Inicio de la Liga', 'required', [], $requiredFieldMessageError);
            $validator->add('fin_liga:Fin de la Liga', 'required', [], $requiredFieldMessageError);

            // Extraemos los datos enviados por POST
            $liga['nombre'] = htmlspecialchars(trim($_POST['nombre']));
            $liga['imagen'] = htmlspecialchars(trim($_POST['imagen']));
            $liga['max_equipos'] = htmlspecialchars(trim($_POST['max_equipos']));
            $liga['inicio_liga'] = $_POST['inicio_liga'];    // Si no se recibe nada se carga un array vacío
            $liga['fin_liga'] = $_POST['fin_liga'];

            if ($validator->validate($_POST)) {
                if (strpos(strtolower($liga['nombre']), "liga") === false) {
                    $liga['nombre'] = "Liga " . $liga['nombre'];
                }

                $liga['imagen'] = imagenExiste($liga['imagen']);

                $liga = new Liga([
                    'nombre' => $liga['nombre'],
                    'imagen' => $liga['imagen'],
                    'max_equipos' => $liga['max_equipos'],
                    'inicio_liga' => $liga['inicio_liga'],
                    'fin_liga' => $liga['fin_liga']
                ]);

                $liga->save();

                // Si se guarda sin problemas se redirecciona la aplicación a la página de inicio
                header('Location: ' . BASE_URL);
            } else {
                $errors = $validator->getMessages();
            }
        }
        return $this->render('formLiga.twig', [
            'liga' => $liga,
            'errors' => $errors,
            'webInfo' => $webInfo
        ]);
    }

    /**
     * Ruta [GET] /distros/edit/{id} que muestra el formulario de actualización de una nueva distribución.
     *
     * @param id Código de la distribución.
     *
     * @return string Render de la web con toda la información.
     */
    public function getEdit($id)
    {

        $errors = array();  // Array donde se guardaran los errores de validación

        $webInfo = [
            'h1' => 'Actualizar Liga',
            'submit' => 'Actualizar',
            'method' => 'PUT'
        ];

        // Recuperar datos
        $liga = Liga::find($id);

        if (!$liga) {
            header("Location: ligas/$id.twig");
        }

        return $this->render('formLiga.twig', [
            'liga' => $liga,
            'errors' => $errors,
            'webInfo' => $webInfo
        ]);
    }

    /**
     * Ruta [PUT] /distros/edit/{id} que actualiza toda la información de una distribución. Se usa el verbo
     * put porque la actualización se realiza en todos los campos de la base de datos.
     *
     * @param id Código de la distribución.
     *
     * @return string Render de la web con toda la información.
     */
    public function putEdit($id)
    {

        $errors = array();  // Array donde se guardaran los errores de validación

        $webInfo = [
            'h1' => 'Actualizar Liga',
            'submit' => 'Actualizar',
            'method' => 'PUT'
        ];

        if (!empty($_POST)) {
            $validator = new Validator();

            $requiredFieldMessageError = "El {label} es requerido";
            $numberFieldMessageError = "El {label} debe ser un numero entero";
            $rangeEquiposFieldMessageError = "El rango del campo Equipos Maximos es entre 12 y 32";
            $imagenFieldMessageError = "La imagen no es valida o que el formato no es jpg, jpeg, png o gif";

            $validator->add('nombre:Nombre', 'required', [], $requiredFieldMessageError);
            $validator->add('imagen:Imagen', 'required', [], $requiredFieldMessageError);
            //$validator->add('imagen:Imagen', 'File\Image', 'jpg', $imagenFieldMessageError);
            $validator->add('max_equipos:Equipos Maximos', 'required', [], $requiredFieldMessageError);
            $validator->add('max_equipos:Equipos Maximos', 'Integer', [], $numberFieldMessageError);
            //$validator->add('max_equipos:Equipos Maximos', 'between', array('min' => 12, 'max' => 32), $rangeEquiposFieldMessageError);
            $validator->add('inicio_liga:Inicio de la Liga', 'required', [], $requiredFieldMessageError);
            $validator->add('fin_liga:Fin de la Liga', 'required', [], $requiredFieldMessageError);

            // Extraemos los datos enviados por POST
            $liga['id'] = $id;
            $liga['imagen'] = htmlspecialchars(trim($_POST['imagen']));
            $liga['nombre'] = htmlspecialchars(trim($_POST['nombre']));
            $liga['max_equipos'] = htmlspecialchars(trim($_POST['max_equipos']));
            $liga['inicio_liga'] = $_POST['inicio_liga'];    // Si no se recibe nada se carga un array vacío
            $liga['fin_liga'] = $_POST['fin_liga'];

            if ($validator->validate($_POST)) {
                if (strpos(strtolower($liga['nombre']), "liga") === false) {
                    $liga['nombre'] = "Liga " . $liga['nombre'];
                }

                $liga['imagen'] = imagenExiste($liga['imagen']);

                $liga = Liga::where('id', $id)->update([
                    'id' => $liga['id'],
                    'imagen' => $liga['imagen'],
                    'nombre' => $liga['nombre'],
                    'max_equipos' => $liga['max_equipos'],
                    'inicio_liga' => $liga['inicio_liga'],
                    'fin_liga' => $liga['fin_liga']
                ]);
                // Si se guarda sin problemas se redirecciona la aplicación a la página de inicio
                header('Location: ' . BASE_URL);
            } else {
                $errors = $validator->getMessages();
            }
        }
        return $this->render('formLiga.twig', [
            'liga' => $liga,
            'errors' => $errors,
            'webInfo' => $webInfo
        ]);
    }

    /**
     * Ruta raíz [GET] /distros para la dirección home de la aplicación. En este caso se muestra la lista de distribuciones.
     *
     * @return string Render de la web con toda la información.
     *
     * Ruta [GET] /distro/{id} que muestra la página de detalle de la distribución.
     * todo: La vista de detalle está pendiente de implementar.
     *
     * @param id Código de la distribución.
     *
     * @return string Render de la web con toda la información.
     */
    public function getIndex($id = null)
    {
        if (is_null($id)) {
            $webInfo = [
                'title' => 'Página de Inicio - Ligas de Rugby'
            ];

            $ligas = Liga::query()->get();
            //$distros = Distro::all();

            return $this->render('home.twig', [
                'ligas' => $ligas,
                'webInfo' => $webInfo
            ]);

        } else {
            // Recuperar datos

            $webInfo = [
                'title' => 'Liga - Ligas de Rugby'
            ];

            $liga = Liga::find($id);

            if (!$liga) {
                return $this->render('404.twig', ['webInfo' => $webInfo]);
            }

            $equipos = Equipo::where('liga', $liga['nombre'])->get();

            $cantidadEquipos = Equipo::where('liga', $liga['nombre'])->count();

            if ($cantidadEquipos == $liga['max_equipos']) {
                $maximosEquipos = true;
            } else {
                $maximosEquipos = false;
            }

            // Filtro para aplicar a rutas a USUARIOS AUTENTICADOS en el sistema

            $router = new RouteCollector();

            $router->filter('max_equipos', function ($liga, $cont) {
                if ($liga['nombre'] != $cont) {
                    header('Location: ' . BASE_URL);
                    return false;
                }
            });

            $router->group(['before' => 'max_equipos'], function ($router) {
                $router->get('/equipos/new', ['\App\Controllers\EquiposController', 'getNew']);
                $router->post('/equipos/new', ['\App\Controllers\EquiposController', 'postNew']);
            });

            //dameDato($distro);
            return $this->render('liga.twig', [
                'maximosEquipos' => $maximosEquipos,
                'equipos' => $equipos,
                'liga' => $liga,
                'webInfo' => $webInfo]);
        }

    }

    /**
     * Ruta [DELETE] /distros/delete para eliminar la distribución con el código pasado
     */
    public function deleteIndex()
    {
        $id = $_REQUEST['id'];

        $liga = Liga::destroy($id);

        header("Location: " . BASE_URL);
    }
}
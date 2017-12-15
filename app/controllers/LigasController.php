<?php

namespace App\Controllers;

use App\Models\Distro;
use App\Models\Equipo;
use App\Models\Liga;
use Phroute\Phroute\RouteCollector;
use Sirius\Validation\Validator;

class LigasController extends BaseController
{

    /**
     * Ruta [GET] /ligas/new que muestra el formulario de añadir una nueva liga.
     *
     * @return string - Envia al formulario de ligas
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

        // Se construye un array asociativo $liga con todas sus claves vacías
        $liga = array_fill_keys(["nombre", "imagen", "max_equipos", "inicio_liga", "fin_liga"], "");

        return $this->render('formLiga.twig', [
            'liga' => $liga,
            'errors' => $errors,
            'webInfo' => $webInfo
        ]);
    }

    /**
     * Ruta [POST] /ligas/new que procesa la introducción de una nueva liga.
     *
     * @return string - Si se usa el return tiene un error en los datos introducidos y debera arreglarlo
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

            //Mensajes que se muestran si hay algun error con los datos introducidos
            $requiredFieldMessageError = "El {label} es requerido";
            $numberFieldMessageError = "El {label} debe ser un numero entero";
            $rangeEquiposFieldMessageError = "El rango del campo Equipos Maximos es entre 12 y 32";

            //Se comprueba si los datos introducidos son correctos
            $validator->add('nombre:Nombre', 'required', [], $requiredFieldMessageError);
            $validator->add('imagen:Imagen', 'required', [], $requiredFieldMessageError);
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

                //Si el nombre no contiene "liga" la creara
                if (strpos(strtolower($liga['nombre']), "liga") === false) {
                    $liga['nombre'] = "Liga " . $liga['nombre'];
                }

                //Comprueba si la imagen es correcta o no
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
     * Ruta [GET] /ligas/edit/{id} que muestra el formulario de actualización de la liga seleccionada
     *
     * @param $id - Código de la liga
     *
     * @return string - Envia al formulario de ligas
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
     * Ruta [PUT] /ligas/edit/{id} que actualiza toda la información de la liga seleccionada
     * Se usa el verbo put porque la actualización se realiza en todos los campos de la base de datos
     *
     * @param $id - Código de la liga.
     *
     * @return string - Si se usa el return tiene un error en los datos introducidos y debera arreglarlo
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

            //Mensajes que se muestran si hay algun error con los datos introducidos
            $requiredFieldMessageError = "El {label} es requerido";
            $numberFieldMessageError = "El {label} debe ser un numero entero";
            $rangeEquiposFieldMessageError = "El rango del campo Equipos Maximos es entre 12 y 32";

            //Se comprueba si los datos introducidos son correctos
            $validator->add('nombre:Nombre', 'required', [], $requiredFieldMessageError);
            $validator->add('imagen:Imagen', 'required', [], $requiredFieldMessageError);
            $validator->add('max_equipos:Equipos Maximos', 'required', [], $requiredFieldMessageError);
            $validator->add('max_equipos:Equipos Maximos', 'Integer', [], $numberFieldMessageError);
            $validator->add('max_equipos:Equipos Maximos', 'between', array('min' => 12, 'max' => 32), $rangeEquiposFieldMessageError);
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

                //Si el nombre no contiene "liga" la creara
                if (strpos(strtolower($liga['nombre']), "liga") === false) {
                    $liga['nombre'] = "Liga " . $liga['nombre'];
                }

                //Comprueba si la imagen es correcta o no
                $liga['imagen'] = imagenExiste($liga['imagen']);

                $liga = Liga::where('id', $id)->update([
                    'id' => $liga['id'],
                    'imagen' => $liga['imagen'],
                    'nombre' => $liga['nombre'],
                    'max_equipos' => $liga['max_equipos'],
                    'inicio_liga' => $liga['inicio_liga'],
                    'fin_liga' => $liga['fin_liga']
                ]);

                header("Location: /ligas/$id");
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
     * Ruta raíz [GET] /ligas para la dirección home de la aplicación
     * En este caso se muestra la lista de distribuciones
     *
     * @return string - Devuelve todas las ligas
     *
     * Ruta [GET] /ligas/{id} que muestra la página de detalle de la liga
     *
     * @param $id - Código de la liga
     *
     * @return string - Devuelve todos los datos de la liga
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

            //Si la liga con esa id no existe te envia a una pagina de error
            if (!$liga) {
                return $this->render('404.twig', ['webInfo' => $webInfo]);
            }

            //Coge todos los equipos que estan esa liga
            $equipos = Equipo::where('liga', $liga['nombre'])->get();

            //Cantidad de todos los equipos que estan en esa liga
            $cantidadEquipos = Equipo::where('liga', $liga['nombre'])->count();

            if ($cantidadEquipos == $liga['max_equipos']) {
                $maximosEquipos = true;
            } else {
                $maximosEquipos = false;
            }

            // Filtro para evitar crear mas equipos si hay tantos equipos como max_equipos
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

            return $this->render('liga.twig', [
                'maximosEquipos' => $maximosEquipos,
                'equipos' => $equipos,
                'liga' => $liga,
                'webInfo' => $webInfo]);
        }

    }

    /**
     * Ruta [DELETE] /ligas/delete para eliminar a la liga con el código pasado
     */
    public function deleteIndex()
    {
        $id = $_REQUEST['id'];

        $liga = Liga::destroy($id);

        header("Location: " . BASE_URL);
    }

    public function search($q){
        return Liga::where('nombre', 'LIKE', '%'.$q.'%')->get();
    }
}
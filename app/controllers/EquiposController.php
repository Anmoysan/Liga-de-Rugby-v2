<?php
namespace App\Controllers;

use App\Models\Distro;
use App\Models\Equipo;
use App\Models\Jugador;
use Sirius\Validation\Validator;

class EquiposController extends BaseController {

    /**
     * Ruta [GET] /equipos/new que muestra el formulario de añadir un nuevo equipo.
     *
     * @return string - Envia al formulario de equipos
     */
    public function getNew(){
        global $comunidadValues;
        $nombreLiga = $_REQUEST['nombreLiga'];

        $errors = array();  // Array donde se guardaran los errores de validación
        $error = false;     // Será true si hay errores de validación.

        $webInfo = [
            'h1'        => 'Añadir Equipo',
            'submit'    => 'Añadir',
            'method'    => 'POST'
        ];

        // Se construye un array asociativo $distro con todas sus claves vacías
        $equipo = array_fill_keys(['nombre', 'imagen', 'comunidad', 'entrenador', 'puntuacion'], "");

        return $this->render('formEquipo.twig', [
            'nombreLiga' => $nombreLiga,
            'comunidadValues'  => $comunidadValues,
            'equipo'        => $equipo,
            'errors'        => $errors,
            'webInfo'       => $webInfo
        ]);
    }

    /**
     * Ruta [POST] /equipos/new que procesa la introducción de un nuevo equipo.
     *
     * @return string - Si se usa el return tiene un error en los datos introducidos y debera arreglarlo
     */
    public function postNew(){
        global $comunidadValues;
        $nombreLiga = $_REQUEST['nombreLiga'];

        $webInfo = [
            'h1'        => 'Añadir Equipo',
            'submit'    => 'Añadir',
            'method'    => 'POST'
        ];

        if (!empty($_POST)) {
            $validator = new Validator();

            //Mensajes que se muestran si hay algun error con los datos introducidos
            $requiredFieldMessageError = "El {label} es requerido";
            $numberFieldMessageError = "El {label} debe ser un numero entero";
            $rangePuntuacionFieldMessageError = "El rango del campo Puntuacion es entre 0 y 200";

            //Se comprueba si los datos introducidos son correctos
            $validator->add('nombre:Nombre', 'required', [],$requiredFieldMessageError);
            $validator->add('imagen:Imagen', 'required', [], $requiredFieldMessageError);
            $validator->add('comunidad:Comunidad', 'required', [], $requiredFieldMessageError);
            $validator->add('entrenador:Entrenador','required', [],$requiredFieldMessageError);
            $validator->add('puntuacion:Puntuacion','required', [],$requiredFieldMessageError);
            $validator->add('puntuacion:Puntuacion', 'Integer', [], $numberFieldMessageError);
            $validator->add('puntuacion:Puntuacion', 'between', array('min' => 0, 'max' => 200), $rangePuntuacionFieldMessageError);

            // Extraemos los datos enviados por POST
            $equipo['nombre'] = htmlspecialchars(trim($_POST['nombre']));
            $equipo['imagen'] = htmlspecialchars(trim($_POST['imagen']));
            $equipo['comunidad'] = $_POST['comunidad'];
            $equipo['entrenador'] = htmlspecialchars(trim($_POST['entrenador']));
            $equipo['puntuacion'] = htmlspecialchars(trim($_POST['puntuacion']));

            if ( $validator->validate($_POST) ){

                //Si el nombre no contiene "equipo" lo creara
                if (strpos(strtolower($equipo['nombre']), "equipo") === false) {
                    $equipo['nombre'] = "Equipo " . $equipo['nombre'];
                }

                //Comprueba si la imagen es correcta o no
                $equipo['imagen'] = imagenExiste($equipo['imagen']);

                $equipo = new Equipo([
                    'nombre'         => $equipo['nombre'],
                    'imagen'         => $equipo['imagen'],
                    'comunidad'      => $equipo['comunidad'],
                    'entrenador'     => $equipo['entrenador'],
                    'liga'           => $nombreLiga,
                    'puntuacion'     => $equipo['puntuacion']
                ]);

                $equipo->save();

                // Si se guarda sin problemas se redirecciona la aplicación a la página de inicio
                header('Location: ' . BASE_URL);
            }else{
                $errors = $validator->getMessages();
            }
        }
        return $this->render('formEquipo.twig', [
            'nombreLiga' => $nombreLiga,
            'comunidadValues' => $comunidadValues,
            'equipo'        => $equipo,
            'errors'        => $errors,
            'webInfo'       => $webInfo
        ]);
    }

    /**
     * Ruta [GET] /equipos/edit/{id} que muestra el formulario de actualización del equipo seleccionado
     *
     * @param id - Código del equipo
     *
     * @return string - Envia al formulario de equipos
     */
    public function getEdit($id){
        global $comunidadValues;

        $errors = array();  // Array donde se guardaran los errores de validación

        $webInfo = [
            'h1'        => 'Actualizar Equipo',
            'submit'    => 'Actualizar',
            'method'    => 'PUT'
        ];

        // Recuperar datos
        $equipo = Equipo::find($id);

        if( !$equipo ){
            header("Location: equipos/$id.twig");
        }

        return $this->render('formEquipo.twig', [
            'comunidadValues'  => $comunidadValues,
            'equipo'        => $equipo,
            'errors'        => $errors,
            'webInfo'       => $webInfo
        ]);
    }

    /**
     * Ruta [PUT] /equipos/edit/{id} que actualiza toda la información del equipo seleccionado
     * Se usa el verbo put porque la actualización se realiza en todos los campos de la base de datos
     *
     * @param id - Código del equipo
     *
     * @return string - Si se usa el return tiene un error en los datos introducidos y debera arreglarlo
     */
    public function putEdit($id){
        global $comunidadValues;

        $errors = array();  // Array donde se guardaran los errores de validación

        $webInfo = [
            'h1'        => 'Actualizar Equipo',
            'submit'    => 'Actualizar',
            'method'    => 'PUT'
        ];

        if( !empty($_POST)){
            $validator = new Validator();

            //Mensajes que se muestran si hay algun error con los datos introducidos
            $requiredFieldMessageError = "El {label} es requerido";
            $numberFieldMessageError = "El {label} debe ser un numero entero";
            $rangePuntuacionFieldMessageError = "El rango del campo Puntuacion es entre 0 y 200";

            //Se comprueba si los datos introducidos son correctos
            $validator->add('nombre:Nombre', 'required', [],$requiredFieldMessageError);
            $validator->add('imagen:Imagen', 'required', [], $requiredFieldMessageError);
            $validator->add('comunidad:Comunidad', 'required', [], $requiredFieldMessageError);
            $validator->add('entrenador:Entrenador','required', [],$requiredFieldMessageError);
            $validator->add('puntuacion:Puntuacion','required', [],$requiredFieldMessageError);
            $validator->add('puntuacion:Puntuacion', 'Integer', [], $numberFieldMessageError);
            $validator->add('puntuacion:Puntuacion', 'between', array('min' => 0, 'max' => 200), $rangePuntuacionFieldMessageError);

            // Extraemos los datos enviados por POST
            $equipo['nombre'] = htmlspecialchars(trim($_POST['nombre']));
            $equipo['imagen'] = htmlspecialchars(trim($_POST['imagen']));
            $equipo['comunidad'] = $_POST['comunidad'];
            $equipo['entrenador'] = htmlspecialchars(trim($_POST['entrenador']));
            $equipo['puntuacion'] = htmlspecialchars(trim($_POST['puntuacion']));

            if ( $validator->validate($_POST) ){

                //Si el nombre no contiene "equipo" lo creara
                if (strpos(strtolower($equipo['nombre']), "equipo") === false) {
                    $equipo['nombre'] = "Equipo " . $equipo['nombre'];
                }

                //Comprueba si la imagen es correcta o no
                $equipo['imagen'] = imagenExiste($equipo['imagen']);

                $equipo = Equipo::where('id', $id)->update([
                    'nombre'         => $equipo['nombre'],
                    'imagen'         => $equipo['imagen'],
                    'comunidad'      => $equipo['comunidad'],
                    'entrenador'     => $equipo['entrenador'],
                    'puntuacion'     => $equipo['puntuacion']
                ]);

                header('Location: ' . BASE_URL);
            }else{
                $errors = $validator->getMessages();
            }
        }
        return $this->render('formEquipo.twig', [
            'equipo'        => $equipo,
            'errors'        => $errors,
            'webInfo'       => $webInfo
        ]);
    }

    /**
     * Ruta raíz [GET] /equipos para la dirección /ligas/{id} de la aplicacion
     * En este caso se muestra la lista de equipos
     *
     * @return string - Devuelve todos los equipos de una liga
     *
     * Ruta [GET] /equipos/{id} que muestra la página de detalle del equipo
     *
     * @param id - Código del equipo
     *
     * @return string - Devuelve todos los datos del equipo
     */
    public function getIndex($id = null){
        if( is_null($id) ){
            $webInfo = [
                'title' => 'Equipos'
            ];

            $equipos = Equipo::query()->orderBy('puntuacion','asc')->get();
            //$distros = Distro::all();

            return $this->render('liga.twig', [
                'equipos' => $equipos,
                'webInfo' => $webInfo
            ]);

        }else{
            // Recuperar datos

            $webInfo = [
                'title' => 'Equipo'
            ];

            $equipo = Equipo::find($id);

            //Si el jugador con esa id no existe te envia a una pagina de error
            if( !$equipo ){
                return $this->render('404.twig', ['webInfo' => $webInfo]);
            }

            //Coge todos los jugadores que estan ese equipo
            $jugadores = Jugador::where('equipo', $equipo['nombre'])->get();

            return $this->render('equipo.twig', [
                'jugadores' => $jugadores,
                'equipo' => $equipo,
                'webInfo'=> $webInfo]);
        }

    }

    /**
     * Ruta [DELETE] /equipos/delete para eliminar al equipo con el código pasado
     */
    public function deleteIndex(){
        $id = $_REQUEST['id'];

        $equipo = Equipo::destroy($id);

        header("Location: ". BASE_URL);
    }
}
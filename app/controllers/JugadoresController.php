<?php
namespace App\Controllers;

use App\Models\Distro;
use App\Models\Jugador;
use Sirius\Validation\Validator;

class JugadoresController extends BaseController {

    /**
     * Ruta [GET] /jugadores/new que muestra el formulario de añadir un nuevo jugador.
     *
     * @return string - Envia al formulario de ligas
     */
    public function getNew(){
        global $posicionValues;
        $nombreEquipo = $_REQUEST['nombreEquipo'];

        $errors = array();  // Array donde se guardaran los errores de validación
        $error = false;     // Será true si hay errores de validación.

        $webInfo = [
            'h1'        => 'Añadir Jugador',
            'submit'    => 'Añadir',
            'method'    => 'POST'
        ];

        // Se construye un array asociativo $distro con todas sus claves vacías
        $jugador = array_fill_keys(['imagen', 'nombre', 'apellido', 'edad', 'altura', 'peso', 'posicion', 'partidos', 'ensayos', 'amarillas', 'rojas'], "");

        return $this->render('formJugador.twig', [
            'posicionValues'  => $posicionValues,
            'jugador'        => $jugador,
            'errors'        => $errors,
            'webInfo'       => $webInfo
        ]);
    }

    /**
     * Ruta [POST] /jugadores/new que procesa la introducción de un nuevo jugador.
     *
     * @return string - Si se usa el return tiene un error en los datos introducidos y debera arreglarlo
     */
    public function postNew(){
        global $posicionValues;
        $nombreEquipo = $_REQUEST['nombreEquipo'];

        $webInfo = [
            'h1'        => 'Añadir Jugador',
            'submit'    => 'Añadir',
            'method'    => 'POST'
        ];

        if (!empty($_POST)) {
            $validator = new Validator();

            //Mensajes que se muestran si hay algun error con los datos introducidos
            $requiredFieldMessageError = "El {label} es requerido";
            $numberFieldMessageError = "El {label} debe ser un numero";
            $rangeEdadFieldMessageError = "El rango del campo Edad es entre 0 y 115";
            $rangeAlturaFieldMessageError = "El rango del campo Altura es entre 1.30 y 2.30";
            $rangePesoFieldMessageError = "El rango del campo Peso es entre 40 y 300";
            $rangePartidosFieldMessageError = "El rango del campo Partidos es entre 0 y 1000";
            $rangeEnsayosFieldMessageError = "El rango del campo Ensayos es entre 0 y 1000";
            $rangeAmarillasFieldMessageError = "El rango del campo Tarjetas amarillas es entre 0 y 500";
            $rangeRojasFieldMessageError = "El rango del campo Tarjetas rojas es entre 0 y 500";

            //Se comprueba si los datos introducidos son correctos
            $validator->add('imagen:Imagen', 'required',[],$requiredFieldMessageError);
            $validator->add('nombre:Nombre', 'required',[],$requiredFieldMessageError);
            $validator->add('apellido:Apellidos', 'required', [], $requiredFieldMessageError);
            $validator->add('edad:Edad', 'required',[], $requiredFieldMessageError);
            $validator->add('edad:Edad', 'Integer', [], $numberFieldMessageError);
            $validator->add('edad:Edad', 'between', array('min' => 0, 'max' => 115), $rangeEdadFieldMessageError);
            $validator->add('altura:Altura','required',[],$requiredFieldMessageError);
            $validator->add('altura:Altura', 'Number', [], $numberFieldMessageError);
            $validator->add('altura:Altura', 'between', array('min' => 1.30, 'max' => 2.30), $rangeAlturaFieldMessageError);
            $validator->add('peso:Peso','required',[],$requiredFieldMessageError);
            $validator->add('peso:Peso', 'Integer', [], $numberFieldMessageError);
            $validator->add('peso:Peso', 'between', array('min' => 40, 'max' => 300), $rangePesoFieldMessageError);
            $validator->add('posicion:Posicion','required',[],$requiredFieldMessageError);
            $validator->add('partidos:Partidos','required',[],$requiredFieldMessageError);
            $validator->add('partidos:Partidos', 'Number', [], $numberFieldMessageError);
            $validator->add('partidos:Partidos', 'between', array('min' => 0, 'max' => 1000), $rangePartidosFieldMessageError);
            $validator->add('ensayos:Ensayos','required',[],$requiredFieldMessageError);
            $validator->add('ensayos:Ensayos', 'Number', [], $numberFieldMessageError);
            $validator->add('ensayos:Ensayos', 'between', array('min' => 0, 'max' => 1000), $rangeEnsayosFieldMessageError);
            $validator->add('amarillas:Tarjetas amarillas', 'required',[], $requiredFieldMessageError);
            $validator->add('amarillas:Tarjetas amarillas', 'Number', [], $numberFieldMessageError);
            $validator->add('amarillas:Tarjetas amarillas', 'between', array('min' => 0, 'max' => 500), $rangeAmarillasFieldMessageError);
            $validator->add('rojas:Tarjetas rojas','required',[],$requiredFieldMessageError);
            $validator->add('rojas:Tarjetas rojas', 'Number', [], $numberFieldMessageError);
            $validator->add('rojas:Tarjetas rojas', 'between', array('min' => 0, 'max' => 500), $rangeRojasFieldMessageError);

            // Extraemos los datos enviados por POST
            $jugador['imagen'] = htmlspecialchars(trim($_POST['imagen']));
            $jugador['nombre'] = htmlspecialchars(trim($_POST['nombre']));
            $jugador['apellido'] = htmlspecialchars(trim($_POST['apellido']));
            $jugador['edad'] = htmlspecialchars(trim($_POST['edad']));
            $jugador['altura'] = htmlspecialchars(trim($_POST['altura']));
            $jugador['peso'] = htmlspecialchars(trim($_POST['peso']));
            $jugador['posicion'] = $_POST['posicion'];
            $jugador['partidos'] = htmlspecialchars(trim($_POST['partidos']));
            $jugador['ensayos'] = htmlspecialchars(trim($_POST['ensayos']));
            $jugador['amarillas'] = htmlspecialchars(trim($_POST['amarillas']));
            $jugador['rojas'] = htmlspecialchars(trim($_POST['rojas']));

            if ($validator->validate($_POST)) {

                //Comprueba si la imagen es correcta o no
                $jugador['imagen'] = imagenExiste($jugador['imagen']);

                $jugador = new Jugador([
                    'imagen'         => $jugador['imagen'],
                    'nombre'          => $jugador['nombre'],
                    'apellido'        => $jugador['apellido'],
                    'edad'       => $jugador['edad'],
                    'altura'        => $jugador['altura'],
                    'peso'  => $jugador['peso'],
                    'posicion'       => $jugador['posicion'],
                    'partidos'      => $jugador['partidos'],
                    'ensayos'        => $jugador['ensayos'],
                    'amarillas'       => $jugador['amarillas'],
                    'rojas'           => $jugador['rojas'],
                    'equipo'           => $nombreEquipo
                ]);
                $jugador->save();

                // Si se guarda sin problemas se redirecciona la aplicación a la página de inicio
                header('Location: ' . BASE_URL);
            }else{
                $errors = $validator->getMessages();
            }
        }

        return $this->render('formJugador.twig', [
            'posicionValues'  => $posicionValues,
            'jugador'        => $jugador,
            'errors'        => $errors,
            'webInfo'       => $webInfo
        ]);
    }

    /**
     * Ruta [GET] /jugadores/edit/{id} que muestra el formulario de actualización del jugador seleccionado
     *
     * @param id - Código del jugador
     *
     * @return string - Si se usa el return tiene un error en los datos introducidos y debera arreglarlo
     */
    public function getEdit($id){
        global $posicionValues;

        $errors = array();  // Array donde se guardaran los errores de validación

        $webInfo = [
            'h1'        => 'Actualizar Jugador',
            'submit'    => 'Actualizar',
            'method'    => 'PUT'
        ];

        // Recuperar datos
        $jugador = Jugador::find($id);

        if( !$jugador ){
            header("Location: jugadores/$id.twig");
        }

        return $this->render('formJugador.twig',[
            'posicionValues'  => $posicionValues,
            'jugador'        => $jugador,
            'errors'        => $errors,
            'webInfo'       => $webInfo
        ]);
    }

    /**
     * Ruta [PUT] /jugadores/edit/{id} que actualiza toda la información del jugador seleccionado
     * Se usa el verbo put porque la actualización se realiza en todos los campos de la base de datos
     *
     * @param id - Código del jugador
     *
     * @return string - Si se usa el return tiene un error en los datos introducidos y debera arreglarlo
     */
    public function putEdit($id){
        global $posicionValues;

        $errors = array();  // Array donde se guardaran los errores de validación

        $webInfo = [
            'h1'        => 'Actualizar Distro',
            'submit'    => 'Actualizar',
            'method'    => 'PUT'
        ];

        if( !empty($_POST)){
            $validator = new Validator();

            //Mensajes que se muestran si hay algun error con los datos introducidos
            $requiredFieldMessageError = "El {label} es requerido";
            $numberFieldMessageError = "El {label} debe ser un numero";
            $rangeEdadFieldMessageError = "El rango del campo Edad es entre 0 y 115";
            $rangeAlturaFieldMessageError = "El rango del campo Altura es entre 1.30 y 2.30";
            $rangePesoFieldMessageError = "El rango del campo Peso es entre 40 y 300";
            $rangePartidosFieldMessageError = "El rango del campo Partidos es entre 0 y 1000";
            $rangeEnsayosFieldMessageError = "El rango del campo Ensayos es entre 0 y 1000";
            $rangeAmarillasFieldMessageError = "El rango del campo Tarjetas amarillas es entre 0 y 500";
            $rangeRojasFieldMessageError = "El rango del campo Tarjetas rojas es entre 0 y 500";

            //Se comprueba si los datos introducidos son correctos
            $validator->add('imagen:Imagen', 'required',[],$requiredFieldMessageError);
            $validator->add('nombre:Nombre', 'required',[],$requiredFieldMessageError);
            $validator->add('apellido:Apellidos', 'required', [], $requiredFieldMessageError);
            $validator->add('edad:Edad', 'required',[], $requiredFieldMessageError);
            $validator->add('edad:Edad', 'Integer', [], $numberFieldMessageError);
            $validator->add('edad:Edad', 'between', array('min' => 0, 'max' => 115), $rangeEdadFieldMessageError);
            $validator->add('altura:Altura','required',[],$requiredFieldMessageError);
            $validator->add('altura:Altura', 'Number', [], $numberFieldMessageError);
            $validator->add('altura:Altura', 'between', array('min' => 1.30, 'max' => 2.30), $rangeAlturaFieldMessageError);
            $validator->add('peso:Peso','required',[],$requiredFieldMessageError);
            $validator->add('peso:Peso', 'Integer', [], $numberFieldMessageError);
            $validator->add('peso:Peso', 'between', array('min' => 40, 'max' => 300), $rangePesoFieldMessageError);
            $validator->add('posicion:Posicion','required',[],$requiredFieldMessageError);
            $validator->add('partidos:Partidos','required',[],$requiredFieldMessageError);
            $validator->add('partidos:Partidos', 'Number', [], $numberFieldMessageError);
            $validator->add('partidos:Partidos', 'between', array('min' => 0, 'max' => 1000), $rangePartidosFieldMessageError);
            $validator->add('ensayos:Ensayos','required',[],$requiredFieldMessageError);
            $validator->add('ensayos:Ensayos', 'Number', [], $numberFieldMessageError);
            $validator->add('ensayos:Ensayos', 'between', array('min' => 0, 'max' => 1000), $rangeEnsayosFieldMessageError);
            $validator->add('amarillas:Tarjetas amarillas', 'required',[], $requiredFieldMessageError);
            $validator->add('amarillas:Tarjetas amarillas', 'Number', [], $numberFieldMessageError);
            $validator->add('amarillas:Tarjetas amarillas', 'between', array('min' => 0, 'max' => 500), $rangeAmarillasFieldMessageError);
            $validator->add('rojas:Tarjetas rojas','required',[],$requiredFieldMessageError);
            $validator->add('rojas:Tarjetas rojas', 'Number', [], $numberFieldMessageError);
            $validator->add('rojas:Tarjetas rojas', 'between', array('min' => 0, 'max' => 500), $rangeRojasFieldMessageError);

            // Extraemos los datos enviados por POST
            $jugador['imagen'] = htmlspecialchars(trim($_POST['imagen']));
            $jugador['nombre'] = htmlspecialchars(trim($_POST['nombre']));
            $jugador['apellido'] = htmlspecialchars(trim($_POST['apellido']));
            $jugador['edad'] = htmlspecialchars(trim($_POST['edad']));
            $jugador['altura'] = htmlspecialchars(trim($_POST['altura']));
            $jugador['peso'] = htmlspecialchars(trim($_POST['peso']));
            $jugador['posicion'] = $_POST['posicion'];
            $jugador['partidos'] = htmlspecialchars(trim($_POST['partidos']));
            $jugador['ensayos'] = htmlspecialchars(trim($_POST['ensayos']));
            $jugador['amarillas'] = htmlspecialchars(trim($_POST['amarillas']));
            $jugador['rojas'] = htmlspecialchars(trim($_POST['rojas']));

            if ($validator->validate($_POST)) {

                //Comprueba si la imagen es correcta o no
                $jugador['imagen'] = imagenExiste($jugador['imagen']);

                $jugador = Jugador::where('id', $id)->update([
                    'imagen'         => $jugador['imagen'],
                    'nombre'          => $jugador['nombre'],
                    'apellido'        => $jugador['apellido'],
                    'edad'       => $jugador['edad'],
                    'altura'        => $jugador['altura'],
                    'peso'  => $jugador['peso'],
                    'posicion'       => $jugador['posicion'],
                    'partidos'      => $jugador['partidos'],
                    'ensayos'        => $jugador['ensayos'],
                    'amarillas'       => $jugador['amarillas'],
                    'rojas'           => $jugador['rojas']
                ]);

                header('Location: ' . BASE_URL);
            }else{
                $errors = $validator->getMessages();
            }
        }
        return $this->render('formJugador.twig', [
            'posicionValues'  => $posicionValues,
            'jugador'        => $jugador,
            'errors'        => $errors,
            'webInfo'       => $webInfo
        ]);
    }

    /**
     * Ruta raíz [GET] /jugadores para la dirección /equipos/{id} de la aplicacion
     * En este caso se muestra la lista de jugadores
     *
     * @return string - Devuelve todos los jugadores de un equipo
     *
     * Ruta [GET] /jugadores/{id} que muestra la página de detalle del jugador
     *
     * @param id - Código del jugador
     *
     * @return string - Devuelve todos los datos del jugador
     */
    public function getIndex($id = null){
        if( is_null($id) ){
            $webInfo = [
                'title' => 'Jugadores'
            ];

            $jugador = Jugador::query()->orderBy('id','desc')->get();

            return $this->render('home.twig', [
                'jugador' => $jugador,
                'webInfo' => $webInfo
            ]);

        }else{
            // Recuperar datos

            $webInfo = [
                'title' => 'Jugador'
            ];

            $jugador = Jugador::find($id);

            //Si el jugador con esa id no existe te envia a una pagina de error
            if( !$jugador ){
                return $this->render('404.twig', ['webInfo' => $webInfo]);
            }

            return $this->render('jugador.twig', [
                'jugador' => $jugador,
                'webInfo'=> $webInfo]);
        }

    }

    /**
     * Ruta [DELETE] /jugadores/delete para eliminar al jugador con el código pasado
     */
    public function deleteIndex(){
        $id = $_REQUEST['id'];

        $jugador = Jugador::destroy($id);

        header("Location: ". BASE_URL);
    }
}
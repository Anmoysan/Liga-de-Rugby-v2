<?php
namespace App\Controllers;

use App\Models\Distro;
use App\Models\Jugador;
use Sirius\Validation\Validator;

class JugadoresController extends BaseController {

    /**
     * Ruta [GET] /distros/new que muestra el formulario de añadir una nueva distribución.
     *
     * @return string Render de la web con toda la información.
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
     * Ruta [POST] /distros/new que procesa la introducción de una nueva distribución.
     *
     * @return string Render de la web con toda la información.
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

            $requiredFieldMessageError = "El {label} es requerido";
            $numberFieldMessageError = "El {label} debe ser un numero";
            $imagenFieldMessageError = "La imagen no es valida o que el formato no es jpg, jpeg, png o gif";
            $rangeEdadFieldMessageError = "El rango del campo Edad es entre 0 y 115";
            $rangeAlturaFieldMessageError = "El rango del campo Altura es entre 1.30 y 2.30";
            $rangePesoFieldMessageError = "El rango del campo Peso es entre 40 y 300";
            $rangePartidosFieldMessageError = "El rango del campo Partidos es entre 0 y 1000";
            $rangeEnsayosFieldMessageError = "El rango del campo Ensayos es entre 0 y 1000";
            $rangeAmarillasFieldMessageError = "El rango del campo Tarjetas amarillas es entre 0 y 500";
            $rangeRojasFieldMessageError = "El rango del campo Tarjetas rojas es entre 0 y 500";

            $validator->add('imagen:Imagen', 'required',[],$requiredFieldMessageError);
            //$validator->add('imagen:Imagen', 'File\Image', 'jpg,jpeg,png,gif', $imagenFieldMessageError);
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
     * Ruta [GET] /distros/edit/{id} que muestra el formulario de actualización de una nueva distribución.
     *
     * @param id Código de la distribución.
     *
     * @return string Render de la web con toda la información.
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
     * Ruta [PUT] /distros/edit/{id} que actualiza toda la información de una distribución. Se usa el verbo
     * put porque la actualización se realiza en todos los campos de la base de datos.
     *
     * @param id Código de la distribución.
     *
     * @return string Render de la web con toda la información.
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

            $requiredFieldMessageError = "El {label} es requerido";
            $numberFieldMessageError = "El {label} debe ser un numero";
            $imagenFieldMessageError = "La imagen no es valida o que el formato no es jpg, jpeg, png o gif";
            $rangeEdadFieldMessageError = "El rango del campo Edad es entre 0 y 115";
            $rangeAlturaFieldMessageError = "El rango del campo Altura es entre 1.30 y 2.30";
            $rangePesoFieldMessageError = "El rango del campo Peso es entre 40 y 300";
            $rangePartidosFieldMessageError = "El rango del campo Partidos es entre 0 y 1000";
            $rangeEnsayosFieldMessageError = "El rango del campo Ensayos es entre 0 y 1000";
            $rangeAmarillasFieldMessageError = "El rango del campo Tarjetas amarillas es entre 0 y 500";
            $rangeRojasFieldMessageError = "El rango del campo Tarjetas rojas es entre 0 y 500";

            $validator->add('imagen:Imagen', 'required',[],$requiredFieldMessageError);
            //$validator->add('imagen:Imagen', 'File\Image', 'jpg,jpeg,png,gif', $imagenFieldMessageError);
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
    public function getIndex($id = null){
        if( is_null($id) ){
            $webInfo = [
                'title' => 'Jugadores'
            ];

            $jugador = Jugador::query()->orderBy('id','desc')->get();
            //$distros = Distro::all();

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

            if( !$jugador ){
                return $this->render('404.twig', ['webInfo' => $webInfo]);
            }

            //dameDato($distro);
            return $this->render('jugador.twig', [
                'jugador' => $jugador,
                'webInfo'=> $webInfo]);
        }

    }

    /**
     * Ruta [DELETE] /distros/delete para eliminar la distribución con el código pasado
     */
    public function deleteIndex(){
        $id = $_REQUEST['id'];

        $jugador = Jugador::destroy($id);

        header("Location: ". BASE_URL);
    }
}
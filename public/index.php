<?php
require_once '../vendor/autoload.php';

use Phroute\Phroute\RouteCollector;
use Illuminate\Database\Capsule\Manager as Capsule;

// Punto de entrada a la aplicación
require_once '../arrays.php';
require_once '../helpers.php';


session_start();

$baseDir = str_replace(
    basename($_SERVER['SCRIPT_NAME']),
    '',
    $_SERVER['SCRIPT_NAME']);

$baseUrl = "http://" . $_SERVER['HTTP_HOST'] . $baseDir;
define('BASE_URL', $baseUrl);

if(file_exists(__DIR__.'/../env')){
    $dotenv = new Dotenv\Dotenv(__DIR__.'/..', 'env');
    $dotenv->load();
}


// Instancia de Eloquent
$capsule = new Capsule;
$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => getenv('DB_HOST'),
    'database'  => getenv('DB_NAME'),
    'username'  => getenv('DB_USER'),
    'password'  => getenv('DB_PASS'),
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$route = $_GET['route'] ?? "/";

$router = new RouteCollector();


// Filtro para aplicar a rutas a USUARIOS AUTENTICADOS en el sistema
$router->filter('auth', function(){
    if(!isset($_SESSION['userId'])){
        header('Location: '. BASE_URL);
        return false;
    }
});

$router->group(['before' => 'auth'], function ($router){
    $router->get('/ligas/new', ['\App\Controllers\LigasController', 'getNew']);
    $router->post('/ligas/new', ['\App\Controllers\LigasController', 'postNew']);
    $router->get('/ligas/edit/{id}', ['\App\Controllers\LigasController', 'getEdit']);
    $router->put('/ligas/edit/{id}', ['\App\Controllers\LigasController', 'putEdit']);
    $router->delete('/ligas/', ['\App\Controllers\LigasController', 'deleteIndex']);

    $router->get('/equipos/new', ['\App\Controllers\EquiposController', 'getNew']);
    $router->post('/equipos/new', ['\App\Controllers\EquiposController', 'postNew']);
    $router->get('/equipos/edit/{id}', ['\App\Controllers\EquiposController', 'getEdit']);
    $router->put('/equipos/edit/{id}', ['\App\Controllers\EquiposController', 'putEdit']);
    $router->delete('/equipos/', ['\App\Controllers\EquiposController', 'deleteIndex']);

    $router->get('/jugadores/new', ['\App\Controllers\JugadoresController', 'getNew']);
    $router->post('/jugadores/new', ['\App\Controllers\JugadoresController', 'postNew']);
    $router->get('/jugadores/edit/{id}', ['\App\Controllers\JugadoresController', 'getEdit']);
    $router->put('/jugadores/edit/{id}', ['\App\Controllers\JugadoresController', 'putEdit']);
    $router->delete('/jugadores/', ['\App\Controllers\JugadoresController', 'deleteIndex']);

    $router->get('/logout', ['\App\Controllers\HomeController', 'getLogout']);
});

// Filtro para aplicar a rutas a USUARIOS NO AUTENTICADOS en el sistema
$router->filter('noAuth', function(){
    if( isset($_SESSION['userId'])){
        header('Location: '. BASE_URL);
        return false;
    }
});

$router->group(['before' => 'noAuth'], function ($router){
    $router->get('/login', ['\App\Controllers\HomeController', 'getLogin']);
    $router->post('/login', ['\App\Controllers\HomeController', 'postLogin']);
    $router->get('/registro', ['\App\Controllers\HomeController', 'getRegistro']);
    $router->post('/registro', ['\App\Controllers\HomeController', 'postRegistro']);
});

// Rutas sin filtros
$router->get('/',['\App\Controllers\HomeController', 'getIndex']);
$router->post('/',['\App\Controllers\HomeController', 'postIndex']);
$router->get('/ligas/{id}', ['\App\Controllers\LigasController', 'getIndex']);
$router->post('/ligas/{id}', ['\App\Controllers\LigasController', 'postIndex']);

$router->get('/equipos/{id}', ['\App\Controllers\EquiposController', 'getIndex']);
$router->post('/equipos/{id}', ['\App\Controllers\EquiposController', 'postIndex']);

$router->get('/jugadores/{id}', ['\App\Controllers\JugadoresController', 'getIndex']);
$router->post('/jugadores/{id}', ['\App\Controllers\JugadoresController', 'postIndex']);

$router->controller('/api', App\Controllers\ApiController::class);

$dispatcher = new Phroute\Phroute\Dispatcher($router->getData());

$method = $_REQUEST['_method'] ?? $_SERVER['REQUEST_METHOD'];

$response = $dispatcher->dispatch($method, $route);

// Print out the value returned from the dispatched function
echo $response;
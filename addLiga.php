<?php
include_once 'config.php';
include_once 'connect_db.php';
include_once 'helpers.php';

$errors = array();  // Array donde se guardaran los errores de validación
$error = false;     // Será true si hay errores de validación.

// Se construye un array asociativo $distro con todas sus claves vacías
$liga = array_fill_keys(["nombre"], "");

if( !empty($_POST)){
    // Extraemos los datos enviados por POST
    $liga['nombre'] = htmlspecialchars(trim($_POST['name']));

    if( $liga['nombre'] == "" ){
        $errors['nombre']['required'] = "El campo nombre es requerido";
    }

    if ( empty($errors) ){
        //dameDato($distro);
        // Si no tengo errores de validación
        // Guardo en la BD
        $sql = "INSERT INTO liga (nombre) VALUES (:nombre)";

        $result = $pdo->prepare($sql);

        $result->execute([
            'nombre'          => $liga['nombre']
        ]);

        // Si se guarda sin problemas se redirecciona la aplicación a la página de inicio
        header('Location: index.php');
    }else{
        // Si tengo errores de validación
        $error = true;
    }
}

$error = !empty($errors)?true:false;

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/app.css">

    <title>Liga de Rugby</title>
</head>

<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
            </button>
            <a class="navbar-brand" href="index.php">Inicio</a><span class="navbar-brand"> | </span>
            <a class="navbar-brand  btn btn-primary btn-lg active" href="addLiga.php">Añadir Liga</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <?php if ($user=="manolo"): ?>
                    <li><a href="login.php">Inicie Sesion</a></li>
                <?php else: ?>
                    <li><a href="login.php"><?=$user?></a></li>
                <?php endif?>
            </ul>
            <form class="navbar-form navbar-right">
                <input type="text" class="form-control" placeholder="Search...">
            </form>
        </div>
    </div>
</nav>

<div class="container">
    <h1>Añadir nueva Liga</h1>
    <form action="" method="post">
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Nombre Liga">
        </div>
        <button type="submit" class="btn btn-default">Enviar</button>
    </form>
</div>
</body>
</html>
<?php
include_once 'config.php';
include_once 'connect_db.php';
include_once 'helpers.php';
include_once 'arrays.php';

$id = $_REQUEST['id'];
$idliga = $_REQUEST['idliga'];

$sql = "SELECT * from liga WHERE id = :id LIMIT 1";
$result = $pdo->prepare($sql);
$result->execute([
    'id' => $idliga
]);

/*while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $liga = $row['nombre'];
}*/

$errors = array();  // Array donde se guardaran los errores de validación
$error = false;     // Será true si hay errores de validación.

// Se construye un array asociativo $distro con todas sus claves vacías
$equipo = array_fill_keys(["nombre", "imagen", "comunidad", "entrenador", "puntuacion"], "");

if (!empty($_POST)) {
    // Extraemos los datos enviados por POST
    $equipo['nombre'] = htmlspecialchars(trim($_POST['nombre']));
    $equipo['imagen'] = htmlspecialchars(trim($_POST['imagen']));
    $equipo['comunidad'] = htmlspecialchars(trim($_POST['comunidad']));
    $equipo['entrenador'] = htmlspecialchars(trim($_POST['entrenador']));
    $equipo['puntuacion'] = htmlspecialchars(trim($_POST['puntuacion']));

    if ($equipo['nombre'] == "") {
        $errors['nombre']['required'] = "El campo nombre es requerido";
    }

    if ($equipo['imagen'] == "") {
        $errors['imagen']['required'] = "El campo imagen es requerido";
    }

    if (empty($equipo['comunidad'])) {
        $errors['comunidad']['required'] = "El campo comunidad debe tener al menos una opción seleccionada";
    }

    if ($equipo['entrenador'] == "") {
        $errors['entrenador']['required'] = "El campo entrenador es requerido";
    }

    if ($equipo['puntuacion'] == "") {
        $errors['puntuacion']['required'] = "El campo puntuacion es requerido";
    }

    if (!is_numeric($equipo['puntuacion']) && $equipo['puntuacion'] != "") {
        $errors['puntuacion']['numeric'] = "El campo puntuacion no es numero";
    }

    if (empty($errors)) {
        // Si no tengo errores de validación
        // Guardo en la BD
        $sql = "UPDATE equipo SET nombre = :nombre, imagen = :imagen, comunidad = :comunidad, entrenador = :entrenador, liga = :liga, puntuacion = :puntuacion WHERE id = :id LIMIT 1";

        $result = $pdo->prepare($sql);

        $result->execute([
            'id' => $id,
            'nombre' => $equipo['nombre'],
            'imagen' => $equipo['imagen'],
            'comunidad' => $equipo['comunidad'],
            'entrenador' => $equipo['entrenador'],
            'liga' => $liga,
            'puntuacion' => $equipo['puntuacion']
        ]);

        // Si se guarda sin problemas se redirecciona la aplicación a la página de inicio
        header("Location: equipo.php?id=$id&idliga=$idliga");
    } else {
        // Si tengo errores de validación
        $error = true;
    }
}

$error = !empty($errors) ? true : false;

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="css/app.css">

    <title>Liga de Rugby</title>
</head>

<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
            </button>
            <a class="navbar-brand" href="index.php">Inicio</a><span class="navbar-brand"> | </span>
            <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
                <? $liga = $row['nombre'] ?>
                <a class="navbar-brand" href="liga.php?id=<?= $row['id'] ?>">Liga</a><span class="navbar-brand"> | </span>
                <a class="navbar-brand" href="equipo.php?id=<?= $id ?>&idliga=<?= $row['id'] ?>">Equipo</a><span class="navbar-brand"> | </span>
                <a class="navbar-brand btn btn-primary btn-lg active" href="addEquipo.php?id=<?= $row['id'] ?>">Modificar Equipo</a>
            <?php endwhile; ?>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <?php if ($user == "manolo"): ?>
                    <li><a href="login.php">Inicie Sesion</a></li>
                <?php else: ?>
                    <li><a href="login.php"><?= $user ?></a></li>
                <?php endif ?>
            </ul>
            <form class="navbar-form navbar-right">
                <input type="text" class="form-control" placeholder="Search...">
            </form>
        </div>
    </div>
</nav>

<div class="container">
    <h1>Modificar Equipo</h1>
    <form action="" method="post">
        <div class="form-group<?php echo(isset($errors['nombre']['required']) ? " has-error" : ""); ?>">
            <label for="name">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre Equipo"
                   value="<?= $equipo['nombre'] ?>">
        </div>
        <?= generarAlert($errors, 'nombre') ?>

        <div class="form-group<?php echo(isset($errors['imagen']['required']) ? " has-error" : ""); ?>">
            <label for="imagen">Imagen</label>
            <input type="text" class="form-control" id="imagen" name="imagen" placeholder="Imagen Equipo"
                   value="<?= $equipo['imagen'] ?>">
        </div>
        <?= generarAlert($errors, 'imagen') ?>

        <div class="form-group<?php echo(isset($errors['comunidad']['required']) ? " has-error" : ""); ?>">
            <label for="comunidad">Comunidad</label>
            <?= generarSelect($comunidadValues, $equipo['comunidad'], "comunidad"); ?>
        </div>
        <?= generarAlert($errors, 'comunidad') ?>

        <div class="form-group<?php echo(isset($errors['entrenador']['required']) ? " has-error" : ""); ?>">
            <label for="entrenador">Entrenador</label>
            <input type="text" class="form-control" id="entrenador" name="entrenador" placeholder="Nombre Entrenador"
                   value="<?= $equipo['entrenador'] ?>">
        </div>
        <?= generarAlert($errors, 'entrenador') ?>

        <div class="form-group<?php echo(isset($errors['puntuacion']['required']) ? " has-error" : ""); ?>">
            <label for="puntuacion">Puntuacion</label>
            <input type="text" class="form-control" id="puntuacion" name="puntuacion" placeholder="Nombre Puntuacion"
                   value="<?= $equipo['puntuacion'] ?>">
        </div>
        <?= generarAlert($errors, 'puntuacion') ?>

        <button type="submit" class="btn btn-default">Enviar</button>
    </form>
</div>
</body>
</html>
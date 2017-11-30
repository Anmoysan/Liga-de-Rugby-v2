<?php
include_once 'config.php';
include_once 'connect_db.php';
include_once 'helpers.php';
include_once 'arrays.php';

$id = $_REQUEST['id'];

$sqlLiga = "SELECT liga.* from liga, equipo WHERE equipo.id = :id AND equipo.liga = liga.nombre LIMIT 1";
$resultLiga = $pdo->prepare($sqlLiga);
$resultLiga->execute([
    'id' => $id
]);

$sql = "SELECT * from equipo WHERE id = :id LIMIT 1";
$result = $pdo->prepare($sql);
$result->execute([
    'id' => $id
]);

$equipo = $result->fetch(PDO::FETCH_ASSOC);

$errors = array();  // Array donde se guardaran los errores de validación
$error = false;     // Será true si hay errores de validación.

// Se construye un array asociativo $distro con todas sus claves vacías
$jugador = array_fill_keys(["imagen", "nombre", "apellido", "edad", "altura", "peso", "posicion", "partidos", "ensayos", "amarillas", "rojas"], "");

if (!empty($_POST)) {
    // Extraemos los datos enviados por POST
    $jugador['imagen'] = htmlspecialchars(trim($_POST['imagen']));
    $jugador['nombre'] = htmlspecialchars(trim($_POST['nombre']));
    $jugador['apellido'] = htmlspecialchars(trim($_POST['apellido']));
    $jugador['edad'] = htmlspecialchars(trim($_POST['edad']));
    $jugador['altura'] = htmlspecialchars(trim($_POST['altura']));
    $jugador['peso'] = htmlspecialchars(trim($_POST['peso']));
    $jugador['posicion'] = htmlspecialchars(trim($_POST['posicion']));
    $jugador['partidos'] = htmlspecialchars(trim($_POST['partidos']));
    $jugador['ensayos'] = htmlspecialchars(trim($_POST['ensayos']));
    $jugador['amarillas'] = htmlspecialchars(trim($_POST['amarillas']));
    $jugador['rojas'] = htmlspecialchars(trim($_POST['rojas']));

    if ($jugador['imagen'] == "" || !file_exists($jugador['imagen'])) {
        $jugador['imagen'] = "imagenes/sinimagen.jpg";
    }

    if ($jugador['nombre'] == "") {
        $errors['nombre']['required'] = "El campo nombre es requerido";
    }

    if ($jugador['apellido'] == "") {
        $errors['apellido']['required'] = "El campo apellidos es requerido";
    }

    if (!is_numeric($jugador['edad'])) {
        $errors['edad']['numeric'] = "El campo edad no es numero";
    }

    if ($jugador['edad'] == "") {
        $errors['edad']['required'] = "El campo edad es requerido";
    }

    if (!is_numeric($jugador['altura'])) {
        $errors['altura']['numeric'] = "El campo altura no es numero";
    }

    if ($jugador['altura'] == "") {
        $errors['altura']['required'] = "El campo altura es requerido";
    }

    if (!is_numeric($jugador['peso'])) {
        $errors['peso']['numeric'] = "El campo peso no es numero";
    }

    if ($jugador['peso'] == "") {
        $errors['peso']['required'] = "El campo peso es requerido";
    }

    if (empty($jugador['posicion'])) {
        $errors['posicion']['required'] = "El campo posicion debe tener al menos una opción seleccionada";
    }

    if (!is_numeric($jugador['partidos'])) {
        $errors['partidos']['numeric'] = "El campo partidos no es numero";
    }

    if ($jugador['partidos'] == "") {
        $errors['partidos']['required'] = "El campo partidos es requerido";
    }

    if (!is_numeric($jugador['ensayos'])) {
        $errors['ensayos']['numeric'] = "El campo ensayos no es numero";
    }

    if ($jugador['ensayos'] == "") {
        $errors['ensayos']['required'] = "El campo ensayos es requerido";
    }

    if (!is_numeric($jugador['amarillas'])) {
        $errors['amarillas']['numeric'] = "El campo amarillas no es numero";
    }

    if ($jugador['amarillas'] == "") {
        $errors['amarillas']['required'] = "El campo amarillas es requerido";
    }

    if (!is_numeric($jugador['rojas'])) {
        $errors['rojas']['numeric'] = "El campo rojas no es numero";
    }

    if ($jugador['rojas'] == "") {
        $errors['rojas']['required'] = "El campo rojas es requerido";
    }


    if (empty($errors)) {
        // Si no tengo errores de validación
        // Guardo en la BD
        $sql = "INSERT INTO jugador (imagen, nombre, apellido, edad, altura, peso, posicion, partidos, ensayos, amarillas, rojas, equipo) VALUES (:imagen, :nombre, :apellido, :edad, :altura, :peso, :posicion, :partidos, :ensayos, :amarillas, :rojas, :equipo)";

        $result = $pdo->prepare($sql);

        $result->execute([
            'imagen' => $jugador['imagen'],
            'nombre' => $jugador['nombre'],
            'apellido' => $jugador['apellido'],
            'edad' => $jugador['edad'],
            'altura' => $jugador['altura'],
            'peso' => $jugador['peso'],
            'posicion' => $jugador['posicion'],
            'partidos' => $jugador['partidos'],
            'ensayos' => $jugador['ensayos'],
            'amarillas' => $jugador['amarillas'],
            'rojas' => $jugador['rojas'],
            'equipo' => $equipo['nombre']
        ]);

        // Si se guarda sin problemas se redirecciona la aplicación a la página de inicio
        header("Location: equipo.php?id=$id");
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
            <?php while ($rowLiga = $resultLiga->fetch(PDO::FETCH_ASSOC)): ?>
                <a class="navbar-brand" href="liga.php?id=<?= $rowLiga['id'] ?>">Liga</a><span class="navbar-brand"> | </span>
            <?php endwhile; ?>
                <a class="navbar-brand" href="equipo.php?id=<?= $equipo['id'] ?>">Equipo</a><span
                        class="navbar-brand"> | </span>
                <a class="navbar-brand btn btn-primary btn-lg active" href="addJugador.php?id=<?= $equipo['id'] ?>">Añadir
                    Jugador</a>
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
    <h1>Añadir nuevo Jugador</h1>
    <form action="" method="post">
        <div class="form-group<?php echo(isset($errors['imagen']['required']) ? " has-error" : ""); ?>">
            <label for="imagen">Foto</label>
            <input type="text" class="form-control" id="imagen" name="imagen" placeholder="Foto Jugador"
                   value="<?= $jugador['imagen'] ?>">
        </div>
        <?= generarAlert($errors, 'imagen') ?>

        <div class="form-group<?php echo(isset($errors['nombre']['required']) ? " has-error" : ""); ?>">
            <label for="name">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre Jugador"
                   value="<?= $jugador['nombre'] ?>">
        </div>
        <?= generarAlert($errors, 'nombre') ?>

        <div class="form-group<?php echo(isset($errors['apellido']['required']) ? " has-error" : ""); ?>">
            <label for="apellido">Apellidos</label>
            <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellidos Jugador"
                   value="<?= $jugador['apellido'] ?>">
        </div>
        <?= generarAlert($errors, 'apellido') ?>

        <div class="form-group<?php echo(isset($errors['edad']['required']) ? " has-error" : ""); ?>">
            <label for="edad">Edad</label>
            <input type="text" class="form-control" id="edad" name="edad" placeholder="Edad Jugador"
                   value="<?= $jugador['edad'] ?>">
        </div>
        <?= generarAlert($errors, 'edad') ?>

        <div class="form-group<?php echo(isset($errors['altura']['required']) ? " has-error" : ""); ?>">
            <label for="altura">Altura</label>
            <input type="text" class="form-control" id="altura" name="altura" placeholder="Altura Jugador"
                   value="<?= $jugador['altura'] ?>">
        </div>
        <?= generarAlert($errors, 'altura') ?>

        <div class="form-group<?php echo(isset($errors['peso']['required']) ? " has-error" : ""); ?>">
            <label for="peso">Peso</label>
            <input type="text" class="form-control" id="peso" name="peso" placeholder="Peso Jugador"
                   value="<?= $jugador['peso'] ?>">
        </div>
        <?= generarAlert($errors, 'peso') ?>

        <div class="form-group<?php echo(isset($errors['posicion']['required']) ? " has-error" : ""); ?>">
            <label for="posicion">Posicion</label>
            <?= generarSelect($posicionValues, $jugador['posicion'], "posicion"); ?>
        </div>
        <?= generarAlert($errors, 'posicion') ?>

        <div class="form-group<?php echo(isset($errors['partidos']['required']) ? " has-error" : ""); ?>">
            <label for="partidos">Partidos jugados</label>
            <input type="text" class="form-control" id="partidos" name="partidos" placeholder="Partidos jugados Jugador"
                   value="<?= $jugador['partidos'] ?>">
        </div>
        <?= generarAlert($errors, 'partidos') ?>

        <div class="form-group<?php echo(isset($errors['ensayos']['required']) ? " has-error" : ""); ?>">
            <label for="ensayos">Ensayos conseguidos</label>
            <input type="text" class="form-control" id="ensayos" name="ensayos" placeholder="Ensayos conseguidos Jugador"
                   value="<?= $jugador['ensayos'] ?>">
        </div>
        <?= generarAlert($errors, 'ensayos') ?>

        <div class="form-group<?php echo(isset($errors['amarillas']['required']) ? " has-error" : ""); ?>">
            <label for="amarillas">Amarillas tenidas</label>
            <input type="text" class="form-control" id="amarillas" name="amarillas" placeholder="Amarillas tenidas Jugador"
                   value="<?= $jugador['amarillas'] ?>">
        </div>
        <?= generarAlert($errors, 'amarillas') ?>

        <div class="form-group<?php echo(isset($errors['rojas']['required']) ? " has-error" : ""); ?>">
            <label for="rojas">Rojas tenidas</label>
            <input type="text" class="form-control" id="rojas" name="rojas" placeholder="Rojas tenidas Jugador"
                   value="<?= $jugador['rojas'] ?>">
        </div>
        <?= generarAlert($errors, 'rojas') ?>

        <button type="submit" class="btn btn-default">Enviar</button>
    </form>
</div>
</body>
</html>
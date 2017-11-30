<?php
include_once 'config.php';
include_once 'connect_db.php';
include_once 'helpers.php';
include_once 'arrays.php';

$id = $_REQUEST['id'];

$sqlJugador = "SELECT jugador.* from jugador, equipo WHERE equipo.id =:id AND equipo.nombre=jugador.equipo";
$resultJugador = $pdo->prepare($sqlJugador);
$resultJugador->execute([
    'id' => $id
]);

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

?>
<html lang="es">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="css/app.css">

    <title>Liga de Rugby</title>
</head>

<body>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
            </button>
            <a class="navbar-brand" href="index.php">Inicio</a><span class="navbar-brand"> | </span>
            <?php while ($rowLiga = $resultLiga->fetch(PDO::FETCH_ASSOC)): ?>
            <a class="navbar-brand" href="liga.php?id=<?= $rowLiga['id'] ?>">Liga</a><span class="navbar-brand"> | </span>
            <a class="navbar-brand btn btn-primary btn-lg active" href="equipo.php?id=<?= $row['id'] ?>">Equipo</a><span class="navbar-brand"> | </span>
            <a class="navbar-brand" href="addJugador.php?id=<?= $row['id'] ?>">Añadir Jugador</a>


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
    <div class="col-sm-2 col-md-2">
        <img src="<?= $row["imagen"] ?>" alt="No se ha podido encontrar la imagen">
    </div>
    <div class="col-sm-8 col-md-8">
        <h1><?= $row['nombre'] ?></h1>
    </div>
    <div class="col-sm-1 col-md-1 botonesUtiles">
        <span>Modificar Equipo</span>
        <a href="updateEquipo.php?id=<?= $row['id'] ?>" class="editar"><span
                    class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
    </div>
    <div class="col-sm-1 col-md-1 botonesUtiles">
        <span>Eliminar Equipo</span>
        <a href="deleteEquipo.php?id=<?= $row['id'] ?>" class="borrar"><span
                    class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
    </div>
    <div id="tabla">
        <div>
            <div class="col-sm-5  col-md-5">
                <p>Comunidad: <?= $row['comunidad'] ?></p>
                <p>Enternador: <?= $row['entrenador'] ?></p>
            </div>
            <div class="col-sm-5  col-md-5">
                <p>Liga: <?= $rowLiga['nombre'] ?></p>
                <?php endwhile; ?>
                <p>Puntuacion: <?= $row['puntuacion'] ?></p>
            </div>
        </div><br>
        <table class="table table-striped">

            <thead>
            <tr>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Posicion</th>
                <th>Partidos</th>
                <th>Media de Ensayos</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($rowJugador = $resultJugador->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td>
                    <a href="jugador.php?id=<?= $rowJugador['id'] ?>"><img src="<?= $rowJugador['imagen'] ?>"></a>
                </td>
                <td>
                    <a href="jugador.php?id=<?= $rowJugador['id'] ?>"><?= $rowJugador['nombre'] . " " . $rowJugador['apellido'] ?></a>
                </td>
                <td><?= $rowJugador['posicion'] ?></td>
                <td><?= $rowJugador['partidos'] ?></td>
                <td><?= $rowJugador['partidos'] / $rowJugador['ensayos'] ?></td>
            </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <?php endwhile; ?>
</div><!-- /.container -->
</body>
</html>
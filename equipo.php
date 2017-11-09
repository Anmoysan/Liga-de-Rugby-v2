<?php
include_once 'config.php';
include_once 'connect_db.php';
include_once 'helpers.php';
include_once 'arrays.php';

$id = $_REQUEST['id'];
$idliga = $_REQUEST['idliga'];

$sqlLiga = "SELECT * from liga WHERE id = :id LIMIT 1";
$resultLiga = $pdo->prepare($sqlLiga);
$resultLiga->execute([
    'id' => $idliga
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
            <a class="navbar-brand" href="liga.php?id=<?= $rowLiga['id'] ?>">Liga</a><span
                    class="navbar-brand"> | </span>
            <a class="navbar-brand btn btn-primary btn-lg active"
               href="equipo.php?id=<?= $row['id'] ?>&idliga=<?= $rowLiga['id'] ?>">Equipo</a>

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
    <div class="col-sm-3 col-md-3">
        <h1><?= $row['nombre'] ?></h1>
    </div>
    <div class="col-sm-7 col-md-7">
        <img src="<?= $row["imagen"] ?>" alt="No se ha podido encontrar la imagen">
    </div>
    <div class="col-sm-1 col-md-1 botonesUtiles">
        <a href="updateEquipo.php?id=<?= $row['id'] ?>&idliga=<?= $rowLiga['id'] ?>" class="editar"><span
                    class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
    </div>
    <div class="col-sm-1 col-md-1 botonesUtiles">
        <a href="deleteEquipo.php?id=<?= $row['id'] ?>&idliga=<?= $rowLiga['id'] ?>" class="borrar"><span
                    class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
    </div>
    <div>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Comunidad</th>
                <th>Entrenador</th>
                <th>Liga</th>
                <th>Puntuacion</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><?= $row['comunidad'] ?></td>
                <td><?= $row['entrenador'] ?></td>
                <td><?= $rowLiga['nombre'] ?></td>
                <?php endwhile; ?>
                <td><?= $row['puntuacion'] ?></td>
            </tr>
            </tbody>
        </table>
    </div>
    <?php endwhile; ?>
</div><!-- /.container -->
</body>
</html>
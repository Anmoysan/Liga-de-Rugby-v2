<?php
include_once 'config.php';
include_once 'connect_db.php';
include_once 'helpers.php';

$queryResult = $pdo->query("SELECT * from liga ORDER BY id ASC");

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
            <a class="navbar-brand btn btn-primary btn-lg active" href="index.php">Inicio</a><span class="navbar-brand"> | </span>
            <a class="navbar-brand" href="addLiga.php">Añadir Liga</a>
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
    <h1>Ligas de Rugby</h1>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Nombre</th>
        </tr>
        </thead>
        <tbody>
        <?php while( $row = $queryResult->fetch(PDO::FETCH_ASSOC) ): ?>
            <tr>
                <td><a href="liga.php?id=<?=$row['id']?>"><?=$row['nombre']?></a></td>
            </tr>
        <?php endwhile; ?>

        </tbody>
    </table>
</div><!-- /.container -->
</body>
</html>
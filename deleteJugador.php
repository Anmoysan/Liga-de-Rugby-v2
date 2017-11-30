<?php

include_once 'config.php';
include_once 'connect_db.php';
include_once 'helpers.php';

$id = $_REQUEST['id'];

$sqlEquipo = "SELECT equipo.* from equipo, jugador WHERE jugador.id =:id AND jugador.equipo=equipo.nombre";
$resultEquipo = $pdo->prepare($sqlEquipo);
$resultEquipo->execute([
    'id' => $id
]);

$equipo = $resultEquipo->fetch(PDO::FETCH_ASSOC);

$sql = "DELETE FROM jugador WHERE id = :id";
$result = $pdo->prepare($sql);
$result->execute(['id' => $id]);



echo $equipo["id"];

header("Location: equipo.php?id=".$equipo["id"]);
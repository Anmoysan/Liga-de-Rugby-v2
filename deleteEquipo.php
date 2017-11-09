<?php

include_once 'config.php';
include_once 'connect_db.php';
include_once 'helpers.php';

$id = $_REQUEST['id'];
$idliga = $_REQUEST['idliga'];

$sql = "DELETE FROM equipo WHERE id = :id";
$result = $pdo->prepare($sql);
$result->execute(['id' => $id]);

header("Location: liga.php?id=$idliga");
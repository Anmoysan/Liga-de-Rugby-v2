<?php

function getLiga($id, $pdo){
    $sql = "SELECT * FROM liga WHERE id = :id";
    $result = $pdo->prepare($sql);

    $result->execute([ 'id' => $id]);

    return $result->fetch(PDO::FETCH_ASSOC);
}

function getEquipo($id, $pdo){
    $sql = "SELECT * FROM equipo WHERE id = :id";
    $result = $pdo->prepare($sql);

    $result->execute([ 'id' => $id]);

    return $result->fetch(PDO::FETCH_ASSOC);
}

function getJugador($id, $pdo){
    $sql = "SELECT * FROM jugador WHERE id = :id";
    $result = $pdo->prepare($sql);

    $result->execute([ 'id' => $id]);

    return $result->fetch(PDO::FETCH_ASSOC);
}
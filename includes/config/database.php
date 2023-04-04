<?php


function conectarDB() : mysqli {
    $db = mysqli_connect('localhost', 'root', '', 'bienesraices_crud', 3306);
    if (!$db) {
        echo "Error en la conexión";
        exit;
    }

    return $db;
}
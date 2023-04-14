<?php


function conectarDB() : mysqli {
    $db = new  mysqli('localhost', 'root', '', 'bienesraices_crud', 3306);
    if (!$db) {
        echo "Error en la conexión";
        exit;
    }

    return $db;
}
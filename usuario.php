<?php
 //Importar la conexion a la base de datos
 require 'includes/config/database.php';
 $db = conectarDB();

 //Crear un email y password
 $email = "correo@correo.com";
 $password = "123456";
 $passwordHash = password_hash($password, PASSWORD_BCRYPT);

 //Consulta para crear el usuario
$query = " INSERT INTO usuarios (email, password) VALUES ('$email', '$passwordHash'); ";


 //Insertarlo en la base  de datos
 mysqli_query($db, $query);
<?php

    //obteniendo id para cargar el anuncio
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if (!$id) {
        header('Location: /');
    }

    //Importando la base de datos
    require 'includes/config/database.php';
    $db = conectarDB();

    //Consultar la base de datos
    $query = " SELECT * FROM propiedades WHERE id = $id ";

    //Obtener resultado (solo 1)
    $resultado = mysqli_query($db, $query);

    if (!$resultado->num_rows) {
        header('Location: /');
    }

    $row = mysqli_fetch_assoc($resultado);


    require 'includes/funciones.php';
    incluirTemplate('header');
 ?>
    

    <main class="contenedor seccion contenido-centrado">
        <h1><?=$row['titulo'];?></h1>

        <img loading="lazy" src="imagenes/<?=$row['imagen'];?>">

        <div class="resumen-propiedad">
            <p class="precio">$ <?=$row['precio'];?></p>
            <ul class="iconos-caracteristicas">
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
                    <p><?=$row['wc'];?></p>
                </li>
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                    <p><?=$row['estacionamiento'];?></p>
                </li>
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono habitaciones">
                    <p><?=$row['habitaciones'];?></p>
                </li>
            </ul>
            <p>
            <?=$row['descripcion'];?>
            </p>
        </div>
    </main>

<?php 
    //Cerrar la conexion a la base de datos
    mysqli_close($db);

    incluirTemplate('footer');
?>
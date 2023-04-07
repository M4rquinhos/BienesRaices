<?php

    //imoprtar conexion a la basde de datos
    require '../includes/config/database.php';
    $db = conectarDB();

    //Escribir el query
    $query = "SELECT * FROM propiedades";

    //Consultar la basde de datos
    $resultadoConsulta = mysqli_query($db, $query);

    //muestra mensaje condicional (creacion de una nueva propiedad)
    $resultado = $_GET['resultado'] ?? null;

    //incluye el template que se le indica
    require '../includes/funciones.php';
    incluirTemplate('header');
 ?>

    <main class="contenedor seccion">
        <h1>Administrador de Bienes Raices</h1>

        <?php if( intval($resultado) === 1): ?>
            <p class="alerta exito">Anuncio Creado correctamente</p>
        <?php elseif(intval($resultado) === 2): ?>
            <p class="alerta exito">Anuncio Actualizado Correctamente</p>
        <?php endif; ?>

        <a href="/admin/propiedades/crear.php" class="boton boton-verde">Nueva propiedad</a>


        <table class="propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titulo</th>
                    <th>Imagen</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody> <!-- Mostrar los resultados de la base de datos -->
            <?php while( $row = mysqli_fetch_assoc($resultadoConsulta) ): ?>
                <tr>
                    <td><?=$row['id'];?></td>
                    <td><?=$row['titulo'];?></td>
                    <td> <img src="/imagenes/<?=$row['imagen'];?>"  class="imagen-tabla"> </td>
                    <td>$ <?=$row['precio'];?></td>
                    <td>
                        <a href="#" class="boton-rojo-block">Eliminar</a>
                        <a href="/admin/propiedades/actualizar.php?id=<?=$row['id'];?>" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </main>

<?php 

    //cerrar la conexion a la base de datos
    mysqli_close($db);


    incluirTemplate('footer');
?>   
<?php 
    //importar la base de datos
    $db = conectarDB();

    //consultar
    $query = "SELECT * FROM propiedades LIMIT $limite"; 

    //obtener el resultado
    $resultado =  mysqli_query($db, $query);

?>

<div class="contenedor-anuncios">
    <?php while ($row = mysqli_fetch_assoc($resultado)): ?>         
    <div class="anuncio">
        <img loading="lazy" src="/imagenes/<?=$row['imagen']?>">

        <div class="contenido-anuncio">

            <h3><?=$row['titulo']?></h3>
            <p><?=$row['descripcion']?></p>
            <p class="precio">$ <?=$row['precio']?></p>

            <ul class="iconos-caracteristicas">
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
                    <p><?=$row['wc']?></p>
                </li>
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                    <p><?=$row['estacionamiento']?></p>
                </li>
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono habitaciones">
                    <p><?=$row['habitaciones']?></p>
                </li>
            </ul>

            <a href="anuncio.php?id=<?=$row['id'];?>" class="boton-amarillo-block">
                Ver Propiedad
            </a>

        </div> <!-- .contendio-anuncio -->
    </div> <!-- .anuncio -->
    <?php endwhile; ?>    
            
</div> <!-- .contenedor-anuncios -->

<?php
    //cerrar la conexion
    mysqli_close($db);
?>
<?php
    require 'includes/funciones.php';
    incluirTemplate('header');
 ?>
    

    <main class="contenedor seccion contenido-centrado">
        <h1>Casa en Venta frente al bosque</h1>

        <picture>
            <source srcset="build/img/destacada.webp" type="image/webp">
            <source srcset="build/img/destacada.jpg" type="image/jpeg">
            <img loading="lazy" src="build/img/destacada.jpg" alt="imagen de la Propiedad" srcset="">
        </picture>

        <div class="resumen-propiedad">
            <p class="precio">$3,000,000</p>
            <ul class="iconos-caracteristicas">
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
                    <p>3</p>
                </li>
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                    <p>3</p>
                </li>
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono habitaciones">
                    <p>4</p>
                </li>
            </ul>

            <p>
                Eu exercitation veniam duis ullamco deserunt amet fugiat proident sunt enim. Sunt sit do sit cillum sunt ipsum irure. 
                Ipsum fugiat ex anim aliqua reprehenderit mollit veniam. Sit occaecat commodo non aliqua laboris quis amet amet non id 
                exercitation dolore enim. Officia officia excepteur mollit nisi ea non. Aliquip ut tempor sint ea proident et velit.
                Eu exercitation veniam duis ullamco deserunt amet fugiat proident sunt enim. Sunt sit do sit cillum sunt ipsum irure. 
                Ipsum fugiat ex anim aliqua reprehenderit mollit veniam. Sit occaecat commodo non aliqua laboris quis amet amet non id 
                exercitation dolore enim. Officia officia excepteur mollit nisi ea non. Aliquip ut tempor sint ea proident et velit.
            </p>

            <p>
                Eu exercitation veniam duis ullamco deserunt amet fugiat proident sunt enim. Sunt sit do sit cillum sunt ipsum irure. 
                Ipsum fugiat ex anim aliqua reprehenderit mollit veniam. Sit occaecat commodo non aliqua laboris quis amet amet non id 
                exercitation dolore enim. Officia officia excepteur mollit nisi ea non. Aliquip ut tempor sint ea proident et velit.
            </p>
        </div>
    </main>

<?php 
    incluirTemplate('footer');
?>
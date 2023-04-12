<?php
    require 'includes/app.php';
    incluirTemplate('header');
 ?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Guía para la decoracion de tu hogar</h1>

        <picture>
            <source srcset="build/img/destacada2.webp" type="image/webp">
            <source srcset="build/img/destacada2.jpg" type="image/jpeg">
            <img loading="lazy" src="build/img/destacada2.jpg" alt="imagen de la Propiedad" srcset="">
        </picture>

        <p class="informacion-meta">Escrito el: <span>20/10/2023</span> por: <span>Admin</span> </p>

        <div class="resumen-propiedad">
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
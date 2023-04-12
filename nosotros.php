<?php
    require 'includes/app.php';
    incluirTemplate('header');
 ?>  

    <main class="contenedor seccion">
        <h1>Conoce Sobre Nosotros</h1>
        <div class="contenido-nosotros">
            <div class="imagen">
                <picture>
                    <source srcset="build/img/nosotros.webp" type="image/webp">
                    <source srcset="build/img/nosotros.jpg" type="image/jpeg">
                    <img src="build/img/nosotros.webp" alt="imagen pagina nosotros" srcset="">
                </picture>
            </div>

            <div class="texto-nosotros">
                <blockquote>25 años de experiencia</blockquote>

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
        </div>
    </main>

    <section class="contenedor seccion">
        <h1>Más Sobre Nosotros</h1>

        <div class="iconos-nosotros">
            <div class="icono">
                <img src="build/img/icono1.svg" alt="icono seguridad" loading="lazy">
                <h3>Seguridad</h3>
                <p>	Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sequi eligendi ducimus perferendis dolorem expedita 
                    excepturi consequatur quasi tenetur, amet nobis minima eius quae ea numquam dolores vitae optio laborum! Eaque, natus. 
                    Minima animi ab, blanditiis provident a odio tenetur. Incidunt unde ullam veritatis ex! Illo qui quae quam dicta eos.</p>
            </div>
            <div class="icono">
                <img src="build/img/icono2.svg" alt="icono precio" loading="lazy">
                <h3>Precio</h3>
                <p>	Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sequi eligendi ducimus perferendis dolorem expedita 
                    excepturi consequatur quasi tenetur, amet nobis minima eius quae ea numquam dolores vitae optio laborum! Eaque, natus. 
                    Minima animi ab, blanditiis provident a odio tenetur. Incidunt unde ullam veritatis ex! Illo qui quae quam dicta eos.</p>
            </div>
            <div class="icono">
                <img src="build/img/icono3.svg" alt="icono tiempo" loading="lazy">
                <h3>Tiempo</h3>
                <p>	Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sequi eligendi ducimus perferendis dolorem expedita 
                    excepturi consequatur quasi tenetur, amet nobis minima eius quae ea numquam dolores vitae optio laborum! Eaque, natus. 
                    Minima animi ab, blanditiis provident a odio tenetur. Incidunt unde ullam veritatis ex! Illo qui quae quam dicta eos.</p>
            </div>
        </div>

    </section>

<?php 
    incluirTemplate('footer');
?>   
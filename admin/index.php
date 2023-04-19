<?php
    require '../includes/app.php';
    estaAutenticado();

    use App\Propiedad;

    //implementar un metodo para obtener todas las propiedades 
    $propiedades = Propiedad::all();

    //muestra mensaje condicional (creacion de una nueva propiedad)
    $resultado = $_GET['resultado'] ?? null;


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        
        if($id) {
            //Eliminar el archivo
            $query = " SELECT imagen FROM propiedades WHERE id = $id ";
            $resultado = mysqli_query($db, $query);
            $propiedad = mysqli_fetch_assoc($resultado);
            unlink('../imagenes/' . $propiedad['imagen']);

            //Eliminar la propiedad
            $query = " DELETE FROM propiedades WHERE id = $id ";
            $resultado = mysqli_query($db, $query);

            if ($resultado) {
                header('Location: /admin?resultado=3');
            }
        }
    }


    //incluye el template que se le indica
    incluirTemplate('header');
 ?>

    <main class="contenedor seccion">
        <h1>Administrador de Bienes Raices</h1>

        <?php if( intval($resultado) === 1): ?>
            <p class="alerta exito">Anuncio Creado correctamente</p>
        <?php elseif(intval($resultado) === 2): ?>
            <p class="alerta exito">Anuncio Actualizado Correctamente</p>
        <?php elseif(intval($resultado) === 3): ?>
            <p class="alerta exito">Anuncio Eliminado Correctamente</p>
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
            <?php foreach( $propiedades as $propiedad ): ?>
                <tr>
                    <td><?=$propiedad->id;?></td>
                    <td><?=$propiedad->titulo;?></td>
                    <td> <img src="/imagenes/<?=$propiedad->imagen;?>"  class="imagen-tabla"> </td>
                    <td>$ <?=$propiedad->precio;?></td>
                    <td>
                        <form method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?=$propiedad->id;?>">
                            <input type="submit" value="Eliminar" class="boton-rojo-block">
                        </form>
                        <a href="/admin/propiedades/actualizar.php?id=<?=$propiedad->id;?>" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </main>

<?php 

    //cerrar la conexion a la base de datos
    mysqli_close($db);


    incluirTemplate('footer');
?>   
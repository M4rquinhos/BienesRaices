<?php
    require '../includes/app.php';
    estaAutenticado();

    // Importar clases
    use App\Propiedad;
    use App\Vendedor;

    //implementar un metodo para obtener todas las propiedades 
    $propiedades = Propiedad::all();
    $vendedores = Vendedor::all();

    //muestra mensaje condicional (creacion de una nueva propiedad)
    $resultado = $_GET['resultado'] ?? null;


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //Validar Id
        $id = $_POST['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        
        if($id) {

            $tipo = $_POST['tipo'];
            
            if (validarTipoContenido($tipo)) {
                //comprar lo que vamos a eliminar
                if($tipo === 'vendedor') {
                    $vendedor = Vendedor::find($id);
                    $vendedor->eliminar();
                } elseif ($tipo === 'propiedad') {
                    $propiedad = Propiedad::find($id);
                    $propiedad->eliminar();
                }
            }
        }
    }


    //incluye el template que se le indica
    incluirTemplate('header');
 ?>

    <main class="contenedor seccion">
        <h1>Administrador de Bienes Raices</h1>

        <?php $mensaje = mostrarNotificacion(intval($resultado)); 
            if($mensaje): ?>
            <p class="alerta exito"><?=s($mensaje);?></p>
        <?php endif;?>
        
        

        <a href="/admin/propiedades/crear.php" class="boton boton-verde">Nueva propiedad</a>
        <a href="/admin/vendedores/crear.php" class="boton boton-amarillo">Nuevo vendedor</a>


        <h2>Propiedades</h2>
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
                            <input type="hidden" name="tipo" value="propiedad">
                            <input type="submit" value="Eliminar" class="boton-rojo-block">
                        </form>
                        <a href="/admin/propiedades/actualizar.php?id=<?=$propiedad->id;?>" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Vendedores</h2>
        <table class="propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Telefono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody> <!-- Mostrar los resultados de la base de datos -->
            <?php foreach( $vendedores as $vendedor ): ?>
                <tr>
                    <td><?=$vendedor->id;?></td>
                    <td><?=$vendedor->nombre . " " . $vendedor->apellido;?></td>
                    <td><?=$vendedor->telefono;?></td>
                    <td>
                        <form method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?=$vendedor->id;?>">
                            <input type="hidden" name="tipo" value="vendedor">
                            <input type="submit" value="Eliminar" class="boton-rojo-block">
                        </form>
                        <a href="/admin/vendedores/actualizar.php?id=<?=$vendedor->id;?>" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        

    </main>

<?php 
    incluirTemplate('footer');
?>   
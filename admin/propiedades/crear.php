<?php
    require '../../includes/app.php';

    use App\Propiedad;
    use Intervention\Image\ImageManagerStatic as Image;

    estaAutenticado();

    //base de datos 
    $db = conectarDB();

    //Consultar para obtener los vendedores 
    $consulta = "SELECT * FROM vendedores";
    $resultadoVendedores = mysqli_query($db, $consulta);


    //arreglo con mensajes de errores 
    $errores = Propiedad::getErrores();
    

    //variables 
    $titulo = '';
    $precio = '';
    $descripcion = '';
    $habitaciones = '';
    $wc = '';
    $estacionamiento = '';
    $vendedorId = '';
    

    //Ejecuta el codigo despues de que el usuario envia el formulario
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Crear una nueva instancia (Propiedad)
        $propiedad = new Propiedad($_POST);


        /** 
         * Subida de archivos
         */

        //Generar nombre un nombre unico
        $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";

        // Setear la imagen (asignar)
        if ($_FILES['imagen']['tmp_name']) {
             //Realiza un resize a la imagen con intervetion
            $image = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 600);
            $propiedad->setImagen($nombreImagen);
        }
              

        //Validar datos de $_POST
        $errores = $propiedad->validar();

        //revisar que el arreglo este vacio para insertar
        if (empty($errores)) {

            // Crear carpeta para subir imagenes
            if (!is_dir(CARPETA_IMAGENES)) {
                mkdir(CARPETA_IMAGENES);
            }

            //Guarda la imagen el servidor
            $image->save(CARPETA_IMAGENES . $nombreImagen);

            //Guarda en la base de datos
            $propiedad->guardar();

            //mensaje de exito o error
            if ($resultado) {
                //redireccion al usuario
                header('Location: /admin?resultado=1');
            }
        }

        
    }

    incluirTemplate('header');
 ?>

    <main class="contenedor seccion">
        <h1>Crear</h1>

        <a href="/admin/index.php" class="boton boton-verde">Volver</a>

        <?php foreach ($errores as $error): ?>
            <div class="alerta error">
                <?=$error?>
            </div>
        <?php endforeach; ?>

        <form class="formulario" method="POST" action="/admin/propiedades/crear.php" enctype="multipart/form-data">

            <fieldset>
                <legend>Información General</legend>

                <label for="titulo">Titulo:</label>
                <input type="text" id="titulo" name="titulo" placeholder="Titulo propiedad" value="<?=$titulo;?>">

                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" placeholder="Precio propiedad" value="<?=$precio;?>">

                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" name="imagen" accept="image/jpeg, image/png">

                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion"><?=$descripcion;?></textarea>
            </fieldset>

            <fieldset>
                <legend>Información de la propiedad</legend>

                <label for="habitaciones">Habitaciones:</label>
                <input type="number" id="habitaciones" name="habitaciones" min="1" max="9" value="<?=$habitaciones;?>">

                <label for="wc">Baños:</label>
                <input type="number" id="wc" name="wc"  min="1" max="9" value="<?=$wc;?>">

                <label for="estacionamiento">Estacionamiento:</label>
                <input type="number" id="estacionamiento" name="estacionamiento" min="1" max="9" value="<?=$estacionamiento;?>">
            </fieldset>

            <fieldset>
                <legend>Vendedor</legend>

                <select name="vendedorId">
                    <option value="">--Seleccione--</option>
                    <?php while( $row = mysqli_fetch_assoc( $resultadoVendedores ) ): ?>
                        <option <?= $vendedorId === $row['id'] ? 'selected' : ''; ?> value="<?= $row['id']; ?>"> <?= $row['nombre'] . " " . $row['apellido']; ?> </option>
                    <?php endwhile; ?>
                </select>
            </fieldset>

            <input type="submit" value="Crear Propiedad" class="boton boton-verde">
        </form>
    </main>

<?php 
    incluirTemplate('footer');
?>   
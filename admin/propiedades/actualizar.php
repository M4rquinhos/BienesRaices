<?php
    require '../../includes/app.php';

    $auth = estaAutenticado();
    if (!$auth) {
        header('Location: /');
    }

    // Validar la URL por ID valido
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if (!$id) {
        header('Location: /admin');
    }

    //base de datos 
    $db = conectarDB();

    //Consulta para obetner los datos de la propiedad (ACTUALIZAR)
    $consulta = "SELECT * FROM propiedades WHERE id = $id";
    $resultado = mysqli_query($db, $consulta);
    $propiedad = mysqli_fetch_assoc($resultado);

    
    //Consultar para obtener los vendedores 
    $consulta = "SELECT * FROM vendedores";
    $resultadoVendedores = mysqli_query($db, $consulta);


    //arreglo con mensajes de errores 
    $errores = [];

    //variables 
    $titulo = $propiedad['titulo'];
    $precio = $propiedad['precio'];
    $descripcion = $propiedad['descripcion'];
    $habitaciones = $propiedad['habitaciones'];
    $wc = $propiedad['wc'];
    $estacionamiento = $propiedad['estacionamiento'];
    $vendedorid = $propiedad['vendedores_id'];
    $imagenPropiedad = $propiedad['imagen'];
    

    //Ejecuta el codigo despues de que el usuario envia el formulario
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        echo "<pre>";
        echo    var_dump($_POST);
        echo "</pre>";

        // echo "<pre>";
        // echo    var_dump($_FILES);
        // echo "</pre>";


        // Sanitizar entrada de datos para evitar SQL Injection o cross side scripting
        $titulo = mysqli_real_escape_string($db, $_POST['titulo']);
        $precio = mysqli_real_escape_string($db, $_POST['precio']);
        $descripcion = mysqli_real_escape_string($db, $_POST['descripcion']);
        $habitaciones = mysqli_real_escape_string($db, $_POST['habitaciones']);
        $wc = mysqli_real_escape_string($db, $_POST['wc']);
        $estacionamiento = mysqli_real_escape_string($db, $_POST['estacionamiento']);
        $vendedorid = mysqli_real_escape_string($db, $_POST['vendedor']);
        $creado = date('y-m-d');

        //asignar files hacia una variable
        $imagen = $_FILES['imagen'];


        if (!$titulo) {
            $errores[] = "Debes añadir un titulo";
        }

        if (!$precio) {
            $errores[] = "El precio es obligatorio";
        }

        if (strlen( $descripcion ) < 50) {
            $errores[] = "La descripcion es obligatoria y debe tener al menos 50 caracteres";
        }

        if (!$habitaciones) {
            $errores[] = "El numero de habitaciones es obligatorio";
        }

        if (!$wc) {
            $errores[] = "El numero de baños es obligatorio";
        }

        if (!$estacionamiento) {
            $errores[] = "El numero de estacionamientos es obligatorio";
        }

        if (!$vendedorid) {
            $errores[] = "Elige un vendedor";
        }
 
        //Validar imagen por tamaño (200kb máximo)
        $medida = 1000 * 200;
        if ($imagen['size'] > $medida) {
            $errores[] = "La imagen es muy pesada";
        }

        //revisar que el arreglo este vacio para insertar
        if (empty($errores)) {

            /** 
             * Subida de archivos
             */


            //crear carpeta
            $carpetaImagenes = '../../imagenes/';

            if (!is_dir($carpetaImagenes)) {
                mkdir($carpetaImagenes);
            }


            $nombreImagen = '';


            // Verficando si hay una nueva imagen
            if ($imagen['name']) {
                //Eliminar la imagen previa en caso de que se actualice la imagen
                unlink($carpetaImagenes . $propiedad['imagen']);

                //Generar nombre un nombre unico
                $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";

                //subir imagen
                move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);
            } else {
                $nombreImagen = $propiedad['imagen'];
            }



            //Update a la base de datos
            $query = " UPDATE propiedades SET titulo = '$titulo', precio = '$precio', imagen = '$nombreImagen', descripcion = '$descripcion', habitaciones = $habitaciones,
            wc = $wc, estacionamiento = $estacionamiento, vendedores_id = $vendedorid WHERE id = $id";

            // echo $query;

            $resultado = mysqli_query($db, $query);

            if ($resultado) {
                //redireccion al usuario
                header('Location: /admin?resultado=2');
            }
        }

        
    }


    incluirTemplate('header');
 ?>

    <main class="contenedor seccion">
        <h1>Actualizar propiedad</h1>

        <a href="/admin" class="boton boton-verde">Volver</a>

        <?php foreach ($errores as $error): ?>
            <div class="alerta error">
                <?=$error?>
            </div>
        <?php endforeach; ?>

        <form class="formulario" method="POST"  enctype="multipart/form-data">

            <fieldset>
                <legend>Información General</legend>

                <label for="titulo">Titulo:</label>
                <input type="text" id="titulo" name="titulo" placeholder="Titulo propiedad" value="<?=$titulo;?>">

                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" placeholder="Precio propiedad" value="<?=$precio;?>">

                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" name="imagen" accept="image/jpeg, image/png">

                <img src="/imagenes/<?=$imagenPropiedad;?>" class="imagen-small">

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

                <select name="vendedor">
                    <option value="">--Seleccione--</option>
                    <?php while( $row = mysqli_fetch_assoc( $resultadoVendedores ) ): ?>
                        <option <?= $vendedorid === $row['id'] ? 'selected' : ''; ?> value="<?= $row['id']; ?>"> <?= $row['nombre'] . " " . $row['apellido']; ?> </option>
                    <?php endwhile; ?>
                </select>
            </fieldset>

            <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">
        </form>
    </main>

<?php 
    incluirTemplate('footer');
?>   
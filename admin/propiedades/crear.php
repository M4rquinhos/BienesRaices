<?php
    require '../../includes/app.php';

    use App\Propiedad;
    use Intervention\Image\ImageManagerStatic as Image;

    estaAutenticado();

    //base de datos 
    $db = conectarDB();

    $propiedad = new Propiedad;

    //Consultar para obtener los vendedores 
    $consulta = "SELECT * FROM vendedores";
    $resultadoVendedores = mysqli_query($db, $consulta);


    //arreglo con mensajes de errores 
    $errores = Propiedad::getErrores();



    //Ejecuta el codigo despues de que el usuario envia el formulario
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Crear una nueva instancia (Propiedad)
        $propiedad = new Propiedad($_POST['propiedad']);

        /** 
         * Subida de archivos
         */

        //Generar nombre un nombre unico
        $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";

        // Setear la imagen (asignar)
        if ($_FILES['propiedad']['tmp_name']['imagen']) {
             //Realiza un resize a la imagen con intervetion
            $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800, 600);
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
            <?php include '../../includes/templates/formulario_propiedades.php'; ?>


            <input type="submit" value="Crear Propiedad" class="boton boton-verde">

        </form>

    </main>

<?php 
    incluirTemplate('footer');
?>   
<?php

    use App\Propiedad;
    use Intervention\Image\ImageManagerStatic as Image;

    require '../../includes/app.php';

    estaAutenticado();

    // Validar la URL por ID valido
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if (!$id) {
        header('Location: /admin');
    }

    //base de datos 
    $db = conectarDB();

    //Consulta para obetner los datos de la propiedad (ACTUALIZAR)
    $propiedad = Propiedad::find($id);

    
    //Consultar para obtener los vendedores 
    $consulta = "SELECT * FROM vendedores";
    $resultadoVendedores = mysqli_query($db, $consulta);


    //arreglo con mensajes de errores 
    $errores = Propiedad::getErrores();

    //Ejecuta el codigo despues de que el usuario envia el formulario
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //Asignar los atributos
        $args = $_POST['propiedad'];
        
        $propiedad->sincronizar($args);
        
        //validacion
        $errores = $propiedad->validar();
        //revisar que el arreglo este vacio para insertar
        if (empty($errores)) {
            
            // Subida de archivos
            if ($_FILES['propiedad']['tmp_name']['imagen']) {
                //Generar nombre un nombre unico
                $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";
                //Realiza un resize a la imagen con intervetion
               $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800, 600);
               $propiedad->setImagen($nombreImagen);
               $image->save(CARPETA_IMAGENES . $nombreImagen);
           }
            //almacenar la imagen


            $propiedad->guardar();
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

            <?php include '../../includes/templates/formulario_propiedades.php'; ?>

            <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">

        </form>
    </main>

<?php 
    incluirTemplate('footer');
?>   
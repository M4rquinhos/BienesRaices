<?php 
require '../../includes/app.php';
use App\Vendedor;
estaAutenticado();

//validar que sea una id valido
$id = $_GET['id'];
$id =  filter_var($id, FILTER_VALIDATE_INT);

if (!$id) {
    header('Location: /admin');
}

// obtener el arreglo del vendedor desde la base de datos
$vendedor = Vendedor::find($id);

// debuggear($vendedor);

$errores = Vendedor::getErrores();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    //asignar los valores
    $args = $_POST['vendedor'];

    // Sincronizar objeto en memoria con lo que el usuario escribio
    $vendedor->sincronizar($args);

    // Validacion
    $errores = $vendedor->validar();
    
    if (empty($errores)) {
        $vendedor->guardar();
    }
    
}

incluirTemplate('header');
?>

<main class="contenedor seccion">
        <h1>Actualizar Vendedor</h1>

        <a href="/admin/index.php" class="boton boton-verde">Volver</a>

        <?php foreach ($errores as $error): ?>
            <div class="alerta error">
                <?=$error?>
            </div>
        <?php endforeach; ?>

        <form class="formulario" method="POST">
            <?php include '../../includes/templates/formulario_vendedores.php'; ?>


            <input type="submit" value="Guardar Cambios" class="boton boton-verde">

        </form>

    </main>


<?php 
incluirTemplate('footer');
?>
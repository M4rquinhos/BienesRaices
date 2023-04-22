<?php 

namespace App;

use mysqli;

class Propiedad {

    //Base de datos
    protected static $db;
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedorId'];


    //Errores 
    protected static $errores = [];

    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedorId;
    
    //definir la conexion a la BD
    public static function setDB($database) {
        self::$db = $database;
    }

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? NULL;
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedorId = $args['vendedorId'] ?? 1;
    }

    public function guardar() {
        //if(isset($this->id))
        //if(empty($this->id))
        //if(is_null($this->id))
        if (!is_null($this->id)) {
            //actualizar 
            $this->actualizar();
        }else {
            // crear nuevo registro
            $this->crear();
        }
    }

    public function crear() {
        //Sanitizar la entrada de los datos
        $atributos = $this->sanitizarAtributos();
        $columas = join(', ', array_keys($atributos));
        $values = join("', '", array_values($atributos));
        //insertar en la base de datos
        $query = "INSERT INTO propiedades ($columas) VALUES ('$values')";
        // debuggear($query);
        $resultado = self::$db->query($query);
        if ($resultado) {
            //redireccion al usuario
            header('Location: /admin?resultado=1');
        }

    }

    public function actualizar() {
        $atributos = $this->sanitizarAtributos();

        $valores = [];
        foreach ($atributos as $key => $value) {
            $valores[] = "$key = '$value'";
        }
        $query = "UPDATE propiedades SET "; 
        $query .= join(', ', $valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' LIMIT 1"; 
        $resultado = self::$db->query($query);
        
        if ($resultado) {
            //redireccion al usuario
            header('Location: /admin?resultado=2');
        }
    }

    //Eliminar un registro
    public function eliminar() {
        $query = " DELETE FROM propiedades WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1 ";
        $resultado =  self::$db->query($query);
        if ($resultado) {
            $this->borrarImagen();
            //redireccion al usuario
            header('Location: /admin?resultado=3');
        }
    }

    //Identificar y unir los atributos de la BD
    public function atributos() {
        $atributos = [];
        foreach (self::$columnasDB as $columna) {
            if($columna === 'id') continue;
            $atributos[$columna] = $this->$columna; 
        }
        return $atributos;
    }

    public function sanitizarAtributos() {
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach ($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    //subida de archivos
    public function setImagen($imagen) {
        //Elimina la imaen previa
        if(!is_null($this->id)) {
            $this->borrarImagen();
        }

        //asignar al atributo de la imagen el nombre de la imagen
        if ($imagen) {
            $this->imagen = $imagen;
        }
    }

    //Eliminar archivo
    public function borrarImagen() {
         //Comprobar si el archivo existe
         $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
         if ($existeArchivo) {
             unlink(CARPETA_IMAGENES . $this->imagen);
         }
    }

    //validacion 
    public static function getErrores() {
        return self::$errores;
    }

    public function validar() {
        if (!$this->titulo) {
            self::$errores[] = "Debes añadir un titulo";
        }

        if (!$this->precio) {
            self::$errores[] = "El precio es obligatorio";
        }

        if (strlen( $this->descripcion ) < 50) {
            self::$errores[] = "La descripcion es obligatoria y debe tener al menos 50 caracteres";
        }

        if (!$this->habitaciones) {
            self::$errores[] = "El numero de habitaciones es obligatorio";
        }

        if (!$this->wc) {
            self::$errores[] = "El numero de baños es obligatorio";
        }

        if (!$this->estacionamiento) {
            self::$errores[] = "El numero de estacionamientos es obligatorio";
        }

        if (!$this->vendedorId) {
            self::$errores[] = "Elige un vendedor";
        }

        if (!$this->imagen) {
            self::$errores[] = "La imagen es Obligatoria";
        }


        return self::$errores;
    }

    //Lista todos los registros
    public static function all() {
        $query = "SELECT * FROM propiedades";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    //busca un registro por su id
    public static function find($id) {
        $query = "SELECT * FROM propiedades WHERE id = $id";
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado);
    }

    public static function consultarSQL($query) {
        //primero consultra la base de datos
        $resultado = self::$db->query($query);

        //iterar los resultados 
        $arr = [];
        while($registro = $resultado->fetch_assoc()) {
            $arr[] = self::crearObjeto($registro);
        }

        //liberar la memoria 
        $resultado->free();

        //retornar los resultados
        return $arr;
    }

    protected static function crearObjeto($registro) {
        $objeto =  new self;

        foreach ($registro as $key => $value) {
            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }

    //Sincroniza el objeto en memoria con los cambios realizados por el usuario
    public function sincronizar($args = []) {
        foreach ($args as $key => $value) {
            if(property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }
}
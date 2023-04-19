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
        $this->id = $args['id'] ?? '';
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
        //Sanitizar la entrada de los datos
        $atributos = $this->sanitizarAtributos();
        $columas = join(', ', array_keys($atributos));
        $values = join("', '", array_values($atributos));
        //insertar en la base de datos
        $query = "INSERT INTO propiedades ($columas) VALUES ('$values')";
        // debuggear($query);
        $resultado = self::$db->query($query);
        return $resultado;

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
        //asignar al atributo de la imagen el nombre de la imagen
        if ($imagen) {
            $this->imagen = $imagen;
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

    //Lista todas las propiedades 
    public static function all() {
        $query = "SELECT * FROM propiedades";
        $resultado = self::consultarSQL($query);
        return $resultado;
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
}
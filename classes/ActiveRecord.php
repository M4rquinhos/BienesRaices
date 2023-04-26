<?php
 namespace App;

 class ActiveRecord {
    
    //Base de datos
    protected static $db;
    protected static $columnasDB = [];
    protected static $tabla = '';


    //Errores 
    protected static $errores = [];

    //definir la conexion a la BD
    public static function setDB($database) {
        self::$db = $database;
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
        $query = "INSERT INTO " .  static::$tabla . " ($columas) VALUES ('$values')";
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
        $query = "UPDATE " . static::$tabla . " SET "; 
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
        $query = " DELETE FROM " . static::$tabla  . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1 ";
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
        foreach (static::$columnasDB as $columna) {
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
        return static::$errores;
    }

    public function validar() {
        static::$errores = []; //Cada que se valida se limpia el arreglo
        return static::$errores;
    }

    //Lista todos los registros
    public static function all() {
        $query = "SELECT * FROM " . static::$tabla;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    //busca un registro por su id
    public static function find($id) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = $id";
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado);
    }

    public static function consultarSQL($query) {
        //primero consultra la base de datos
        $resultado = self::$db->query($query);

        //iterar los resultados 
        $arr = [];
        while($registro = $resultado->fetch_assoc()) {
            $arr[] = static::crearObjeto($registro);
        }

        //liberar la memoria 
        $resultado->free();

        //retornar los resultados
        return $arr;
    }

    protected static function crearObjeto($registro) {
        $objeto =  new static;

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
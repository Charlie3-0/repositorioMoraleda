<?php 

class UsuariosDAO {
    private mysqli $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    /**
     * Obtener un usuario de la BD en función del email
     * @return Usuario Devuelve un Objeto de la clase Usuario o null si no existe
     */
    public function getByEmail($email):Usuario|null {
        if(!$stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE email = ?"))
        {
            echo "Error en la SQL: " . $this->conn->error;
        }
        //Asociar las variables a las interrogaciones(parámetros)
        $stmt->bind_param('s',$email);
        //Ejecutamos la SQL
        $stmt->execute();
        //Obtener el objeto mysql_result
        $result = $stmt->get_result();

        //Si ha encontrado algún resultado devolvemos un objeto de la clase Usuario, sino null
        if($result->num_rows >= 1){
            $usuario = $result->fetch_object(Usuario::class);

            // Asignamos el rol manualmente si existe la propiedad y el método
            if ($fila = $result->fetch_assoc()) {
                $usuario->setRol($fila['rol']);
            }

            return $usuario;
        }
        else{
            return null;
        }
    } 


    /**
     * Obtener un usuario de la BD en función del id
     * @return Usuario Devuelve un Objeto de la clase Usuario o null si no existe
     */
    public function getById($id):Usuario|null {
        if(!$stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE id = ?"))
        {
            echo "Error en la SQL: " . $this->conn->error;
        }
        //Asociar las variables a las interrogaciones(parámetros)
        $stmt->bind_param('s',$id);
        //Ejecutamos la SQL
        $stmt->execute();
        //Obtener el objeto mysql_result
        $result = $stmt->get_result();

        //Si ha encontrado algún resultado devolvemos un objeto de la clase Usuario, sino null
        if($result->num_rows >= 1){
            $usuario = $result->fetch_object(Usuario::class);

            // Asignamos el rol manualmente si existe la propiedad y el método
            if ($fila = $result->fetch_assoc()) {
                $usuario->setRol($fila['rol']);
            }

            return $usuario;
        }
        else{
            return null;
        }
    } 


    /**
     * Obtener todos los usuarios de la tabla usuarios
     */
    public function getAll():array {
        if(!$stmt = $this->conn->prepare("SELECT * FROM usuarios"))
        {
            echo "Error en la SQL: " . $this->conn->error;
        }
        //Ejecutamos la SQL
        $stmt->execute();
        //Obtener el objeto mysql_result
        $result = $stmt->get_result();

        $array_usuarios = array();
        
        while($usuario = $result->fetch_object(Usuario::class)){
            $array_usuarios[] = $usuario;
        }
        return $array_usuarios;
    }


    /**
     * Insertar en la base de datos el usuario que recibe como parámetro
     * @return idUsuario Devuelve el id autonumérico que se le ha asignado al usuario o false en caso de error
     */
    function insert(Usuario $usuario): int|bool{
        if(!$stmt = $this->conn->prepare("INSERT INTO usuarios (email, password, rol) VALUES (?,?,?)")){
            die("Error al preparar la consulta insert: " . $this->conn->error );
        }
        $email = $usuario->getEmail();
        $password = $usuario->getPassword();
        $rol = $usuario->getRol();
        $stmt->bind_param('sss',$email, $password, $rol);
        if($stmt->execute()){
            return $stmt->insert_id;
        }
        else{
            return false;
        }
    }


    // Función para actualizar el rol de un usuario
    public function updateRol(Usuario $usuario) {
        $stmt = $this->conn->prepare("UPDATE usuarios SET rol = ? WHERE id = ?");
        $rol = $usuario->getRol();
        $id = $usuario->getId();
        $stmt->bind_param('si', $rol, $id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
    

    // Función para obtener todos los usuarios con rol 'U' (usuarios normales)
    public function getSoloUsuarios(): array {
        if (!$stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE rol = 'U'")) {
            echo "Error en la SQL: " . $this->conn->error;
        }
        $stmt->execute();
        $result = $stmt->get_result();
    
        $array_usuarios = array();
    
        while ($usuario = $result->fetch_object(Usuario::class)) {
            $array_usuarios[] = $usuario;
        }
    
        return $array_usuarios;
    }

}
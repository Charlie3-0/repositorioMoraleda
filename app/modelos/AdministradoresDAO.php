<?php 

class AdministradoresDAO {
    private mysqli $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    /**
     * Obtener un administrador de la BD en función del email
     * @return Administrador Devuelve un Objeto de la clase Administrador o null si no existe
     */
    public function getByEmail($email):Administrador|null {
        if(!$stmt = $this->conn->prepare("SELECT * FROM administradores WHERE email = ?"))
        {
            echo "Error en la SQL: " . $this->conn->error;
        }
        //Asociar las variables a las interrogaciones(parámetros)
        $stmt->bind_param('s',$email);
        //Ejecutamos la SQL
        $stmt->execute();
        //Obtener el objeto mysql_result
        $result = $stmt->get_result();

        //Si ha encontrado algún resultado devolvemos un objeto de la clase Administrador, sino null
        if($result->num_rows >= 1){
            $administrador = $result->fetch_object(Administrador::class);
            return $administrador;
        }
        else{
            return null;
        }
    }


    /**
     * Obtener un administrador de la BD en función del id
     * @return Administrador Devuelve un Objeto de la clase Administrador o null si no existe
     */
    public function getById($id):Administrador|null {
        if(!$stmt = $this->conn->prepare("SELECT * FROM administradores WHERE id = ?"))
        {
            echo "Error en la SQL: " . $this->conn->error;
        }
        //Asociar las variables a las interrogaciones(parámetros)
        $stmt->bind_param('s',$id);
        //Ejecutamos la SQL
        $stmt->execute();
        //Obtener el objeto mysql_result
        $result = $stmt->get_result();

        //Si ha encontrado algún resultado devolvemos un objeto de la clase Administrador, sino null
        if($result->num_rows >= 1){
            $administrador = $result->fetch_object(Administrador::class);
            return $administrador;
        }
        else{
            return null;
        }
    } 


    /**
     * Obtener todos los administradores de la tabla administradores
     */
    public function getAll():array {
        if(!$stmt = $this->conn->prepare("SELECT * FROM administradores"))
        {
            echo "Error en la SQL: " . $this->conn->error;
        }
        //Ejecutamos la SQL
        $stmt->execute();
        //Obtener el objeto mysql_result
        $result = $stmt->get_result();

        $array_administradores = array();
        
        while($administrador = $result->fetch_object(Administrador::class)){
            $array_administradores[] = $administrador;
        }
        return $array_administradores;
    }


    /**
     * Insertar en la base de datos el administrador que recibe como parámetro
     * @return idAdministrador Devuelve el id autonumérico que se le ha asignado al usuario o false en caso de error
     */
    function insert(Administrador $administrador): int|bool{
        if(!$stmt = $this->conn->prepare("INSERT INTO administradores (email, password) VALUES (?,?)")){
            die("Error al preparar la consulta insert: " . $this->conn->error );
        }
        $email = $administrador->getEmail();
        $password = $administrador->getPassword();
        $stmt->bind_param('ss',$email, $password);
        if($stmt->execute()){
            return $stmt->insert_id;
        }
        else{
            return false;
        }
    }

}


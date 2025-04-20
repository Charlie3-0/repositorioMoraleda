<?php 

class ComentariosDAO {
    private mysqli $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }


    /**
     * Obtener un comentario de la BD en función del id pasado
     * @return Comentario Devuelve el objeto Comentario o null si no lo encuentra
     */
    public function getById($id):Comentario|null {
        if(!$stmt = $this->conn->prepare("SELECT * FROM comentarios WHERE id = ?")) {
            echo "Error en la SQL: " . $this->conn->error;
        }
        //Asociar las variables a las interrogaciones(parámetros)
        $stmt->bind_param('i',$id);
        //Ejecutamos la SQL
        $stmt->execute();
        //Obtener el objeto mysql_result
        $result = $stmt->get_result();

        //Si ha encontrado algún resultado devolvemos un objeto de la clase Comentario, sino null
        if($result->num_rows == 1){
            $comentario = $result->fetch_object(Comentario::class);
            return $comentario;
        }
        else{
            return null;
        }
    }


    /**
     * Obtener todas los comentarios de la tabla comentarios
     * @return array Devuelve un array de objetos Comentario
     */
    public function getAll():array {
        if(!$stmt = $this->conn->prepare("SELECT * FROM comentarios"))
        {
            echo "Error en la SQL: " . $this->conn->error;
        }
        //Ejecutamos la SQL
        $stmt->execute();
        //Obtener el objeto mysql_result
        $result = $stmt->get_result();

        $array_comentarios = array();
        
        while($comentario = $result->fetch_object(Comentario::class)){
            $array_comentarios[] = $comentario;
        }
        return $array_comentarios;
    }

    

}
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

    
    /**
     * Inserta un nuevo comentario de un usuario sobre un videojuego.
     * No se comprueba si ya existe otro comentario: se permite múltiples comentarios por usuario.
     */
    public function ponerComentario($idUsuario, $idVideojuego, $comentario) {
        $fechaComentario = date('c');

        $sql = "INSERT INTO comentarios (idUsuario, idVideojuego, comentario, fecha_comentario)
                VALUES (?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return false;

        $stmt->bind_param("iiss", $idUsuario, $idVideojuego, $comentario, $fechaComentario);
        $resultado = $stmt->execute();
        
        if ($resultado) {
            $insertId = $stmt->insert_id;
            $stmt->close();
            return $insertId;
        }
    
        $stmt->close();
        return false;
    }


    /**
     * Edita exclusivamente un comentario existente
     */
    public function editarComentario($idUsuario, $idVideojuego, $comentario) {
        $fechaComentario = date('c');

        $sql = "UPDATE comentarios 
                SET comentario = ?, fecha_comentario = ? 
                WHERE idUsuario = ? AND idVideojuego = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssii", $comentario, $fechaComentario, $idUsuario, $idVideojuego);

        return $stmt->execute();
    }

    /**
     * Elimina un comentario concreto por su ID
     */
    public function quitarComentario($comentario) {
        if (!$stmt = $this->conn->prepare("DELETE FROM comentarios WHERE id = ?")) {
            die("Error al preparar la consulta delete: " . $this->conn->error);
        }
    
        $id = $comentario->getId();
        $stmt->bind_param('i', $id);
        $stmt->execute();
    
        if ($stmt->affected_rows >= 1) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * Editar un comentario por su ID (admin o autor)
     */
    public function editarComentarioPorId($idComentario, $comentario) {
        $fechaComentario = date('c');

        $sql = "UPDATE comentarios 
                SET comentario = ?, fecha_comentario = ?
                WHERE id = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssi", $comentario, $fechaComentario, $idComentario);

        return $stmt->execute();
    }



    /**
     * Obtener comentarios de usuarios sobre un videojuego
     */
    public function getComentariosPorVideojuego($idVideojuego) {
        if (!$stmt = $this->conn->prepare("SELECT comentarios.id, comentarios.comentario, comentarios.fecha_comentario, usuarios.email 
            FROM comentarios 
            JOIN usuarios ON comentarios.idUsuario = usuarios.id 
            WHERE comentarios.idVideojuego = ? 
            AND comentarios.comentario IS NOT NULL 
            ORDER BY comentarios.fecha_comentario DESC
            ")) {
            echo "Error en la SQL: " . $this->conn->error;
            return [];
        }
    
        $stmt->bind_param("i", $idVideojuego);
        $stmt->execute();
        $result = $stmt->get_result();

        $comentarios = [];

        while ($row = $result->fetch_object()) {
            $comentarios[] = $row; // objeto con ->comentario, ->fecha_comentario, ->email
        }

        return $comentarios;
    }
    

    /**
     * Obtener el comentario de un usuario sobre un videojuego específico
     */
    public function getComentarioPorUsuario($idVideojuego, $idUsuario) {
        $sql = "SELECT comentario, fecha_comentario FROM comentarios WHERE idVideojuego = ? AND idUsuario = ? AND comentario IS NOT NULL";
        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("ii", $idVideojuego, $idUsuario);
        $stmt->execute();
        $resultado = $stmt->get_result();

        return $resultado->fetch_assoc();
    }


    /**
     * Obtener un comentario individual
     */
    public function getComentarioPorId($id) {
        $sql = "SELECT * FROM comentarios WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
    
        if ($fila = $resultado->fetch_assoc()) {
            $comentario = new Comentario();
            $comentario->setId($fila['id']);
            $comentario->setIdUsuario($fila['idUsuario']);
            $comentario->setIdVideojuego($fila['idVideojuego']);
            $comentario->setComentario($fila['comentario']);
            $comentario->setFechaComentario($fila['fecha_comentario']);
            return $comentario;
        }
    
        return null;
    }
    

}
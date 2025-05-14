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
     * Guarda o actualiza el comentario de un usuario sobre un videojuego
     */
    public function ponerComentario($idUsuario, $idVideojuego, $comentario) {
        $fechaComentario = date('Y-m-d H:i:s');

        // Comprobamos si ya existe el registro
        $sql = "SELECT id FROM comentarios WHERE idUsuario = ? AND idVideojuego = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $idUsuario, $idVideojuego);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Ya existe: actualizar
            $update = $this->conn->prepare("UPDATE comentarios SET comentario = ?, fecha_comentario = ? WHERE idUsuario = ? AND idVideojuego = ?");
            $update->bind_param("ssii", $comentario, $fechaComentario, $idUsuario, $idVideojuego);
            return $update->execute();
        } else {
            // No existe: insertar con vista = 0 por defecto
            $insert = $this->conn->prepare("INSERT INTO comentarios (idUsuario, idVideojuego, comentario, fecha_comentario, vista) VALUES (?, ?, ?, ?, 0)");
            $insert->bind_param("iiss", $idUsuario, $idVideojuego, $comentario, $fechaComentario);
            return $insert->execute();
        }
    }


    /* public function ponerComentario($idUsuario, $idVideojuego, $comentario)
{
    $stmt = $this->conn->prepare("
        INSERT INTO comentarios (idUsuario, idVideojuego, comentario, fecha_comentario)
        VALUES (?, ?, ?, NOW())
        ON DUPLICATE KEY UPDATE comentario = VALUES(comentario), fechaComentario = NOW()
    ");
    $stmt->bind_param("iis", $idUsuario, $idVideojuego, $comentario);
    $stmt->execute();
} */



    /**
     * Edita exclusivamente un comentario existente
     */
    public function editarComentario($idUsuario, $idVideojuego, $comentario) {
        $fechaComentario = date('Y-m-d H:i:s');

        $sql = "UPDATE comentarios 
                SET comentario = ?, fecha_comentario = ? 
                WHERE idUsuario = ? AND idVideojuego = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssii", $comentario, $fechaComentario, $idUsuario, $idVideojuego);

        return $stmt->execute();
    }

    /**
     * Eliminar el comentario de un usuario sobre un videojuego
     */
    public function quitarComentario($idUsuario, $idVideojuego) {
        $sql = "UPDATE comentarios 
                SET comentario = NULL, fecha_comentario = NULL 
                WHERE idUsuario = ? AND idVideojuego = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $idUsuario, $idVideojuego);
    
        return $stmt->execute();
    }
    


    /**
     * Obtener comentarios de usuarios sobre un videojuego
     */
    public function getComentariosPorVideojuego($idVideojuego) {
        if (!$stmt = $this->conn->prepare("SELECT comentarios.comentario, comentarios.fecha_comentario, usuarios.email 
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

}
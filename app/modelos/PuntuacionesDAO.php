<?php 

class PuntuacionesDAO {
    private mysqli $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }


    /**
     * Obtener una puntuacion de la BD en función del id pasado
     * @return Puntuacion Devuelve el objeto Puntuacion o null si no lo encuentra
     */
    public function getById($id):Puntuacion|null {
        if(!$stmt = $this->conn->prepare("SELECT * FROM puntuaciones WHERE id = ?")) {
            echo "Error en la SQL: " . $this->conn->error;
        }
        //Asociar las variables a las interrogaciones(parámetros)
        $stmt->bind_param('i',$id);
        //Ejecutamos la SQL
        $stmt->execute();
        //Obtener el objeto mysql_result
        $result = $stmt->get_result();

        //Si ha encontrado algún resultado devolvemos un objeto de la clase Puntuacion, sino null
        if($result->num_rows == 1){
            $puntuacion = $result->fetch_object(Puntuacion::class);
            return $puntuacion;
        }
        else{
            return null;
        }
    }


    /**
     * Obtener todas las puntuaciones de la tabla puntuaciones
     * @return array Devuelve un array de objetos Puntuacion
     */
    public function getAll():array {
        if(!$stmt = $this->conn->prepare("SELECT * FROM puntuaciones"))
        {
            echo "Error en la SQL: " . $this->conn->error;
        }
        //Ejecutamos la SQL
        $stmt->execute();
        //Obtener el objeto mysql_result
        $result = $stmt->get_result();

        $array_puntuaciones = array();
        
        while($puntuacion = $result->fetch_object(Puntuacion::class)){
            $array_puntuaciones[] = $puntuacion;
        }
        return $array_puntuaciones;
    }


    /**
     * Función para contar el número de Puntuaciones, aunque la hemos usado para ver si tenemos una puntuacion de un videojuego,
     * ya que nosotros estamos contemplando que solo se puede tener una puntuacion de cada videojuego por usuario
     */
    public function countByIdVideojuego($idVideojuego){
        if(!$stmt = $this->conn->prepare("SELECT count(*) as NumPuntuaciones FROM puntuaciones WHERE idVideojuego = ?")){
            die("Error al preparar la consulta select count: " . $this->conn->error );
        }
        $stmt->bind_param('i',$idVideojuego);
        $stmt->execute();
        $result = $stmt->get_result();
        $fila = $result->fetch_assoc();
        return $fila['NumPuntuaciones'];
    }


    /**
     * Obtener todas las puntuaciones de la tabla puntuaciones por el ID de usuario
     * @param int $idUsuario El ID del usuario del que deseamos obtener las puntuaciones
     * @return array Devuelve un array de objetos Puntuacion
     */
    public function obtenerPuntuacionesByIdUsuario($idUsuario): array {
        if (!$stmt = $this->conn->prepare("SELECT * FROM puntuaciones WHERE idUsuario = ?")) {
            echo "Error en la SQL: " . $this->conn->error;
        }

        // Obtener parámetro del ID
        $stmt->bind_param('i', $idUsuario);

        // Ejecutamos la consulta
        $stmt->execute();

        // Obtener el objeto mysql_result
        $result = $stmt->get_result();

        $array_puntuaciones = array();

        // Mientras puntuacion es igual al resultado, se crea un array de Puntuacion
        while ($puntuacion = $result->fetch_object(Puntuacion::class)) {
            $array_puntuaciones[] = $puntuacion;
        }

        return $array_puntuaciones;
    }


    /**
     * Función que comprueba la existencia general de una puntuacion con idUsuario e idVideojuego
     * Devuelve true si existe y false si no existe
     */
    public function existByIdUsuarioIdVideojuego($idUsuario, $idVideojuego){
        if(!$stmt = $this->conn->prepare("SELECT * FROM puntuaciones WHERE idUsuario = ? AND idVideojuego = ?")){
            die("Error al preparar la consulta select exist: " . $this->conn->error );
        }
        $stmt->bind_param('ii',$idUsuario, $idVideojuego);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows>=1){
            return true;
        }else{
            return false;
        }
    }


    /**
     * Función para obtener todas puntuaciones con idUsuario e idVideojuego
     */
    public function getByIdUsuarioIdVideojuego($idUsuario, $idVideojuego): ? Puntuacion {
        if(!$stmt = $this->conn->prepare("SELECT * FROM puntuaciones WHERE idUsuario=? and idVideojuego = ?")){
            die("Error al preparar la consulta select: " . $this->conn->error );
        }
        $stmt->bind_param('ii', $idUsuario, $idVideojuego);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($puntuacion = $result->fetch_object(Puntuacion::class)){
            return $puntuacion;
        } else {
            return null; // En lugar de false, devolvemos null
        }
    }


    /**
     * Guarda o actualiza la puntuación de un usuario sobre un videojuego
     */
    public function ponerEditarPuntuacion($idUsuario, $idVideojuego, $puntuacion) {
        // Aseguraramos que la puntuación esté entre 1 y 10
        if ($puntuacion < 1 || $puntuacion > 10) {
            return false;
        }

        // Comprobamos si ya existe el registro
        $sql = "SELECT id FROM puntuaciones WHERE idUsuario = ? AND idVideojuego = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $idUsuario, $idVideojuego);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Ya existe: actualizar puntuación
            $update = $this->conn->prepare("UPDATE puntuaciones SET puntuacion = ? WHERE idUsuario = ? AND idVideojuego = ?");
            $update->bind_param("iii", $puntuacion, $idUsuario, $idVideojuego);
            return $update->execute();
        } else {
            // No existe: insertar con vista = 0 por defecto
            $insert = $this->conn->prepare("INSERT INTO puntuaciones (idUsuario, idVideojuego, puntuacion, vista) VALUES (?, ?, ?, 0)");
            $insert->bind_param("iii", $idUsuario, $idVideojuego, $puntuacion);
            return $insert->execute();
        }
    }


    /**
     * Recuperamos la puntuación de un usuario sobre un videojuego específico
     */
    public function obtenerPuntuacionUsuario($idVideojuego, $idUsuario) {
        $stmt = $this->conn->prepare("SELECT puntuacion FROM puntuaciones WHERE idVideojuego = ? AND idUsuario = ?");
        $stmt->bind_param("ii", $idVideojuego, $idUsuario);
        $stmt->execute();
        $resultado = $stmt->get_result();
    
        if ($fila = $resultado->fetch_assoc()) {
            return (int)$fila['puntuacion'];
        }
    
        return null; // No hay puntuación
    }
    


    /**
     * Obtener la puntuación media de un videojuego
     */
    public function obtenerPuntuacionMedia($idVideojuego) {
        $sql = "SELECT AVG(puntuacion) as media FROM puntuaciones WHERE idVideojuego = ? AND puntuacion IS NOT NULL";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $idVideojuego);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return round($result['media'], 1); // ejemplo: 8.3
    }
    
    /* public function obtenerPuntuacionMedia($idVideojuego) {
        $sql = "SELECT AVG(puntuacion) as media FROM puntuaciones WHERE idVideojuego = ? AND puntuacion IS NOT NULL";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $idVideojuego);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['media'] !== null ? round($result['media'], 1) : null;
    } */
    

    /**
     * Obtener la cantidad de votos (puntuaciones) de un videojuego
     */
    public function contarVotosVideojuego($idVideojuego) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM puntuaciones WHERE idVideojuego = ? AND puntuacion IS NOT NULL");
        $stmt->bind_param("i", $idVideojuego);
        $stmt->execute();
        $resultado = $stmt->get_result()->fetch_assoc();
        return $resultado['total'];
    }


}
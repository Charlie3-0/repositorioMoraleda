<?php 

class Videojuegos_probadosDAO {
    private mysqli $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }


    /**
     * Obtener un videojuego_probado de la BD en función del id pasado
     * @return Videojuego_probado Devuelve el objeto Videojuego_probado o null si no lo encuentra
     */
    public function getById($id):Videojuego_probado|null {
        if(!$stmt = $this->conn->prepare("SELECT * FROM videojuegos_probados WHERE id = ?")) {
            echo "Error en la SQL: " . $this->conn->error;
        }
        //Asociar las variables a las interrogaciones(parámetros)
        $stmt->bind_param('i',$id);
        //Ejecutamos la SQL
        $stmt->execute();
        //Obtener el objeto mysql_result
        $result = $stmt->get_result();

        //Si ha encontrado algún resultado devolvemos un objeto de la clase Videojuego_probado, sino null
        if($result->num_rows == 1){
            $videojuego_probado = $result->fetch_object(Videojuego_probado::class);
            return $videojuego_probado;
        }
        else{
            return null;
        }
    }


    /**
     * Obtener todas los videojuegos_probados de la tabla videojuegos_probados
     * @return array Devuelve un array de objetos Videojuego_probado
     */
    public function getAll():array {
        if(!$stmt = $this->conn->prepare("SELECT * FROM videojuegos_probados"))
        {
            echo "Error en la SQL: " . $this->conn->error;
        }
        //Ejecutamos la SQL
        $stmt->execute();
        //Obtener el objeto mysql_result
        $result = $stmt->get_result();

        $array_videojuegos_probados = array();
        
        while($videojuego_probado = $result->fetch_object(Videojuego_probado::class)){
            $array_videojuegos_probados[] = $videojuego_probado;
        }
        return $array_videojuegos_probados;
    }


    /**
     * Insertar una Reserva
     */
    /* public function insert($reserva){
        if($this->existByIdUsuarioIdPelicula($reserva->getIdUsuario(), $reserva->getIdPelicula()));
        if(!$stmt = $this->conn->prepare("INSERT INTO reservas (idUsuario, idPelicula) VALUES (?,?)")){
            die("Error al preparar la consulta insert: " . $this->conn->error );
        }
        $idUsuario = $reserva->getIdUsuario();
        $idPelicula = $reserva->getIdPelicula();
        $stmt->bind_param('ii',$idUsuario, $idPelicula);
        if($stmt->execute()){
            $reserva->setId($stmt->insert_id);
            return $stmt->insert_id;
        }
        else{
            return false;
        }
    } */






















    

    /**
     * Obtener todos los videojuegos_probados marcados como probados (probado = 1)
     * @return array Devuelve un array de objetos Videojuego_probado
     */
    public function getAllProbadosMarcados():array {
        if (!$stmt = $this->conn->prepare("SELECT * FROM videojuegos_probados WHERE probado = 1")) {
            echo "Error en la SQL: " . $this->conn->error;
        }
        //Ejecutamos la SQL
        $stmt->execute();
        //Obtener el objeto mysql_result
        $result = $stmt->get_result();

        $array_videojuegos_probados = array();
        
        while ($videojuego_probado = $result->fetch_object(Videojuego_probado::class)) {
            $array_videojuegos_probados[] = $videojuego_probado;
        }

        return $array_videojuegos_probados;
    }



    /**
     * Obtener todos los videojuegos_probados de la tabla videojuegos_probados por el ID de usuario
     * @param int $idUsuario El ID del usuario del que deseamos obtener los videojuegos_probados
     * @return array Devuelve un array de objetos Videojuego_probado
     */
    public function obtenerVideojuegosProbadosByIdUsuario($idUsuario): array {
        if (!$stmt = $this->conn->prepare("SELECT * FROM videojuegos_probados WHERE idUsuario = ?")) {
            echo "Error en la SQL: " . $this->conn->error;
        }

        // Obtener parámetro del ID
        $stmt->bind_param('i', $idUsuario);

        // Ejecutamos la consulta
        $stmt->execute();

        // Obtener el objeto mysql_result
        $result = $stmt->get_result();

        $array_videojuegos_probados = array();

        // Mientras videojuego_probado es igual al resultado, se crea un array de Videojuego_probado
        while ($videojuego_probado = $result->fetch_object(Videojuego_probado::class)) {
            $array_videojuegos_probados[] = $videojuego_probado;
        }

        return $array_videojuegos_probados;
    }


    /**
     * Obtener todos los videojuegos_probados marcados como probados (probado = 1) por el ID del usuario
     * @param int $idUsuario El ID del usuario
     * @return array Devuelve un array de objetos Videojuego_probado
     */
    public function obtenerVideojuegosProbadosMarcadosByIdUsuario($idUsuario): array {
        if (!$stmt = $this->conn->prepare("SELECT * FROM videojuegos_probados WHERE idUsuario = ? AND probado = 1")) {
            echo "Error en la SQL: " . $this->conn->error;
        }

        // Asociamos el parámetro del ID
        $stmt->bind_param('i', $idUsuario);

        // Ejecutamos la consulta
        $stmt->execute();

        // Obtenemos el resultado
        $result = $stmt->get_result();

        $array_videojuegos_probados = array();

        // Construimos el array de objetos Videojuego_probado
        while ($videojuego_probado = $result->fetch_object(Videojuego_probado::class)) {
            $array_videojuegos_probados[] = $videojuego_probado;
        }

        return $array_videojuegos_probados;
    }



    /**
     * Función para obtener todos videojuegos_probados con idUsuario e IdVideojuego
     */
    public function getByIdUsuarioIdVideojuego($idUsuario, $idVideojuego): ? Videojuego_probado {
        if(!$stmt = $this->conn->prepare("SELECT * FROM videojuegos_probados WHERE idUsuario=? and idVideojuego = ?")){
            die("Error al preparar la consulta select: " . $this->conn->error );
        }
        $stmt->bind_param('ii', $idUsuario, $idVideojuego);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($videojuego_probado = $result->fetch_object(Videojuego_probado::class)){
            return $videojuego_probado;
        } else {
            return null; // En lugar de false, devolvemos null
        }
    }

    
    /**
     * Función para saber si está probado el videojuego_probado como probado
     */
    /* public function estaMarcadoComoProbado($idUsuario, $idVideojuego) {
        if (!$stmt = $this->conn->prepare("SELECT 1 FROM videojuegos_probados WHERE idUsuario = ? AND idVideojuego = ? AND probado = 1 LIMIT 1")) {
            die("Error al preparar la consulta select está marcado como probado: " . $this->conn->error);
        }
    
        $stmt->bind_param("ii", $idUsuario, $idVideojuego);
        $stmt->execute();
        $result = $stmt->get_result();
    
        return $result->num_rows >= 1;
    } */


    /**
     * Función para saber si está probado el videojuego_probado
     */
    public function estaMarcadoComoProbado($idUsuario, $idVideojuego) {
        $query = "SELECT 1 FROM videojuegos_probados WHERE idUsuario = ? AND idVideojuego = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $idUsuario, $idVideojuego);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }
    
    

    /**
     * Función que comprueba la existencia general de un videojuego_probado con idUsuario e idVideojuego
     * Devuelve true si existe y false si no existe
     */
    public function existByIdUsuarioIdVideojuego($idUsuario, $idVideojuego){
        if(!$stmt = $this->conn->prepare("SELECT * FROM videojuegos_probados WHERE idUsuario = ? AND idVideojuego = ?")){
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
     * Función para obtener un videojuego_probado con idUsuario e idVideojuego
     */
    public function getProbadoPorUsuarioYVideojuego($idUsuario, $idVideojuego) {
        if(!$stmt = $this->conn->prepare("SELECT probado FROM videojuegos_probados WHERE idUsuario = ? AND idVideojuego = ?")){
            die("Error al preparar la consulta select para la vista: " . $this->conn->error );
        }
        $stmt->bind_param("ii", $idUsuario, $idVideojuego);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            return $row['probado'] == 1;
        }
        return false;
    }    
    

    /**
     * Función para contar el número de Videojuegos_probados, aunque la hemos usado para ver si tenemos un probado de un videojuego,
     * ya que nosotros estamos contemplando que solo se puede tener un probado de cada videojuego por usuario
     */
    public function countByIdVideojuego($idVideojuego){
        if(!$stmt = $this->conn->prepare("SELECT count(*) as NumProbados FROM videojuegos_probados WHERE idVideojuego = ?")){
            die("Error al preparar la consulta select count: " . $this->conn->error );
        }
        $stmt->bind_param('i',$idVideojuego);
        $stmt->execute();
        $result = $stmt->get_result();
        $fila = $result->fetch_assoc();
        return $fila['NumProbados'];
    }


    /**
     * Insertar el videojuego_probado "probado" en la base de datos
     */
    /* public function marcarComoProbado($idUsuario, $idVideojuego) {
        $fechaProbado = date('Y-m-d H:i:s');
    
        // Verificamos si ya existe un registro
        $query = "SELECT id, probado FROM videojuegos_probados WHERE idUsuario = ? AND idVideojuego = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $idUsuario, $idVideojuego);
        $stmt->execute();
        $resultado = $stmt->get_result();
    
        if ($resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
            if ($fila['probado'] == 1) {
                // Ya está marcado como probado, no hacemos nada
                return false;
            } else {
                // Existe pero no estaba marcado como probado, lo actualizamos
                $updateQuery = "UPDATE videojuegos_probados SET probado = 1, fecha_probado = ? WHERE id = ?";
                $updateStmt = $this->conn->prepare($updateQuery);
                $updateStmt->bind_param("si", $fechaProbado, $fila['id']);
                return $updateStmt->execute();
            }
        } else {
            // No existe aún, la insertamos
            $insertQuery = "INSERT INTO videojuegos_probados (idUsuario, idVideojuego, probado, fecha_probado) VALUES (?, ?, 1, ?)";
            $insertStmt = $this->conn->prepare($insertQuery);
            $insertStmt->bind_param("iis", $idUsuario, $idVideojuego, $fechaProbado);
            return $insertStmt->execute();
        }
    } */


    /**
     * Insertar el videojuego_probado en la base de datos
     */
    public function marcarComoProbado($idUsuario, $idVideojuego) {
        $fechaProbado = date('Y-m-d H:i:s');
    
        // Verificar si ya existe un registro
        $query = "SELECT id FROM videojuegos_probados WHERE idUsuario = ? AND idVideojuego = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $idUsuario, $idVideojuego);
        $stmt->execute();
        $resultado = $stmt->get_result();
    
        if ($resultado->num_rows > 0) {
            // Ya existe, no hacemos nada
            return false;
        }
    
        // Insertar nuevo
        $insertQuery = "INSERT INTO videojuegos_probados (idUsuario, idVideojuego, fecha_probado) VALUES (?, ?, ?)";
        $insertStmt = $this->conn->prepare($insertQuery);
        $insertStmt->bind_param("iis", $idUsuario, $idVideojuego, $fechaProbado);
        return $insertStmt->execute();
    }
    
    

    /**
     * Actualiza el estado de probado, a videojuego_probado no probado
     * @param int $idUsuario ID del usuario
     * @param int $idVideojuego ID del videojuego
     * @param int $nuevoEstado Estado de probado (1 = probado, 0 = no probado)
     */
    /* public function quitarProbado($idUsuario, $idVideojuego) {
        if (!$stmt = $this->conn->prepare("UPDATE videojuegos_probados SET probado = 0 WHERE idUsuario = ? AND idVideojuego = ? AND probado = 1")) {
            die("Error al preparar la consulta update: " . $this->conn->error);
        }
    
        $stmt->bind_param("ii", $idUsuario, $idVideojuego);
    
        return $stmt->execute();
    } */


    /**
     * Elimina el videojuego_probado de la base de datos
     */
    public function quitarProbado($idUsuario, $idVideojuego) {
        $deleteQuery = "DELETE FROM videojuegos_probados WHERE idUsuario = ? AND idVideojuego = ?";
        $stmt = $this->conn->prepare($deleteQuery);
        $stmt->bind_param("ii", $idUsuario, $idVideojuego);
        return $stmt->execute();
    }
    


    /**
     * Agrupar los videojuegos probados de videojuegos_probados por Usuario para una mejor visualización para el administrador/
     * lista donde se vea cada usuario con sus videojuegos probados debajo, todo agrupado y limpio(para bootstrap mirar si podemos
     * usar un desplegable o un acordeon para ver los usuarios y al hacer click para ver los videojuegos probados del usuario, ese usuario
     * y así con todos)
     */
    public function getVideojuegosProbadosAgrupadosPorUsuario() {
        $sql = "SELECT * FROM videojuegos_probados ORDER BY idUsuario, fecha_probado";
        $result = $this->conn->query($sql);
    
        $usuariosDAO = new UsuariosDAO($this->conn);
        $videojuegosDAO = new VideojuegosDAO($this->conn);
    
        $agrupado = [];
    
        while ($fila = $result->fetch_assoc()) {
            $idUsuario = $fila['idUsuario'];
            $idVideojuego = $fila['idVideojuego'];
            $fechaProbado = $fila['fecha_probado'];
    
            // Cargar usuario si aún no está cargado
            if (!isset($agrupado[$idUsuario])) {
                $usuario = $usuariosDAO->getById($idUsuario);

                // Saltar si no es un usuario con rol 'U'
                if ($usuario->getRol() !== 'U') continue;

                $agrupado[$idUsuario] = [
                    'usuario' => $usuario,
                    'videojuegos' => []
                ];
            }
    
            // Añadimos el videojuego probado a este usuario
            $agrupado[$idUsuario]['videojuegos'][] = [
                'videojuego' => $videojuegosDAO->getById($idVideojuego),
                'fecha' => $fechaProbado
            ];
        }
    
        return array_values($agrupado); // Para tener índices numéricos
    }
    


}
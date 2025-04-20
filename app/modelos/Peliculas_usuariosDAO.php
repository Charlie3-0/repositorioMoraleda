<?php 

class Peliculas_usuariosDAO {
    private mysqli $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }


    /**
     * Obtener una pelicula_usuario de la BD en función del id pasado
     * @return Pelicula_usuario Devuelve el objeto Pelicula_usuario o null si no lo encuentra
     */
    public function getById($id):Pelicula_usuario|null {
        if(!$stmt = $this->conn->prepare("SELECT * FROM peliculas_usuarios WHERE id = ?")) {
            echo "Error en la SQL: " . $this->conn->error;
        }
        //Asociar las variables a las interrogaciones(parámetros)
        $stmt->bind_param('i',$id);
        //Ejecutamos la SQL
        $stmt->execute();
        //Obtener el objeto mysql_result
        $result = $stmt->get_result();

        //Si ha encontrado algún resultado devolvemos un objeto de la clase Pelicula_usuario, sino null
        if($result->num_rows == 1){
            $pelicula_usuario = $result->fetch_object(Pelicula_usuario::class);
            return $pelicula_usuario;
        }
        else{
            return null;
        }
    }


    /**
     * Obtener todas las peliculas_usuarios de la tabla peliculas_usuarios
     * @return array Devuelve un array de objetos Pelicula_usuario
     */
    public function getAll():array {
        if(!$stmt = $this->conn->prepare("SELECT * FROM peliculas_usuarios"))
        {
            echo "Error en la SQL: " . $this->conn->error;
        }
        //Ejecutamos la SQL
        $stmt->execute();
        //Obtener el objeto mysql_result
        $result = $stmt->get_result();

        $array_peliculas_usuarios = array();
        
        while($pelicula_usuario = $result->fetch_object(Pelicula_usuario::class)){
            $array_peliculas_usuarios[] = $pelicula_usuario;
        }
        return $array_peliculas_usuarios;
    }


    /**
     * Obtener todas las peliculas_usuarios marcadas como vistas (vista = 1)
     * @return array Devuelve un array de objetos Pelicula_usuario
     */
    public function getAllVistasMarcadas():array {
        if (!$stmt = $this->conn->prepare("SELECT * FROM peliculas_usuarios WHERE vista = 1")) {
            echo "Error en la SQL: " . $this->conn->error;
        }
        //Ejecutamos la SQL
        $stmt->execute();
        //Obtener el objeto mysql_result
        $result = $stmt->get_result();

        $array_peliculas_usuarios = array();
        
        while ($pelicula_usuario = $result->fetch_object(Pelicula_usuario::class)) {
            $array_peliculas_usuarios[] = $pelicula_usuario;
        }

        return $array_peliculas_usuarios;
    }



    /**
     * Obtener todas las peliculas_usuarios de la tabla peliculas_usuarios por el ID de usuario
     * @param int $idUsuario El ID del usuario del que deseamos obtener las peliculas_usuarios
     * @return array Devuelve un array de objetos Pelicula_usuario
     */
    public function obtenerPeliculasUsuariosByIdUsuario($idUsuario): array {
        if (!$stmt = $this->conn->prepare("SELECT * FROM peliculas_usuarios WHERE idUsuario = ?")) {
            echo "Error en la SQL: " . $this->conn->error;
        }

        // Obtener parámetro del ID
        $stmt->bind_param('i', $idUsuario);

        // Ejecutamos la consulta
        $stmt->execute();

        // Obtener el objeto mysql_result
        $result = $stmt->get_result();

        $array_peliculas_usuarios = array();

        // Mientras pelicula_usuario es igual al resultado, se crea un array de Pelicula_usuario
        while ($pelicula_usuario = $result->fetch_object(Pelicula_usuario::class)) {
            $array_peliculas_usuarios[] = $pelicula_usuario;
        }

        return $array_peliculas_usuarios;
    }


    /**
     * Obtener todas las películas_usuarios marcadas como vistas (vista = 1) por el ID del usuario
     * @param int $idUsuario El ID del usuario
     * @return array Devuelve un array de objetos Pelicula_usuario
     */
    public function obtenerPeliculasVistasMarcadasByIdUsuario($idUsuario): array {
        if (!$stmt = $this->conn->prepare("SELECT * FROM peliculas_usuarios WHERE idUsuario = ? AND vista = 1")) {
            echo "Error en la SQL: " . $this->conn->error;
        }

        // Asociamos el parámetro del ID
        $stmt->bind_param('i', $idUsuario);

        // Ejecutamos la consulta
        $stmt->execute();

        // Obtenemos el resultado
        $result = $stmt->get_result();

        $array_peliculas_usuarios = array();

        // Construimos el array de objetos Pelicula_usuario
        while ($pelicula_usuario = $result->fetch_object(Pelicula_usuario::class)) {
            $array_peliculas_usuarios[] = $pelicula_usuario;
        }

        return $array_peliculas_usuarios;
    }



    /**
     * Función para obtener todas peliculas_usuarios con idUsuario e IdPelicula
     */
    public function getByIdUsuarioIdPelicula($idUsuario, $idPelicula): ? Pelicula_usuario {
        if(!$stmt = $this->conn->prepare("SELECT * FROM peliculas_usuarios WHERE idUsuario=? and idPelicula = ?")){
            die("Error al preparar la consulta select: " . $this->conn->error );
        }
        $stmt->bind_param('ii', $idUsuario, $idPelicula);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($pelicula_usuario = $result->fetch_object(Pelicula_usuario::class)){
            return $pelicula_usuario;
        } else {
            return null; // En lugar de false, devolvemos null
        }
    }

    
    /**
     * Función para saber si está marcada la pelicula_usuario como vista
     */
    public function estaMarcadaComoVista($idUsuario, $idPelicula) {
        if (!$stmt = $this->conn->prepare("SELECT 1 FROM peliculas_usuarios WHERE idUsuario = ? AND idPelicula = ? AND vista = 1 LIMIT 1")) {
            die("Error al preparar la consulta select está marcada como vista: " . $this->conn->error);
        }
    
        $stmt->bind_param("ii", $idUsuario, $idPelicula);
        $stmt->execute();
        $result = $stmt->get_result();
    
        return $result->num_rows >= 1;
    }
    

    /**
     * Función que comprueba la existencia general de una pelicula_usuario con idUsuario e idPelicula
     * Devuelve true si existe y false si no existe
     */
    public function existByIdUsuarioIdPelicula($idUsuario, $idPelicula){
        if(!$stmt = $this->conn->prepare("SELECT * FROM peliculas_usuarios WHERE idUsuario = ? AND idPelicula = ?")){
            die("Error al preparar la consulta select exist: " . $this->conn->error );
        }
        $stmt->bind_param('ii',$idUsuario, $idPelicula);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows>=1){
            return true;
        }else{
            return false;
        }
    }
    

    /**
     * Función para obtener una pelicula_usuario con idUsuario e IdPelicula
     */
    public function getVistaPorUsuarioYPelicula($idUsuario, $idPelicula) {
        if(!$stmt = $this->conn->prepare("SELECT vista FROM peliculas_usuarios WHERE idUsuario = ? AND idPelicula = ?")){
            die("Error al preparar la consulta select para la vista: " . $this->conn->error );
        }
        $stmt->bind_param("ii", $idUsuario, $idPelicula);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            return $row['vista'] == 1;
        }
        return false;
    }    
    

    /**
     * Función para contar el número de Peliculas_usuarios, aunque la hemos usado para ver si hay una vista de una pelicula,
     * ya que nosotros estamos contemplando que solo se puede tener una vista de cada pelicula por usuario
     */
    public function countByIdPelicula($idPelicula){
        if(!$stmt = $this->conn->prepare("SELECT count(*) as NumVistas FROM peliculas_usuarios WHERE idPelicula = ?")){
            die("Error al preparar la consulta select count: " . $this->conn->error );
        }
        $stmt->bind_param('i',$idPelicula);
        $stmt->execute();
        $result = $stmt->get_result();
        $fila = $result->fetch_assoc();
        return $fila['NumVistas'];
    }


    /**
     * Insertar la pelicula_usuario "vista" en la base de datos
     */
    public function marcarComoVista($idUsuario, $idPelicula) {
        $fechaVista = date('Y-m-d H:i:s');
    
        // Verificamos si ya existe un registro para esa combinación
        $query = "SELECT id, vista FROM peliculas_usuarios WHERE idUsuario = ? AND idPelicula = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $idUsuario, $idPelicula);
        $stmt->execute();
        $resultado = $stmt->get_result();
    
        if ($resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
            if ($fila['vista'] == 1) {
                // Ya está marcada como vista, no hacemos nada
                return false;
            } else {
                // Existe pero no estaba marcada como vista, la actualizamos
                $updateQuery = "UPDATE peliculas_usuarios SET vista = 1, fecha_vista = ? WHERE id = ?";
                $updateStmt = $this->conn->prepare($updateQuery);
                $updateStmt->bind_param("si", $fechaVista, $fila['id']);
                return $updateStmt->execute();
            }
        } else {
            // No existe aún, la insertamos
            $insertQuery = "INSERT INTO peliculas_usuarios (idUsuario, idPelicula, vista, fecha_vista) VALUES (?, ?, 1, ?)";
            $insertStmt = $this->conn->prepare($insertQuery);
            $insertStmt->bind_param("iis", $idUsuario, $idPelicula, $fechaVista);
            return $insertStmt->execute();
        }
    }
    

    /**
     * Actualiza el estado de vista, a pelicula_usuario no vista
     * @param int $idUsuario ID del usuario
     * @param int $idPelicula ID de la película
     * @param int $nuevoEstado Estado de vista (1 = vista, 0 = no vista)
     */
    public function quitarVista($idUsuario, $idPelicula) {
        if (!$stmt = $this->conn->prepare("UPDATE peliculas_usuarios SET vista = 0 WHERE idUsuario = ? AND idPelicula = ? AND vista = 1")) {
            die("Error al preparar la consulta update: " . $this->conn->error);
        }
    
        $stmt->bind_param("ii", $idUsuario, $idPelicula);
    
        return $stmt->execute();
    }


    /**
     * Agrupar las peliculas vistas de peliculas_usuarios por Usuario para una mejor visualización para el administrador/
     * lista donde se vea cada usuario con sus películas vistas debajo, todo agrupado y limpio(para bootstrap mirar si podemos
     * usar un desplegable o un acordeon para ver los usuarios y al hacer click para ver las peliculas vistas del usuario ese usuario
     * y así con todos)
     */
    public function getPeliculasVistasAgrupadasPorUsuario() {
        $sql = "SELECT * FROM peliculas_usuarios WHERE vista = 1 ORDER BY idUsuario, fecha_vista";
        $result = $this->conn->query($sql);
    
        $usuariosDAO = new UsuariosDAO($this->conn);
        $peliculasDAO = new PeliculasDAO($this->conn);
    
        $agrupado = [];
    
        while ($fila = $result->fetch_assoc()) {
            $idUsuario = $fila['idUsuario'];
            $idPelicula = $fila['idPelicula'];
            $fechaVista = $fila['fecha_vista'];
    
            // Si aún no hemos agregado a este usuario, lo añadimos
            if (!isset($agrupado[$idUsuario])) {
                $agrupado[$idUsuario] = [
                    'usuario' => $usuariosDAO->getById($idUsuario),
                    'peliculas' => []
                ];
            }
    
            // Añadimos la película vista a este usuario
            $agrupado[$idUsuario]['peliculas'][] = [
                'pelicula' => $peliculasDAO->getById($idPelicula),
                'fecha' => $fechaVista
            ];
        }
    
        return array_values($agrupado); // Para tener índices numéricos
    }


    // COMENTARIOS
    /**
     * Guarda o actualiza el comentario de un usuario sobre una película
     */
    public function guardarComentario($idUsuario, $idPelicula, $comentario) {
        $fechaComentario = date('Y-m-d H:i:s');

        // Comprobamos si ya existe el registro
        $sql = "SELECT id FROM peliculas_usuarios WHERE idUsuario = ? AND idPelicula = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $idUsuario, $idPelicula);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Ya existe: actualizar
            $update = $this->conn->prepare("UPDATE peliculas_usuarios SET comentario = ?, fecha_comentario = ? WHERE idUsuario = ? AND idPelicula = ?");
            $update->bind_param("ssii", $comentario, $fechaComentario, $idUsuario, $idPelicula);
            return $update->execute();
        } else {
            // No existe: insertar con vista = 0 por defecto
            $insert = $this->conn->prepare("INSERT INTO peliculas_usuarios (idUsuario, idPelicula, comentario, fecha_comentario, vista) VALUES (?, ?, ?, ?, 0)");
            $insert->bind_param("iiss", $idUsuario, $idPelicula, $comentario, $fechaComentario);
            return $insert->execute();
        }
    }



    // PUNTUACIONES
    /**
     * Guarda o actualiza la puntuación de un usuario sobre una película
     */
    public function ponerEditarPuntuacion($idUsuario, $idPelicula, $puntuacion) {
        // Aseguraramos que la puntuación esté entre 1 y 10
        if ($puntuacion < 1 || $puntuacion > 10) {
            return false;
        }

        // Comprobamos si ya existe el registro
        $sql = "SELECT id FROM peliculas_usuarios WHERE idUsuario = ? AND idPelicula = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $idUsuario, $idPelicula);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Ya existe: actualizar puntuación
            $update = $this->conn->prepare("UPDATE peliculas_usuarios SET puntuacion = ? WHERE idUsuario = ? AND idPelicula = ?");
            $update->bind_param("iii", $puntuacion, $idUsuario, $idPelicula);
            return $update->execute();
        } else {
            // No existe: insertar con vista = 0 por defecto
            $insert = $this->conn->prepare("INSERT INTO peliculas_usuarios (idUsuario, idPelicula, puntuacion, vista) VALUES (?, ?, ?, 0)");
            $insert->bind_param("iii", $idUsuario, $idPelicula, $puntuacion);
            return $insert->execute();
        }
    }


    /**
     * Recuperamos la puntuación de un usuario sobre una película específica
     */
    public function obtenerPuntuacionUsuario($idPelicula, $idUsuario) {
        $stmt = $this->conn->prepare("SELECT puntuacion FROM peliculas_usuarios WHERE idPelicula = ? AND idUsuario = ?");
        $stmt->bind_param("ii", $idPelicula, $idUsuario);
        $stmt->execute();
        $resultado = $stmt->get_result();
    
        if ($fila = $resultado->fetch_assoc()) {
            return (int)$fila['puntuacion'];
        }
    
        return null; // No hay puntuación
    }
    


    /**
     * Obtener la puntuación media de una película
     */
    public function obtenerPuntuacionMedia($idPelicula) {
        $sql = "SELECT AVG(puntuacion) as media FROM peliculas_usuarios WHERE idPelicula = ? AND puntuacion IS NOT NULL";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $idPelicula);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return round($result['media'], 1); // ejemplo: 8.3
    }
    
    /* public function obtenerPuntuacionMedia($idPelicula) {
        $sql = "SELECT AVG(puntuacion) as media FROM peliculas_usuarios WHERE idPelicula = ? AND puntuacion IS NOT NULL";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $idPelicula);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['media'] !== null ? round($result['media'], 1) : null;
    } */
    

    /**
     * Obtener la cantidad de votos (puntuaciones) de una película
     */
    public function contarVotosPelicula($idPelicula) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM peliculas_usuarios WHERE idPelicula = ? AND puntuacion IS NOT NULL");
        $stmt->bind_param("i", $idPelicula);
        $stmt->execute();
        $resultado = $stmt->get_result()->fetch_assoc();
        return $resultado['total'];
    }
    


}
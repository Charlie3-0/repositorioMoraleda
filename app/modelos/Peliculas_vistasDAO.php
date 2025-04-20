<?php 

class Peliculas_vistasDAO {
    private mysqli $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }


    /**
     * Obtener una pelicula_vista de la BD en función del id pasado
     * @return Pelicula_vista Devuelve el objeto Pelicula_vista o null si no lo encuentra
     */
    public function getById($id):Pelicula_vista|null {
        if(!$stmt = $this->conn->prepare("SELECT * FROM peliculas_vistas WHERE id = ?")) {
            echo "Error en la SQL: " . $this->conn->error;
        }
        //Asociar las variables a las interrogaciones(parámetros)
        $stmt->bind_param('i',$id);
        //Ejecutamos la SQL
        $stmt->execute();
        //Obtener el objeto mysql_result
        $result = $stmt->get_result();

        //Si ha encontrado algún resultado devolvemos un objeto de la clase Pelicula_vista, sino null
        if($result->num_rows == 1){
            $pelicula_vista = $result->fetch_object(Pelicula_vista::class);
            return $pelicula_vista;
        }
        else{
            return null;
        }
    }


    /**
     * Obtener todas las peliculas_vistas de la tabla peliculas_vistas
     * @return array Devuelve un array de objetos Pelicula_vista
     */
    public function getAll():array {
        if(!$stmt = $this->conn->prepare("SELECT * FROM peliculas_vistas"))
        {
            echo "Error en la SQL: " . $this->conn->error;
        }
        //Ejecutamos la SQL
        $stmt->execute();
        //Obtener el objeto mysql_result
        $result = $stmt->get_result();

        $array_peliculas_vistas = array();
        
        while($pelicula_vista = $result->fetch_object(Pelicula_vista::class)){
            $array_peliculas_vistas[] = $pelicula_vista;
        }
        return $array_peliculas_vistas;
    }


    /**
     * Obtener todas las películas marcadas como vistas (vista = 1)
     * @return array Devuelve un array de objetos Pelicula_vista
     */
    public function getAllVistasMarcadas():array {
        if (!$stmt = $this->conn->prepare("SELECT * FROM peliculas_vistas WHERE vista = 1")) {
            echo "Error en la SQL: " . $this->conn->error;
        }
        //Ejecutamos la SQL
        $stmt->execute();
        //Obtener el objeto mysql_result
        $result = $stmt->get_result();

        $array_peliculas_vistas = array();
        
        while ($pelicula_vista = $result->fetch_object(Pelicula_vista::class)) {
            $array_peliculas_vistas[] = $pelicula_vista;
        }

        return $array_peliculas_vistas;
    }



    /**
     * Obtener todas las peliculas_vistas de la tabla peliculas_vistas por el ID de usuario
     * @param int $idUsuario El ID del usuario del que deseamos obtener las peliculas_vistas
     * @return array Devuelve un array de objetos Pelicula_vista
     */
    public function obtenerPeliculasVistasByIdUsuario($idUsuario): array {
        if (!$stmt = $this->conn->prepare("SELECT * FROM peliculas_vistas WHERE idUsuario = ?")) {
            echo "Error en la SQL: " . $this->conn->error;
        }

        // Obtener parámetro del ID
        $stmt->bind_param('i', $idUsuario);

        // Ejecutamos la consulta
        $stmt->execute();

        // Obtener el objeto mysql_result
        $result = $stmt->get_result();

        $arrayPeliculas_vistas = array();

        // Mientras pelicula_vista es igual al resultado, se crea un array de Peliculas_vistas
        while ($pelicula_vista = $result->fetch_object(Pelicula_vista::class)) {
            $arrayPeliculas_vistas[] = $pelicula_vista;
        }

        return $arrayPeliculas_vistas;
    }


    /**
     * Obtener todas las películas marcadas como vistas (vista = 1) por el ID del usuario
     * @param int $idUsuario El ID del usuario
     * @return array Devuelve un array de objetos Pelicula_vista
     */
    public function obtenerPeliculasVistasMarcadasByIdUsuario($idUsuario): array {
        if (!$stmt = $this->conn->prepare("SELECT * FROM peliculas_vistas WHERE idUsuario = ? AND vista = 1")) {
            echo "Error en la SQL: " . $this->conn->error;
        }

        // Asociamos el parámetro del ID
        $stmt->bind_param('i', $idUsuario);

        // Ejecutamos la consulta
        $stmt->execute();

        // Obtenemos el resultado
        $result = $stmt->get_result();

        $arrayPeliculas_vistas = array();

        // Construimos el array de objetos Pelicula_vista
        while ($pelicula_vista = $result->fetch_object(Pelicula_vista::class)) {
            $arrayPeliculas_vistas[] = $pelicula_vista;
        }

        return $arrayPeliculas_vistas;
    }



    /**
     * Función para obtener todas pelicula_vista con idUsuario e IdPelicula
     */
    public function getByIdUsuarioIdPelicula($idUsuario, $idPelicula): ? Pelicula_vista {
        if(!$stmt = $this->conn->prepare("SELECT * FROM peliculas_vistas WHERE idUsuario=? and idPelicula = ?")){
            die("Error al preparar la consulta select: " . $this->conn->error );
        }
        $stmt->bind_param('ii', $idUsuario, $idPelicula);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($pelicula_vista = $result->fetch_object(Pelicula_vista::class)){
            return $pelicula_vista;
        } else {
            return null; // En lugar de false, devolvemos null
        }
    }

    
    /**
     * Función para saber si está marcada la pelicula como vista
     */
    public function estaMarcadaComoVista($idUsuario, $idPelicula) {
        if (!$stmt = $this->conn->prepare("SELECT 1 FROM peliculas_vistas WHERE idUsuario = ? AND idPelicula = ? AND vista = 1 LIMIT 1")) {
            die("Error al preparar la consulta select está marcada como vista: " . $this->conn->error);
        }
    
        $stmt->bind_param("ii", $idUsuario, $idPelicula);
        $stmt->execute();
        $result = $stmt->get_result();
    
        return $result->num_rows >= 1;
    }
    

    /**
     * Función que comprueba la existencia general de una pelicula_vista con idUsuario e idPelicula
     * Devuelve true si existe y false si no existe
     */
    public function existByIdUsuarioIdPelicula($idUsuario, $idPelicula){
        if(!$stmt = $this->conn->prepare("SELECT * FROM peliculas_vistas WHERE idUsuario = ? AND idPelicula = ?")){
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
     * Función para obtener una pelicula_vista con idUsuario e IdPelicula
     */
    public function getVistaPorUsuarioYPelicula($idUsuario, $idPelicula) {
        if(!$stmt = $this->conn->prepare("SELECT vista FROM peliculas_vistas WHERE idUsuario = ? AND idPelicula = ?")){
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
     * Función para contar el número de Peliculas_vistas, aunque la hemos usado para ver si hay una vista de una pelicula,
     * ya que nosotros estamos contemplando que solo se puede tener una vista de cada pelicula por usuario
     */
    public function countByIdPelicula($idPelicula){
        if(!$stmt = $this->conn->prepare("SELECT count(*) as NumVistas FROM peliculas_vistas WHERE idPelicula = ?")){
            die("Error al preparar la consulta select count: " . $this->conn->error );
        }
        $stmt->bind_param('i',$idPelicula);
        $stmt->execute();
        $result = $stmt->get_result();
        $fila = $result->fetch_assoc();
        return $fila['NumVistas'];
    }


    /**
     * Insertar la pelicula "vista" en la base de datos
     */
    public function marcarComoVista($idUsuario, $idPelicula) {
        $fechaVista = date('Y-m-d H:i:s');

        // Comprobamos si ya existe una película_vista previa (que esté marcada como vista)
        if ($this->estaMarcadaComoVista($idUsuario, $idPelicula)) {
            // Ya existe un registro anterior, no insertamos otro
            return false;
        }

        if (!$stmt = $this->conn->prepare("INSERT INTO peliculas_vistas (idUsuario, idPelicula, vista, fecha_vista) VALUES (?, ?, 1, ?)")) {
            die("Error al preparar la consulta insert: " . $this->conn->error);
        }

        $stmt->bind_param("iis", $idUsuario, $idPelicula, $fechaVista);

        return $stmt->execute();
    }


    /**
     * Actualiza el estado de vista, a pelicula no vista
     * @param int $idUsuario ID del usuario
     * @param int $idPelicula ID de la película
     * @param int $nuevoEstado Estado de vista (1 = vista, 0 = no vista)
     */
    public function quitarVista($idUsuario, $idPelicula) {
        if (!$stmt = $this->conn->prepare("UPDATE peliculas_vistas SET vista = 0 WHERE idUsuario = ? AND idPelicula = ? AND vista = 1")) {
            die("Error al preparar la consulta update: " . $this->conn->error);
        }
    
        $stmt->bind_param("ii", $idUsuario, $idPelicula);
    
        return $stmt->execute();
    }

    /**
     * Agrupar las peliculas_vistas por Usuario para una mejor visualización para el administrador/
     * lista donde se vea cada usuario con sus películas vistas debajo, todo agrupado y limpio(para bootstrap mirar si podemos
     * usar un desplegable o un acordeon para ver los usuarios y al hacer click para ver las peliculas vistas del usuario ese usuario
     * y así con todos)
     */
    public function getPeliculasVistasAgrupadasPorUsuario() {
        $sql = "SELECT * FROM peliculas_vistas WHERE vista = 1 ORDER BY idUsuario, fecha_vista";
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
    


}
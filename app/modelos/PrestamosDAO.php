<?php 


class PrestamosDAO {
    private mysqli $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }


    /**
     * Obtener un prestamo de la BD en función del id pasado
     * @return Prestamo Devuelve el objeto Prestamo o null si no lo encuentra
     */
    public function getById($id):Prestamo|null {
        if(!$stmt = $this->conn->prepare("SELECT * FROM prestamos WHERE id = ?"))
        {
            echo "Error en la SQL: " . $this->conn->error;
        }
        //Asociar las variables a las interrogaciones(parámetros)
        $stmt->bind_param('i',$id);
        //Ejecutamos la SQL
        $stmt->execute();
        //Obtener el objeto mysql_result
        $result = $stmt->get_result();

        //Si ha encontrado algún resultado devolvemos un objeto de la clase Prestamo, sino null
        if($result->num_rows == 1){
            $prestamo = $result->fetch_object(Prestamo::class);
            return $prestamo;
        }
        else{
            return null;
        }
    }


    /**
     * Obtener todos los prestamos de la tabla prestamos
     * @return array Devuelve un array de objetos Prestamo
     */
    public function getAll():array {
        if(!$stmt = $this->conn->prepare("SELECT * FROM prestamos"))
        {
            echo "Error en la SQL: " . $this->conn->error;
        }
        //Ejecutamos la SQL
        $stmt->execute();
        //Obtener el objeto mysql_result
        $result = $stmt->get_result();

        $array_prestamos = array();
        
        while($prestamo = $result->fetch_object(Prestamo::class)){
            $array_prestamos[] = $prestamo;
        }
        return $array_prestamos;
    }


    public function getPrestamosAgrupadosPorUsuario() {
        $sql = "SELECT * FROM prestamos ORDER BY idUsuario, fecha_prestamo DESC";
        $result = $this->conn->query($sql);
    
        $usuariosDAO = new UsuariosDAO($this->conn);
        $videojuegosDAO = new VideojuegosDAO($this->conn);
    
        $agrupado = [];
    
        while ($fila = $result->fetch_assoc()) {
            $idUsuario = $fila['idUsuario'];
    
            // Cargar usuario solo si es necesario
            if (!isset($agrupado[$idUsuario])) {
                $usuario = $usuariosDAO->getById($idUsuario);
    
                // Saltar si no es usuario normal
                if ($usuario->getRol() !== 'U') continue;
    
                $agrupado[$idUsuario] = [
                    'usuario' => $usuario,
                    'prestamos' => []
                ];
            }
    
            $prestamo = new Prestamo();
            $prestamo->setId($fila['id']);
            $prestamo->setIdUsuario($idUsuario);
            $prestamo->setIdVideojuego($fila['idVideojuego']);
            $prestamo->setFechaPrestamo($fila['fecha_prestamo']);
            $prestamo->setDevuelto($fila['devuelto']);
    
            // Empaquetar todo en un array
            $prestamoConUsuarioVideojuego = [
                'prestamo' => $prestamo,
                'videojuego' => $videojuegosDAO->getById($fila['idVideojuego']),
                'usuario' => $agrupado[$idUsuario]['usuario'],
            ];

            $agrupado[$idUsuario]['prestamos'][] = $prestamoConUsuarioVideojuego;
        }
    
        return array_values($agrupado); // Para que sean índices numéricos
    }
    


    /**
     * Obtener todos los préstamos de la tabla prestamos por el ID de usuario
     * @param int $idUsuario El ID del usuario del que deseamos obtener los préstamos
     * @return array Devuelve un array de objetos Prestamo
     */
    public function obtenerPrestamosByIdUsuario($idUsuario): array {
        if (!$stmt = $this->conn->prepare("SELECT * FROM prestamos WHERE idUsuario = ?")) {
            echo "Error en la SQL: " . $this->conn->error;
        }

        // Obtener parámetro del ID
        $stmt->bind_param('i', $idUsuario);

        // Ejecutamos la consulta
        $stmt->execute();

        // Obtener el objeto mysql_result
        $result = $stmt->get_result();

        $arrayPrestamos = array();

        // Mientras prestamo es igual al resultado, se crea un array de Prestamos
        while ($prestamo = $result->fetch_object(Prestamo::class)) {
            $arrayPrestamos[] = $prestamo;
        }

        return $arrayPrestamos;
    }


    /**
     * Insertar en la base de datos el prestamo que recibe como parámetro
     * @return idPrestamo Devuelve el id autonumérico que se le ha asignado al prestamo o false en caso de error
     */
    function insertar(Prestamo $prestamo): int|bool{
        if(!$stmt = $this->conn->prepare("INSERT INTO prestamos (fecha_prestamo, devuelto, idUsuario, idVideojuego) VALUES (?,?,?,?)")){
            die("Error al preparar la consulta insertar: " . $this->conn->error );
        }
        $fechaPrestamo = $prestamo->getFechaPrestamo();
        $devuelto = $prestamo->getDevuelto();
        $idUsuario = $prestamo->getIdUsuario();
        $idVideojuego = $prestamo->getIdVideojuego();
        $stmt->bind_param('siii',$fechaPrestamo ,$devuelto, $idUsuario, $idVideojuego);
        if($stmt->execute()){
            return $stmt->insert_id;
        }
        else{
            return false;
        }
    }


    /**
     * Función para contar el número de Videojuegos prestados, aunque la hemos usado para ver si tenemos el préstamo de un videojuego,
     * ya que nosotros estamos contemplando que solo hay una unidad de cada videojuego
     */
    public function countByIdVideojuego($idVideojuego){
        if(!$stmt = $this->conn->prepare("SELECT count(*) as NumPrestamos FROM prestamos WHERE idVideojuego = ?")){
            die("Error al preparar la consulta select count: " . $this->conn->error );
        }
        $stmt->bind_param('i',$idVideojuego);
        $stmt->execute();
        $result = $stmt->get_result();
        $fila = $result->fetch_assoc();
        return $fila['NumPrestamos'];
    }

    /**
     * Función que comprueba si existe un préstamo con idUsuario e idVideojuego
     * Devuelve true si existe y false si no existe
     */
    public function existByIdUsuarioIdVideojuego($idUsuario, $idVideojuego){
        if(!$stmt = $this->conn->prepare("SELECT * FROM prestamos WHERE idUsuario=? and idVideojuego = ?")){
            die("Error al preparar la consulta select count: " . $this->conn->error );
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
     * Función que obtiene el usuario que tiene prestado un videojuego específico y no lo ha devuelto.
     * @param int $idVideojuego - Parámetro del ID del videojuego para el cual se desea obtener el usuario que lo ha tomado prestado.
     * @return Usuario|null - Devuelve un objeto Usuario si se encuentra un préstamo activo, o null si no hay ningún préstamo activo.
     */
    public function getUsuarioPrestamoPorVideojuegoId($idVideojuego) {
        // Preparamos la consulta SQL para obtener el usuario que tiene prestado el videojuego con el ID dado y no ha sido devuelto
        if(!$stmt = $this->conn->prepare("SELECT usuarios.* FROM usuarios JOIN prestamos ON usuarios.id = prestamos.idUsuario WHERE prestamos.idVideojuego = ? AND prestamos.devuelto = 0 LIMIT 1")){
            echo "Error en la SQL para obtener el usuario que tiene prestado la película: " . $this->conn->error;
        }
        
        // Vinculamos el parámetro $idVideojuego a la consulta SQL
        $stmt->bind_param("i", $idVideojuego);
        // Ejecutamos la consulta
        $stmt->execute();
        // Obtenemos el resultado de la consulta
        $result = $stmt->get_result();
        
        // Inicializamos la variable $usuario como null
        $usuario = null;
    
        // Si se encuentra una fila en el resultado, la asignamos a un objeto Usuario
        if ($row = $result->fetch_assoc()) {
            $usuario = new Usuario();
            // Asignamos los campos del usuario
            $usuario->setId($row['id']);
            $usuario->setEmail($row['email']);
            $usuario->setPassword($row['password']);
        }
    
        // Cerramos la declaración preparada
        $stmt->close();
        
        // Devolvemos el objeto Usuario
        return $usuario;
    }
    

    /**
     * Función para obtener un préstamo con idUsuario e idVideojuego
     */
    public function getByIdUsuarioIdVideojuego($idUsuario, $idVideojuego){
        if(!$stmt = $this->conn->prepare("SELECT * FROM prestamos WHERE idUsuario=? and idVideojuego = ?")){
            die("Error al preparar la consulta select count: " . $this->conn->error );
        }
        $stmt->bind_param('ii',$idUsuario, $idVideojuego);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($prestamo = $result->fetch_object(Prestamo::class)){
            return $prestamo;
        }
        else{
            return false;
        }
    }
    

    /* Recogemos los videojuegos que no han sido prestados, es decir,
    los que han sido devueltos, que será para el booleano un 0(devuelto), para poder prestarlos después de nuevo. */
    public function obtenerVideojuegosDisponibles():array { 
        if(!$stmt = $this->conn->prepare("SELECT * FROM videojuegos WHERE id NOT IN(SELECT idVideojuego from prestamos WHERE devuelto=false)")){
            echo "Error en la SQL: " . $this->conn->error;
        }
        //Ejecutamos la SQL
        $stmt->execute();
        //Obtener el objeto mysql_result
        $result = $stmt->get_result();

        $array_videojuegos = array();
        
        while($videojuego = $result->fetch_object(Videojuego::class)){
            $array_videojuegos[] = $videojuego;
        }
        return $array_videojuegos;
    }


    // Método para marcar el préstamo como devuelto
    public function marcarComoDevuelto($idPrestamo) {
        $sql = "UPDATE prestamos SET devuelto = 1 WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $idPrestamo);

        return $stmt->execute();
    }


    // Método para marcar como devuelto el prestamo desde el ID del videojuego
    public function marcarComoDevueltoPorIdVideojuego($idVideojuego) {
        $sql = "UPDATE prestamos SET devuelto = 1 WHERE idVideojuego = ? AND devuelto = 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $idVideojuego);
        return $stmt->execute();
    }
    

    // Método para obtener un préstamo activo por el ID del videojuego
    public function getPrestamoActivoPorVideojuegoId($idVideojuego) {
        $stmt = $this->conn->prepare("SELECT * FROM prestamos WHERE idVideojuego = ? AND devuelto = 0 LIMIT 1");
        $stmt->bind_param("i", $idVideojuego);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        if ($fila = $resultado->fetch_assoc()) {
            $prestamo = new Prestamo(
                $fila['id'],
                $fila['fecha_prestamo'],
                $fila['devuelto'],
                $fila['idUsuario'],
                $fila['idVideojuego']  
            );
            return $prestamo;
        }
        return null;
    }


}


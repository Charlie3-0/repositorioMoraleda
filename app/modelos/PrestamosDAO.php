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
     * Borrar el prestamo de la tabla prestamos del id pasado por parámetro
     * @return true si ha borrado el prestamo y false si no lo ha borrado (por que no existia)
     */
    function borrar($id):bool{

        if(!$stmt = $this->conn->prepare("DELETE FROM prestamos WHERE id = ?"))
        {
            echo "Error en la SQL: " . $this->conn->error;
        }
        //Asociar las variables a las interrogaciones(parámetros)
        $stmt->bind_param('i',$id);
        //Ejecutamos la SQL
        $stmt->execute();
        //Comprobamos si ha borrado algún registro o no
        if($stmt->affected_rows==1){
            return true;
        }
        else{
            return false;
        }
        
    }


    /**
     * Insertar en la base de datos el prestamo que recibe como parámetro
     * @return idPrestamo Devuelve el id autonumérico que se le ha asignado al prestamo o false en caso de error
     */
    function insertar(Prestamo $prestamo): int|bool{
        if(!$stmt = $this->conn->prepare("INSERT INTO prestamos (fecha, devuelta, idUsuario, idPelicula) VALUES (?,?,?,?)")){
            die("Error al preparar la consulta insertar: " . $this->conn->error );
        }
        $fecha = $prestamo->getFecha();
        $devuelta = $prestamo->getDevuelta();
        $idUsuario = $prestamo->getIdUsuario();
        $idPelicula = $prestamo->getIdPelicula();
        $stmt->bind_param('siii',$fecha ,$devuelta, $idUsuario, $idPelicula);
        if($stmt->execute()){
            return $stmt->insert_id;
        }
        else{
            return false;
        }
    }


    /**
     * Función para contar el número de Peliculas prestadas, aunque la hemos usado para ver si hay el préstamo de una pelicula,
     * ya que nosotros estamos contemplando que solo hay una unidad de cada pelicula
     */
    public function countByIdPelicula($idPelicula){
        if(!$stmt = $this->conn->prepare("SELECT count(*) as NumPrestamos FROM prestamos WHERE idPelicula = ?")){
            die("Error al preparar la consulta select count: " . $this->conn->error );
        }
        $stmt->bind_param('i',$idPelicula);
        $stmt->execute();
        $result = $stmt->get_result();
        $fila = $result->fetch_assoc();
        return $fila['NumPrestamos'];
    }

    /**
     * Función que comprueba si existe un préstamo con idUsuario e idPelicula
     * Devuelve true si existe y false si no existe
     */
    public function existByIdUsuarioIdPelicula($idUsuario, $idPelicula){
        if(!$stmt = $this->conn->prepare("SELECT * FROM prestamos WHERE idUsuario=? and idPelicula = ?")){
            die("Error al preparar la consulta select count: " . $this->conn->error );
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
     * Función que obtiene el usuario que tiene prestado una pelicula específica y no la ha devuelto.
     * @param int $idPelicula - Parámetro del ID de la pelicula para la cual se desea obtener el usuario que la ha tomado prestada.
     * @return Usuario|null - Devuelve un objeto Usuario si se encuentra un préstamo activo, o null si no hay ningún préstamo activo.
     */
    public function getUsuarioPrestamoPorPeliculaId($idPelicula) {
        // Preparamos la consulta SQL para obtener el usuario que tiene prestado la pelicula con el ID dado y no ha sido devuelta
        if(!$stmt = $this->conn->prepare("SELECT usuarios.* FROM usuarios JOIN prestamos ON usuarios.id = prestamos.idUsuario WHERE prestamos.idPelicula = ? AND prestamos.devuelta = 0 LIMIT 1")){
            echo "Error en la SQL para obtener el usuario que tiene prestado la película: " . $this->conn->error;
        }
        
        // Vinculamos el parámetro $idPelicula a la consulta SQL
        $stmt->bind_param("i", $idPelicula);
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
     * Función para obtener un préstamo con idUsuario e IdPelicula
     */
    public function getByIdUsuarioIdPelicula($idUsuario, $idPelicula){
        if(!$stmt = $this->conn->prepare("SELECT * FROM prestamos WHERE idUsuario=? and idPelicula = ?")){
            die("Error al preparar la consulta select count: " . $this->conn->error );
        }
        $stmt->bind_param('ii',$idUsuario, $idPelicula);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($prestamo = $result->fetch_object(Prestamo::class)){
            return $prestamo;
        }
        else{
            return false;
        }
    }
    

    /* Recogemos las peliculas que no han sido prestadas, es decir,
    las que han sido devueltas, que será para el booleano un 0(devuelta), para poder prestarlas después de nuevo. */
    public function obtenerPeliculasDisponibles():array { 
        if(!$stmt = $this->conn->prepare("SELECT * FROM peliculas WHERE id NOT IN(SELECT IdPelicula from prestamos WHERE devuelta=false)")){
            echo "Error en la SQL: " . $this->conn->error;
        }
        //Ejecutamos la SQL
        $stmt->execute();
        //Obtener el objeto mysql_result
        $result = $stmt->get_result();

        $array_peliculas = array();
        
        while($pelicula = $result->fetch_object(Pelicula::class)){
            $array_peliculas[] = $pelicula;
        }
        return $array_peliculas;
    }


    // Método para marcar el préstamo como devuelto
    public function marcarComoDevuelto($idPrestamo) {
        $sql = "UPDATE prestamos SET devuelta = 1 WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $idPrestamo);

        return $stmt->execute();
    }

}


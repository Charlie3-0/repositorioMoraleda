<?php 

class ReservasDAO {
    private mysqli $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }


    /**
     * Obtener una reserva de la BD en función del id pasado
     * @return Reserva Devuelve el objeto Reserva o null si no lo encuentra
     */
    public function getById($id):Reserva|null {
        if(!$stmt = $this->conn->prepare("SELECT * FROM reservas WHERE id = ?"))
        {
            echo "Error en la SQL: " . $this->conn->error;
        }
        //Asociar las variables a las interrogaciones(parámetros)
        $stmt->bind_param('i',$id);
        //Ejecutamos la SQL
        $stmt->execute();
        //Obtener el objeto mysql_result
        $result = $stmt->get_result();

        //Si ha encontrado algún resultado devolvemos un objeto de la clase Reserva, sino null
        if($result->num_rows == 1){
            $reserva = $result->fetch_object(Reserva::class);
            return $reserva;
        }
        else{
            return null;
        }
    }


    /**
     * Obtener todas las reservas de la tabla reservas
     * @return array Devuelve un array de objetos Reserva
     */
    public function getAll():array {
        if(!$stmt = $this->conn->prepare("SELECT * FROM reservas"))
        {
            echo "Error en la SQL: " . $this->conn->error;
        }
        //Ejecutamos la SQL
        $stmt->execute();
        //Obtener el objeto mysql_result
        $result = $stmt->get_result();

        $array_reservas = array();
        
        while($reserva = $result->fetch_object(Reserva::class)){
            $array_reservas[] = $reserva;
        }
        return $array_reservas;
    }


    /**
     * Insertar una Reserva
     */
    public function insert($reserva){
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
    }

    /**
     * Borrar una Reserva 
     */
    public function delete($reserva){
        if(!$stmt = $this->conn->prepare("DELETE FROM reservas WHERE id = ?")){
            die("Error al preparar la consulta delete: " . $this->conn->error );
        }
        $id = $reserva->getId();
        $stmt->bind_param('i',$id);
        $stmt->execute();
        if($stmt->affected_rows >=1 ){
            return true;
        }
        else{
            return false;
        }
    }

    /**
     * Función para contar el número de Peliculas reservadas, aunque la hemos usado para ver si hay la reserva de una pelicula,
     * ya que nosotros estamos contemplando que solo hay una unidad de cada pelicula
     */
    public function countByIdPelicula($idPelicula){
        if(!$stmt = $this->conn->prepare("SELECT count(*) as NumReservas FROM reservas WHERE idPelicula = ?")){
            die("Error al preparar la consulta select count: " . $this->conn->error );
        }
        $stmt->bind_param('i',$idPelicula);
        $stmt->execute();
        $result = $stmt->get_result();
        $fila = $result->fetch_assoc();
        return $fila['NumReservas'];
    }

    /**
     * Función que comprueba si existe una reserva con idUsuario e idPelicula
     * Devuelve true si existe y false si no existe
     */
    public function existByIdUsuarioIdPelicula($idUsuario, $idPelicula){
        if(!$stmt = $this->conn->prepare("SELECT * FROM reservas WHERE idUsuario=? and idPelicula = ?")){
            die("Error al preparar la consulta select: " . $this->conn->error );
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
     * Función que obtiene el usuario que ha reservado una pelicula específica.
     * @param int $idPelicula - Parámetro del ID de la pelicula para la cual se desea obtener el usuario que la reservó.
     * @return Usuario|null - Devuelve un objeto Usuario si se encuentra una reserva, o null si no hay ninguna reserva.
     */
    public function getUsuarioReservaPorPeliculaId($idPelicula) {
        // Preparamos la consulta SQL para obtener el usuario que ha reservado la pelicula con el ID dado
        if(!$stmt = $this->conn->prepare("SELECT usuarios.* FROM usuarios JOIN reservas ON usuarios.id = reservas.idUsuario WHERE reservas.idPelicula = ?")){
            echo "Error en la SQL para obtener el usuario que ha reservado la pelicula: " . $this->conn->error;
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
     * Función para obtener una reserva con idUsuario e IdPelicula
     */
    public function getByIdUsuarioIdPelicula($idUsuario, $idPelicula){
        if(!$stmt = $this->conn->prepare("SELECT * FROM reservas WHERE idUsuario=? and idPelicula = ?")){
            die("Error al preparar la consulta select count: " . $this->conn->error );
        }
        $stmt->bind_param('ii',$idUsuario, $idPelicula);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($reserva = $result->fetch_object(Reserva::class)){
            return $reserva;
        }
        else{
            return false;
        }
    }
    
    
    /**
     * Obtener todas las reservas de la tabla reservas por el ID de usuario
     * @param int $idUsuario El ID del usuario del que deseamos obtener las reservas
     * @return array Devuelve un array de objetos Reserva
     */
    public function obtenerReservasByIdUsuario($idUsuario): array {
        if (!$stmt = $this->conn->prepare("SELECT * FROM reservas WHERE idUsuario = ?")) {
            echo "Error en la SQL: " . $this->conn->error;
        }

        // Obtener parámetro del ID
        $stmt->bind_param('i', $idUsuario);

        // Ejecutamos la consulta
        $stmt->execute();

        // Obtener el objeto mysql_result
        $result = $stmt->get_result();

        $arrayReservas = array();

        // Mientras reserva es igual al resultado, se crea un array de Reservas
        while ($reserva = $result->fetch_object(Reserva::class)) {
            $arrayReservas[] = $reserva;
        }

        return $arrayReservas;
    }
}



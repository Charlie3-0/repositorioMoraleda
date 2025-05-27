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
        if($this->existByIdUsuarioIdVideojuego($reserva->getIdUsuario(), $reserva->getIdVideojuego()));
        if(!$stmt = $this->conn->prepare("INSERT INTO reservas (fecha_reserva, idUsuario, idVideojuego) VALUES (?,?,?)")){
            die("Error al preparar la consulta insert: " . $this->conn->error );
        }
        $idUsuario = $reserva->getIdUsuario();
        $idVideojuego = $reserva->getIdVideojuego();
        $fechaReserva = $reserva->getFechaReserva();
        $stmt->bind_param('sii',$fechaReserva, $idUsuario, $idVideojuego);
        if($stmt->execute()){
            $reserva->setId($stmt->insert_id);
            return $stmt->insert_id;
        }
        else{
            return false;
        }
    }


    /**
     * Insertar una Reserva
     */
/*     public function insert($reserva){
        if($this->existByIdUsuarioIdVideojuego($reserva->getIdUsuario(), $reserva->getIdVideojuego()));
        if(!$stmt = $this->conn->prepare("INSERT INTO reservas (fecha_reserva, tramitado, idUsuario, idVideojuego) VALUES (?,?,?,?)")){
            die("Error al preparar la consulta insert: " . $this->conn->error );
        }
        $fechaReserva = $reserva->getFechaReserva();
        $tramitado = $reserva->getTramitado();
        $idUsuario = $reserva->getIdUsuario();
        $idVideojuego = $reserva->getIdVideojuego();
        $stmt->bind_param('siii',$fechaReserva, $tramitado, $idUsuario, $idVideojuego);
        if($stmt->execute()){
            $reserva->setId($stmt->insert_id);
            return $stmt->insert_id;
        }
        else{
            return false;
        }
    } */


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
     * Función para contar el número de Videojuegos reservados, aunque la hemos usado para ver si tenemos la reserva de un videojuego,
     * ya que nosotros estamos contemplando que solo hay una unidad de cada videojuego
     */
    public function countByIdVideojuego($idVideojuego){
        if(!$stmt = $this->conn->prepare("SELECT count(*) as NumReservas FROM reservas WHERE idVideojuego = ?")){
            die("Error al preparar la consulta select count: " . $this->conn->error );
        }
        $stmt->bind_param('i',$idVideojuego);
        $stmt->execute();
        $result = $stmt->get_result();
        $fila = $result->fetch_assoc();
        return $fila['NumReservas'];
    }

    /**
     * Función que comprueba si existe una reserva con idUsuario e idVideojuego
     * Devuelve true si existe y false si no existe
     */
    public function existByIdUsuarioIdVideojuego($idUsuario, $idVideojuego){
        if(!$stmt = $this->conn->prepare("SELECT * FROM reservas WHERE idUsuario=? and idVideojuego = ?")){
            die("Error al preparar la consulta select: " . $this->conn->error );
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
     * Función que obtiene el usuario que ha reservado un videojuego específico.
     * @param int $idVideojuego - Parámetro del ID del videojuego para el cual se desea obtener el usuario que lo reservó.
     * @return Usuario|null - Devuelve un objeto Usuario si se encuentra una reserva, o null si no hay ninguna reserva.
     */
    public function getUsuarioReservaPorVideojuegoId($idVideojuego) {
        // Preparamos la consulta SQL para obtener el usuario que ha reservado el videojuego con el ID dado
        if(!$stmt = $this->conn->prepare("SELECT usuarios.* FROM usuarios JOIN reservas ON usuarios.id = reservas.idUsuario WHERE reservas.idVideojuego = ?")){
            echo "Error en la SQL para obtener el usuario que ha reservado el videojuego: " . $this->conn->error;
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
     * Función para obtener una reserva con idUsuario e idVideojuego
     */
    public function getByIdUsuarioIdVideojuego($idUsuario, $idPelicula){
        if(!$stmt = $this->conn->prepare("SELECT * FROM reservas WHERE idUsuario=? and idVideojuego = ?")){
            die("Error al preparar la consulta select count: " . $this->conn->error );
        }
        $stmt->bind_param('ii',$idUsuario, $idVideojuego);
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


    /* public function obtenerReservasByIdUsuarioTramitados($idUsuario): array {
        if (!$stmt = $this->conn->prepare("SELECT * FROM reservas WHERE idUsuario = ? AND tramitado = 0")) {
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
    } */

}



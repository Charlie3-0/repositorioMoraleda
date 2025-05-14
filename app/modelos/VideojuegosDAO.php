<?php 

class VideojuegosDAO {
    private mysqli $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }


    /**
     * Obtener un videojuego de la BD en función del id pasado
     * @return Videojuego Devuelve el objeto Videojuego o null si no lo encuentra
     */
    public function getById($id):Videojuego|null {
        if(!$stmt = $this->conn->prepare("SELECT * FROM videojuegos WHERE id = ?")) {
            echo "Error en la SQL: " . $this->conn->error;
        }
        //Asociar las variables a las interrogaciones(parámetros)
        $stmt->bind_param('i',$id);
        //Ejecutamos la SQL
        $stmt->execute();
        //Obtener el objeto mysql_result
        $result = $stmt->get_result();

        //Si ha encontrado algún resultado devolvemos un objeto de la clase Videojuego, sino null
        if($result->num_rows == 1){
            $videojuego = $result->fetch_object(Videojuego::class);
            return $videojuego;
        }
        else{
            return null;
        }
    }


    /**
     * Obtener todas los videojuegos de la tabla videojuegos
     * @return array Devuelve un array de objetos Videojuego
     */
    public function getAll():array {
        if(!$stmt = $this->conn->prepare("SELECT * FROM videojuegos"))
        {
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


    /**
     * Insertar en la base de datos el videojuego que recibe como parámetro
     * @return idVideojuego Devuelve el id autonumérico que se le ha asignado al videojuego o false en caso de error
     */
    function insert(Videojuego $videojuego): int|bool{
        if(!$stmt = $this->conn->prepare("INSERT INTO videojuegos (titulo, desarrollador, descripcion, foto, idCategoria, fecha_lanzamiento, trailer) VALUES (?,?,?,?,?,?,?)")){
            die("Error al preparar la consulta insert: " . $this->conn->error );
        }
        $titulo = $videojuego->getTitulo();
        $desarrollador = $videojuego->getDesarrollador();
        $descripcion = $videojuego->getDescripcion();
        $foto = $videojuego->getFoto();
        $idCategoria = $videojuego->getIdCategoria();
        $fechaLanzamiento = $videojuego->getFechaLanzamiento();
        $trailer = $videojuego->getTrailer();
        $stmt->bind_param('ssssiss',$titulo, $desarrollador, $descripcion, $foto, $idCategoria, $fechaLanzamiento, $trailer);
        if($stmt->execute()){
            return $stmt->insert_id;
        }
        else{
            return false;
        }
    }


    /**
     * Editar en la base de datos el videojuego que recibe como parámetro
     */
    function update($videojuego){
        if(!$stmt = $this->conn->prepare("UPDATE videojuegos SET titulo=?, desarrollador=?, descripcion=?, foto=?, idCategoria=?, fecha_lanzamiento=?, trailer=? WHERE id=?")){
            die("Error al preparar la consulta update: " . $this->conn->error );
        }
        $titulo = $videojuego->getTitulo();
        $desarrollador = $videojuego->getDesarrollador();
        $descripcion = $videojuego->getDescripcion();
        $foto = $videojuego->getFoto();
        $idCategoria = $videojuego->getIdCategoria();
        $fechaLanzamiento = $videojuego->getFechaLanzamiento();
        $trailer = $videojuego->getTrailer();
        $id = $videojuego->getId();
        $stmt->bind_param('ssssissi',$titulo, $desarrollador, $descripcion, $foto, $idCategoria, $fechaLanzamiento, $trailer, $id);
        return $stmt->execute();
    }


    /**
     * Borrar el videojuego de la tabla videojuegos del id pasado por parámetro
     * @return true si ha borrado el videojuego y false si no la ha borrado (por que no existia)
     */
    function delete($id):bool{

        if(!$stmt = $this->conn->prepare("DELETE FROM videojuegos WHERE id = ?"))
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
     * Obtener Videojuegos por Categoria
     */
    function obtenerVideojuegosPorCategoria($idCategoria){
        if(!$stmt = $this->conn->prepare("SELECT * FROM videojuegos WHERE idCategoria = ?")){
            echo "Error en la SQL: " . $this->conn->error;
        }

        $videojuegosPorCategoria = [];

        //Asociamos las variables a las interrogaciones(parámetros)
        $stmt->bind_param('i',$idCategoria);

        //Ejecutamos la SQL
        if ($stmt->execute()) {
            // Obtener el resultado de la SQL
            $result = $stmt->get_result();

            // Recorremos los resultados y almacenamos cada fila como un objeto Videojuego en el array
            while ($videojuego = $result->fetch_object(Videojuego::class)) {
                $videojuegosPorCategoria[] = $videojuego;
            }
        } else {
                echo "Error al ejecutar la SQL: " . $stmt->error;
        }

        // Devolvemos el array de videojuegos
        return $videojuegosPorCategoria;
    } 


    /**
     * Obtener todas las categorias
     */
    public function obtenerTodasLasCategorias() {
        if (!$stmt = $this->conn->prepare("SELECT * FROM categorias")) {
            echo "Error en la SQL: " . $this->conn->error;
        }

        $todasCategorias = [];

        // Ejecutamos la SQL
        if ($stmt->execute()) {
            // Obtener el resultado de la SQL
            $result = $stmt->get_result();

            // Recorremos los resultados y almacenamos cada fila como un objeto Categoria en el array
            while ($categoria = $result->fetch_object(Categoria::class)) {
                $todasCategorias[] = $categoria;
            }
        } else {
            echo "Error al ejecutar la SQL: " . $stmt->error;
        }
    
        // Devolvemos el array de categorías
        return $todasCategorias;
    }
    

        

        /* Recogemos las peliculas que no han sido prestadas, es decir,
        las que han sido devueltas, que será para el booleano un 0(devuelto), para poder prestarlas después de nuevo. */
        /* public function obtenerPeliculasDisponibles():array { 
            if(!$stmt = $this->conn->prepare("SELECT * FROM peliculas WHERE id NOT IN(SELECT IdPelicula from prestamos WHERE devuelta=false)"))
        {
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
        } */

}


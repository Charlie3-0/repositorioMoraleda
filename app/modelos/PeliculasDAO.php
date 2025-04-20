<?php 

class PeliculasDAO {
    private mysqli $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }


    /**
     * Obtener una pelicula de la BD en función del id pasado
     * @return Pelicula Devuelve el objeto Pelicula o null si no lo encuentra
     */
    public function getById($id):Pelicula|null {
        if(!$stmt = $this->conn->prepare("SELECT * FROM peliculas WHERE id = ?")) {
            echo "Error en la SQL: " . $this->conn->error;
        }
        //Asociar las variables a las interrogaciones(parámetros)
        $stmt->bind_param('i',$id);
        //Ejecutamos la SQL
        $stmt->execute();
        //Obtener el objeto mysql_result
        $result = $stmt->get_result();

        //Si ha encontrado algún resultado devolvemos un objeto de la clase Pelicula, sino null
        if($result->num_rows == 1){
            $pelicula = $result->fetch_object(Pelicula::class);
            return $pelicula;
        }
        else{
            return null;
        }
    }


    /**
     * Obtener todas las peliculas de la tabla peliculas
     * @return array Devuelve un array de objetos Pelicula
     */
    public function getAll():array {
        if(!$stmt = $this->conn->prepare("SELECT * FROM peliculas"))
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
    }


    /**
     * Insertar en la base de datos la pelicula que recibe como parámetro
     * @return idPelicula Devuelve el id autonumérico que se le ha asignado a la pelicula o false en caso de error
     */
    function insert(Pelicula $pelicula): int|bool{
        if(!$stmt = $this->conn->prepare("INSERT INTO peliculas (titulo, director, descripcion, foto, idCategoria) VALUES (?,?,?,?,?)")){
            die("Error al preparar la consulta insert: " . $this->conn->error );
        }
        $titulo = $pelicula->getTitulo();
        $director = $pelicula->getDirector();
        $descripcion = $pelicula->getDescripcion();
        $foto = $pelicula->getFoto();
        $idCategoria = $pelicula->getIdCategoria();
        $stmt->bind_param('ssssi',$titulo, $director, $descripcion, $foto, $idCategoria);
        if($stmt->execute()){
            return $stmt->insert_id;
        }
        else{
            return false;
        }
    }


    /**
     * Editar en la base de datos la pelicula
     */
    function update($pelicula){
        if(!$stmt = $this->conn->prepare("UPDATE peliculas SET titulo=?, director=?, descripcion=?, foto=?, idCategoria=? WHERE id=?")){
            die("Error al preparar la consulta update: " . $this->conn->error );
        }
        $titulo = $pelicula->getTitulo();
        $director = $pelicula->getDirector();
        $descripcion = $pelicula->getDescripcion();
        $foto = $pelicula->getFoto();
        $idCategoria = $pelicula->getIdCategoria();
        $id = $pelicula->getId();
        $stmt->bind_param('ssssii',$titulo, $director, $descripcion, $foto, $idCategoria, $id);
        return $stmt->execute();
    }


    /**
     * Borrar la pelicula de la tabla peliculas del id pasado por parámetro
     * @return true si ha borrado la pelicula y false si no la ha borrado (por que no existia)
     */
    function delete($id):bool{

        if(!$stmt = $this->conn->prepare("DELETE FROM peliculas WHERE id = ?"))
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
    


    /**
     * Obtener Peliculas por Categoria
     */
    function obtenerPeliculasPorCategoria($idCategoria){
        if(!$stmt = $this->conn->prepare("SELECT * FROM peliculas WHERE idCategoria = ?")){
            echo "Error en la SQL: " . $this->conn->error;
        }

        $peliculasPorCategoria = [];

        //Asociamos las variables a las interrogaciones(parámetros)
        $stmt->bind_param('i',$idCategoria);

        //Ejecutamos la SQL
        if ($stmt->execute()) {
                // Obtener el resultado de la SQL
                $result = $stmt->get_result();

                // Recorremos los resultados y almacenamos cada fila como un objeto Pelicula en el array
                while ($pelicula = $result->fetch_object(Pelicula::class)) {
                    $peliculasPorCategoria[] = $pelicula;
                }
            } else {
                echo "Error al ejecutar la SQL: " . $stmt->error;
            }

            // Devolvemos el array de peliculas
            return $peliculasPorCategoria;
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


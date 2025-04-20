<?php 

class CategoriasDAO {
    private mysqli $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }


    /**
     * Obtener una categoria de la BD en función del id pasado
     * @return Categoria Devuelve el objeto Categoria o null si no lo encuentra
     */
    public function getById($id):Categoria|null {
        if(!$stmt = $this->conn->prepare("SELECT * FROM categorias WHERE id = ?"))
        {
            echo "Error en la SQL: " . $this->conn->error;
        }
        //Asociar las variables a las interrogaciones(parámetros)
        $stmt->bind_param('i',$id);
        //Ejecutamos la SQL
        $stmt->execute();
        //Obtener el objeto mysql_result
        $result = $stmt->get_result();

        //Si ha encontrado algún resultado devolvemos un objeto de la clase Categoria, sino null
        if($result->num_rows == 1){
            $categoria = $result->fetch_object(Categoria::class);
            return $categoria;
        }
        else{
            return null;
        }
    }


    /**
     * Obtener todas las categorias de la tabla categorias
     * @return array Devuelve un array de objetos Categoria
     */
    public function getAll():array {
        if(!$stmt = $this->conn->prepare("SELECT * FROM categorias"))
        {
            echo "Error en la SQL: " . $this->conn->error;
        }
        //Ejecutamos la SQL
        $stmt->execute();
        //Obtener el objeto mysql_result
        $result = $stmt->get_result();

        $array_categorias = array();
        
        while($categoria = $result->fetch_object(Categoria::class)){
            $array_categorias[] = $categoria;
        }
        return $array_categorias;
    }
    
    
    /**
     * Borrar la categoria de la tabla categorias del id pasado por parámetro
     * @return true si ha borrado la categoria y false si no la ha borrado (por que no existia)
     */
    function delete($id):bool{

        if(!$stmt = $this->conn->prepare("DELETE FROM categorias WHERE id = ?"))
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
     * Insertar en la base de datos la categoria que recibe como parámetro
     * @return idCategoria Devuelve el id autonumérico que se le ha asignado a la categoria o false en caso de error
     */
    function insert(Categoria $categoria): int|bool{
        if(!$stmt = $this->conn->prepare("INSERT INTO categorias (nombre) VALUES (?)")){
            die("Error al preparar la consulta insert: " . $this->conn->error );
        }
        $nombre = $categoria->getNombre();
        $stmt->bind_param('s',$nombre);
        if($stmt->execute()){
            return $stmt->insert_id;
        }
        else{
            return false;
        }
    }


    /**
     * Editar en la base de datos la categoria
     */
    function update($categoria){
        if(!$stmt = $this->conn->prepare("UPDATE categorias SET nombre=? WHERE id=?")){
            die("Error al preparar la consulta update: " . $this->conn->error );
        }
        $nombre = $categoria->getNombre();
        $id = $categoria->getId();
        $stmt->bind_param('si',$nombre, $id);
        return $stmt->execute();
    }

}



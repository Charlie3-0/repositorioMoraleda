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
    
    

}



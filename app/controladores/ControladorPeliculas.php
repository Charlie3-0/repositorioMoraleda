<?php 

class ControladorPeliculas {

    public function inicio(){

        //Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
        $conn = $connexionDB->getConnexion();
        
        
        if(Sesion::existeSesion()){
            //Creamos el objeto PeliculasDAO para acceder a BBDD a través de este objeto
            $peliculasDAO = new PeliculasDAO($conn);
        
            // Obtener todas las categorías
            $categorias = $peliculasDAO->obtenerTodasLasCategorias();
        }    

        //Incluyo la vista
        require 'app/vistas/inicio.php';
    }

    public function inicioAdmin(){

        //Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
        $conn = $connexionDB->getConnexion();
        
        
        if(Sesion::existeSesionAdmin()){
            //Creamos el objeto PeliculasDAO para acceder a BBDD a través de este objeto
            $peliculasDAO = new PeliculasDAO($conn);
        
            // Obtener todas las categorías
            $categorias = $peliculasDAO->obtenerTodasLasCategorias();
        }    

        //Incluyo la vista
        require '../app/vistas/inicioAdmin.php';
    }


    // FUNCIÓN PARA VER CADA PELICULA PARA USUARIOS
    public function verPelicula(){
        // Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
        $conn = $connexionDB->getConnexion();

        // Creamos los objetos DAO necesarios para acceder a BBDD a través de estos objetos
        $peliculasDAO = new PeliculasDAO($conn);
        $reservasDAO = new ReservasDAO($conn);
        $categoriasDAO = new CategoriasDAO($conn);
        $prestamosDAO = new PrestamosDAO($conn);
        $peliculasVistasDAO = new Peliculas_vistasDAO($conn);
        $peliculasUsuariosDAO = new Peliculas_usuariosDAO($conn);
        $comentariosDAO = new ComentariosDAO($conn);
        $usuariosDAO = new UsuariosDAO($conn);

        // Obtener la pelicula
        $idPelicula = htmlspecialchars($_GET['id']);
        $pelicula = $peliculasDAO->getById($idPelicula);

        // Obtener el Id de la categoria para obtener el atributo/elemento idCategoria de la clase Pelicula
        $idCategoria = $_GET['id'];
        $idCategoria = htmlspecialchars($_GET['id']);
        $categoria = $categoriasDAO->getById($idCategoria);

        // Obtener la categoría de la pelicula para poder obtener el nombre de la categoría
        $categoriaId = $pelicula->getIdCategoria();
        $categoria = $categoriasDAO->getById($categoriaId);


        // Inicializar variables comunes
        $peliculaReservada = $reservasDAO->countByIdPelicula($idPelicula); // Solo 1 o 0
        $peliculaPrestada = $prestamosDAO->countByIdPelicula($idPelicula);
        /* $peliculaVista = $peliculasVistasDAO->countByIdPelicula($idPelicula); */
        $peliculaVista = $peliculasUsuariosDAO->countByIdPelicula($idPelicula);
        $marcadaVista = false;
        $existeReserva = false;
        $usuarioReservado = null;
        $usuarioPrestamo = null;

        //$mediaPelicula = $peliculasUsuariosDAO->obtenerPuntuacionMedia($pelicula->getId());
        $totalVotos = $peliculasUsuariosDAO->contarVotosPelicula($pelicula->getId());

        // Obtener comentarios de esta película
        $comentarios = $peliculasUsuariosDAO->getComentariosPorPelicula($idPelicula);

        // Solo si hay sesión
        if (Sesion::existeSesion()) {
            $usuario = Sesion::getUsuario();

            if ($usuario->getRol() === 'U') {
                // Lógica para usuarios normales
                $existeReserva = $reservasDAO->existByIdUsuarioIdPelicula($usuario->getId(), $idPelicula);
                /* $marcadaVista = $peliculasVistasDAO->estaMarcadaComoVista($usuario->getId(), $idPelicula); */
                $marcadaVista = $peliculasUsuariosDAO->estaMarcadaComoVista($usuario->getId(), $idPelicula);

            } elseif ($usuario->getRol() === 'A') {
                // Lógica extra para admins
                $usuarioReservado = $peliculaReservada ? $reservasDAO->getUsuarioReservaPorPeliculaId($idPelicula) : null;
                $usuarioPrestamo = $prestamosDAO->getUsuarioPrestamoPorPeliculaId($idPelicula);
            }
        }

        /* // Comprobar si existe una reserva para la pelicula
        $existeReserva = $reservasDAO->existByIdUsuarioIdPelicula(Sesion::getUsuario()->getId(), $idPelicula);

        // Obtener el número de reservas para la pelicula
        $peliculaReservada = $reservasDAO->countByIdPelicula($idPelicula);

        // Obtener el número de préstamos para el libro(en nuestro caso será solo 1)
        $peliculaPrestada = $prestamosDAO->countByIdPelicula($idPelicula);

        // Comprobar si el usuario ha marcado la película como vista (estado individual)
        $marcadaVista = false;  // Valor inicial por si no hay sesion. Evita errores
        if (Sesion::existeSesion()) {   // Comprobar si el usuario está conectado
            $marcadaVista = $peliculasVistasDAO->estaMarcadaComoVista(Sesion::getUsuario()->getId(), $idPelicula);  // Verificar si este usuario ha marcado esta película
        }
        
        // Obtener el número de vistas para la pelicula
        $peliculaVista = $peliculasVistasDAO->countByIdPelicula($idPelicula); */   // Cuenta cuántos usuarios han marcado esta película como vista

        require 'app/vistas/ver_pelicula.php';
    }


    // FUNCIÓN PARA VER CADA PELICULA PARA ADMINISTRADOR
    public function verPeliculaAdmin(){
        // Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
        $conn = $connexionDB->getConnexion();

        // Creamos los objetos DAO necesarios para acceder a BBDD a través de estos objetos
        $peliculasDAO = new PeliculasDAO($conn);
        $reservasDAO = new ReservasDAO($conn);
        $categoriasDAO = new CategoriasDAO($conn);
        $prestamosDAO = new PrestamosDAO($conn);
        $usuariosDAO = new UsuariosDAO($conn);
        $peliculasVistasDAO = new Peliculas_vistasDAO($conn);
        $comentariosDAO = new ComentariosDAO($conn);

        // Obtener la pelicula
        $idPelicula = htmlspecialchars($_GET['id']);
        $pelicula = $peliculasDAO->getById($idPelicula);

        // Obtener el Id de la categoria para obtener el atributo/elemento idCategoria de la clase Pelicula
        $idCategoria = $_GET['id'];
        $idCategoria = htmlspecialchars($_GET['id']);
        $categoria = $categoriasDAO->getById($idCategoria);

        // Obtener la categoría de la pelicula para poder obtener el nombre de la categoría
        $categoriaId = $pelicula->getIdCategoria();
        $categoria = $categoriasDAO->getById($categoriaId);


        /* // Comprobar si existe una reserva para la pelicula
        $existeReserva = $reservasDAO->existByIdUsuarioIdPelicula(Sesion::getUsuario()->getId(), $idPelicula); */


        // Obtener el número de reservas para la pelicula(en nuestro caso será solo 1)
        $peliculaReservada = $reservasDAO->countByIdPelicula($idPelicula);

        // Obtener el usuario que ha reservado la pelicula
        $usuarioReservado = $peliculaReservada ? $reservasDAO->getUsuarioReservaPorPeliculaId($idPelicula) : null;


    /*     // Obtener el número de préstamos para la pelicula(en nuestro caso será solo 1)
        $peliculaPrestada = $prestamosDAO->countByIdPelicula($idPelicula);

        // Obtener el usuario que ha tomado prestada la pelicula (si no ha sido devuelto)
        $usuarioPrestado = $peliculaPrestada ? $prestamosDAO->getUsuarioPrestamoPorPeliculaId($idPelicula) : null; */


    /*     // Obtener el usuario que ha reservado la pelicula
        $usuarioReserva = $reservasDAO->getUsuarioReservaPorPeliculaId($idPelicula);

        // Obtener el número de reservas para la pelicula (en nuestro caso será solo 1)
        $peliculaReservada = $reservasDAO->countByIdPelicula($idPelicula);
 */

        // Obtener el usuario que tiene la pelicula prestada o el estado de disponibilidad
        $usuarioPrestamo = $prestamosDAO->getUsuarioPrestamoPorPeliculaId($idPelicula);

        // Obtener el número de préstamos para la pelicula (en nuestro caso será solo 1)
        $peliculaPrestada = $prestamosDAO->countByIdPelicula($idPelicula);

        // var_dump($categoria);die();

        require '../app/vistas/ver_pelicula_admin.php';
    }


    // FUNCIÓN PARA VER LAS PELICULAS POR CATEGORÍA PARA USUARIOS
    public function verPeliculasPorCategoria() {
        //Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
        $conn = $connexionDB->getConnexion();

        $idCategoria = $_GET['id'];

        //Creamos el objeto PeliculasDAO para acceder a BBDD a través de este objeto
        $peliculasDAO = new PeliculasDAO($conn);

        $categoriasDAO = new CategoriasDAO($conn);


        // Obtener las peliculas por categoría
        $peliculas = $peliculasDAO->obtenerPeliculasPorCategoria($idCategoria);

        $idCategoria = htmlspecialchars($_GET['id']);
        $categoria = $categoriasDAO->getById($idCategoria);

        // Incluir la vista de peliculas por categoría
        require 'app/vistas/peliculas_por_categoria.php';
    }


    // FUNCIÓN PARA VER LAS PELICULAS POR CATEGORÍA PARA ADMINISTRADOR
    public function verPeliculasPorCategoriaAdmin() {
        //Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
        $conn = $connexionDB->getConnexion();

        $idCategoria = $_GET['id'];

        //Creamos el objeto PeliculasDAO para acceder a BBDD a través de este objeto
        $peliculasDAO = new PeliculasDAO($conn);

        $categoriasDAO = new CategoriasDAO($conn);


        // Obtener las peliculas por categoría
        $peliculas = $peliculasDAO->obtenerPeliculasPorCategoria($idCategoria);

        $idCategoria = htmlspecialchars($_GET['id']);
        $categoria = $categoriasDAO->getById($idCategoria);

        // Incluir la vista de peliculas por categoría
        require '../app/vistas/peliculas_por_categoria_admin.php';
    }
    

    public function insertarPelicula() {
        $error = '';
    
        // Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnexion();
    
        // Creamos los objetos DAO necesarios para acceder a BBDD a través de estos objetos
        $categoriasDAO = new CategoriasDAO($conn);
    
        // Obtener todas las categorías
        $categorias = $categoriasDAO->getAll();
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Limpiamos los datos que vienen del formulario
            $titulo = htmlspecialchars($_POST['titulo']);
            $director = htmlspecialchars($_POST['director']);
            $descripcion = htmlspecialchars($_POST['descripcion']);
            $idCategoria = htmlspecialchars($_POST['idCategoria']);

            // Aquí manejamos la foto
            $foto_nombre = $_FILES['foto']['name'];   // Nombre de la foto
            $foto_temporal = $_FILES['foto']['tmp_name'];   // Ubicación temporal de la foto
            $ruta_destino = 'web/images/' . $foto_nombre;    // Ruta donde se guardará la foto
    
    
            // Validamos los datos
            if (empty($titulo) || empty($director) || empty($descripcion) || empty($idCategoria)) {
                $error = "Todos los campos son obligatorios.";
            } else {

                // Creamos el objeto DAO necesario para acceder a las peliculas en la base de datos
                $peliculasDAO = new PeliculasDAO($conn);
    
                // Insertamos la pelicula
                $pelicula = new Pelicula();
                $pelicula->setTitulo($titulo);
                $pelicula->setDirector($director);
                $pelicula->setDescripcion($descripcion);
                // $pelicula>setFoto("");
                $pelicula->setIdCategoria($idCategoria);

                // Movemos la foto al directorio final y guardamos la ruta en el objeto Pelicula
                if (move_uploaded_file($foto_temporal, $ruta_destino)) {
                    $pelicula->setFoto($foto_nombre);
                } else {
                    $error = "Error al cargar la foto.";
                }
    
                if ($peliculasDAO->insert($pelicula)) {
                    echo "La pelicula se ha insertado correctamente.";
                } else {
                    echo "Error al insertar la pelicula.";
                }
    
                // Redireccionamos a las categorías
                header('location: index.php?accion=peliculas_por_categoria&id=' . $pelicula->getIdCategoria());
                die();
            }
        }
    
        // Cargamos la vista de insertar pelicula
        require 'app/vistas/insertar_pelicula.php';
    }
    

    public function editarPelicula(){
        $error ='';
    
        // Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnexion();
    
        // Obtenemos el ID de la pelicula que viene por GET
        $idPelicula = htmlspecialchars($_GET['id']);
    
        // Obtenemos la pelicula de la base de datos
        $peliculasDAO = new PeliculasDAO($conn);
        $pelicula = $peliculasDAO->getById($idPelicula);
    
        // Obtenemos las categorías de la base de datos
        $categoriasDAO = new CategoriasDAO($conn);
        $categorias = $categoriasDAO->getAll();
    
        // Cuando se envíe el formulario, actualizamos la pelicula en la base de datos
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Limpiamos los datos que vienen del formulario
            $titulo = htmlspecialchars($_POST['titulo']);
            $director = htmlspecialchars($_POST['director']);
            $descripcion = htmlspecialchars($_POST['descripcion']);
            $idCategoria = htmlspecialchars($_POST['idCategoria']);

    
            // Validamos los datos
            if(empty($titulo) || empty($director) || empty($descripcion) || empty($idCategoria)){
                $error = "Todos los campos son obligatorios.";
            }else{
                // Actualizamos los datos de la pelicula
                $pelicula->setTitulo($titulo);
                $pelicula->setDirector($director);
                $pelicula->setDescripcion($descripcion);
                // $pelicula->setFoto($foto); // Aquí manejamos la foto
                $pelicula->setIdCategoria($idCategoria);

                // Manejamos la foto si se está subiendo una nueva
                if(isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK){
                    $foto_nombre = $_FILES['foto']['name'];    // Nombre de la foto
                    $foto_temporal = $_FILES['foto']['tmp_name'];   // Ubicación temporal de la foto
                    $ruta_destino = 'web/images/' . $foto_nombre;    // Ruta donde se guardará la foto
                    
                    // Movemos la imagen a la carpeta de imágenes
                    if(move_uploaded_file($foto_temporal, $ruta_destino)){
                        $pelicula->setFoto($foto_nombre);
                    }else{
                        $error = "Error al subir la imagen.";
                    }
                }
    
                if ($peliculasDAO->update($pelicula)) {
                    echo "La pelicula se ha actualizado correctamente.";
                } else {
                    echo "Error al actualizar la pelicula.";
                }
    
                // Redireccionamos a la vista de la Pelicula
                header('location: index.php?accion=ver_pelicula&id=' . $pelicula->getId());
                die();
            }
        }
    
        // Cargamos la vista de editar pelicula
        require 'app/vistas/editar_pelicula.php';
    }


    public function eliminarPelicula(){
        $error ='';

        // Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnexion();

    }

}
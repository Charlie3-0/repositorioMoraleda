<?php 

class ControladorVideojuegos {

    public function inicio(){

        //Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
        $conn = $connexionDB->getConnexion();
        
        
        if(Sesion::existeSesion()){
            //Creamos el objeto VideojuegosDAO para acceder a BBDD a través de este objeto
            $videojuegosDAO = new VideojuegosDAO($conn);
        
            // Obtener todas las categorías
            $categorias = $videojuegosDAO->obtenerTodasLasCategorias();
        }    

        //Incluyo la vista
        require 'app/vistas/inicio.php';
    }


    // FUNCIÓN PARA VER CADA VIDEOJUEGO PARA USUARIOS
    public function verVideojuego(){
        // Comprobamos si hay sesión y si hay un usuario conectado
        $usuario = Sesion::getUsuario();
        if (!$usuario) {
            $_SESSION['mensaje_error'] = 'Acceso denegado.';
            header('location: index.php');
            exit;
        }

        // Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
        $conn = $connexionDB->getConnexion();

        // Creamos los objetos DAO necesarios para acceder a BBDD a través de estos objetos
        $videojuegosDAO = new VideojuegosDAO($conn);
        $reservasDAO = new ReservasDAO($conn);
        $categoriasDAO = new CategoriasDAO($conn);
        $prestamosDAO = new PrestamosDAO($conn);
        $videojuegosProbadosDAO = new Videojuegos_probadosDAO($conn);
        //$peliculasUsuariosDAO = new Peliculas_usuariosDAO($conn);
        $comentariosDAO = new ComentariosDAO($conn);
        $puntuacionesDAO = new PuntuacionesDAO($conn);
        $usuariosDAO = new UsuariosDAO($conn);

        // Obtener el videojuego
        $idVideojuego = htmlspecialchars($_GET['id']);
        $videojuego = $videojuegosDAO->getById($idVideojuego);

        // Obtener el Id de la categoria para obtener el atributo/elemento idCategoria de la clase Videojuego
        /* $idCategoria = $_GET['id'];
        $idCategoria = htmlspecialchars($_GET['id']);
        $categoria = $categoriasDAO->getById($idCategoria); */

        // Obtener la categoría del videojuego para poder obtener el nombre de la categoría
        $categoriaId = $videojuego->getIdCategoria();
        $categoria = $categoriasDAO->getById($categoriaId);

        /* $rolUsuario = $usuariosDAO->getRol(); */

        // Inicializar variables comunes
        $videojuegoReservado = $reservasDAO->countByIdVideojuego($idVideojuego); // Solo 1 o 0
        $videojuegoPrestado = $prestamosDAO->countByIdVideojuego($idVideojuego);
        $videojuegoProbado = $videojuegosProbadosDAO->countByIdVideojuego($idVideojuego);
        /* $puntuacionVideojuego = $puntuacionesDAO->countByIdVideojuego($idVideojuego); */
        /* $peliculaVista = $peliculasUsuariosDAO->countByIdPelicula($idVideojuego); */
        $marcadoProbado = false;
        $existeReserva = false;
        $usuarioReservado = null;
        $usuarioPrestamo = null;

        //$mediaPelicula = $peliculasUsuariosDAO->obtenerPuntuacionMedia($pelicula->getId());
        /* $totalVotos = $peliculasUsuariosDAO->contarVotosPelicula($pelicula->getId());

        // Obtener comentarios de esta película
        $comentarios = $peliculasUsuariosDAO->getComentariosPorPelicula($idPelicula);
        $comentarioUsuarioActual = $peliculasUsuariosDAO->getComentarioPorUsuario($idPelicula, $usuario->getId()); */

        //$mediaVideojuego = $puntuacionesDAO->obtenerPuntuacionMedia($videojuego->getId());
        $totalVotos = $puntuacionesDAO->contarVotosVideojuego($videojuego->getId());

        // Obtener comentarios de este videojuego
        $comentarios = $comentariosDAO->getComentariosPorVideojuego($idVideojuego);
        /* $comentarioUsuarioActual = $comentariosDAO->getComentarioPorUsuario($idVideojuego, $usuario->getId()); */


        // Solo si hay sesión
        if (Sesion::existeSesion()) {
            $usuario = Sesion::getUsuario();
/* 
            //$mediaVideojuego = $puntuacionesDAO->obtenerPuntuacionMedia($videojuego->getId());
            $totalVotos = $puntuacionesDAO->contarVotosVideojuego($videojuego->getId());

            // Obtener comentarios de este videojuego
            $comentarios = $comentariosDAO->getComentariosPorVideojuego($idVideojuego); */
            /* $comentarioUsuarioActual = $comentariosDAO->getComentarioPorUsuario($idVideojuego, $usuario->getId()); */

            if ($usuario->getRol() === 'U') {
                // Lógica para usuarios normales
                $existeReserva = $reservasDAO->existByIdUsuarioIdVideojuego($usuario->getId(), $idVideojuego);
                /* $marcadaVista = $peliculasVistasDAO->estaMarcadaComoVista($usuario->getId(), $idVideojuego); */
                $marcadoProbado = $videojuegosProbadosDAO->estaMarcadoComoProbado($usuario->getId(), $idVideojuego);
                /* $videojuegoProbado = $videojuegosProbadosDAO->existByIdUsuarioIdVideojuego($usuario->getId(), $idVideojuego); */

            } elseif ($usuario->getRol() === 'A') {
                // Lógica para admins
                $usuarioReservado = $videojuegoReservado ? $reservasDAO->getUsuarioReservaPorVideojuegoId($idVideojuego) : null;
                $usuarioPrestamo = $prestamosDAO->getUsuarioPrestamoPorVideojuegoId($idVideojuego);
            }
        }


        require 'app/vistas/ver_videojuego.php';
    }


    // FUNCIÓN PARA VER LOS VIDEOJUEGOS POR CATEGORÍA PARA USUARIOS
    public function verVideojuegosPorCategoria() {
        // Comprobamos si hay sesión y si hay un usuario conectado
        $usuario = Sesion::getUsuario();
        if (!$usuario) {
            $_SESSION['mensaje_error'] = 'Acceso denegado.';
            header('location: index.php');
            exit;
        }

        //Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
        $conn = $connexionDB->getConnexion();

        $idCategoria = $_GET['id'];

        //Creamos el objeto VideojuegosDAO para acceder a BBDD a través de este objeto
        $videojuegosDAO = new VideojuegosDAO($conn);

        $categoriasDAO = new CategoriasDAO($conn);
        $puntuacionesDAO = new PuntuacionesDAO($conn);

        // Obtener el videojuego
        $idVideojuego = htmlspecialchars($_GET['id']);
        $videojuego = $videojuegosDAO->getById($idVideojuego);

        // Obtener los videojuegos por categoría
        $videojuegos = $videojuegosDAO->obtenerVideojuegosPorCategoria($idCategoria);

        $idCategoria = htmlspecialchars($_GET['id']);
        $categoria = $categoriasDAO->getById($idCategoria);

        //$mediaVideojuego = $puntuacionesDAO->obtenerPuntuacionMedia($videojuego->getId());
        $totalVotos = $puntuacionesDAO->contarVotosVideojuego($videojuego->getId());

        // Incluir la vista de videojuegos por categoría
        require 'app/vistas/videojuegos_por_categoria.php';
    }
    

    public function insertarVideojuego() {
        // Comprobamos si hay sesión y si el usuario es administrador
        $usuario = Sesion::getUsuario();
        if (!$usuario || $usuario->getRol() !== 'A') {
            $_SESSION['mensaje_error'] = 'Acceso denegado.';
            header('location: index.php');
            exit;
        }
    
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
            $desarrollador = htmlspecialchars($_POST['desarrollador']);
            $descripcion = htmlspecialchars($_POST['descripcion']);
            $idCategoria = htmlspecialchars($_POST['idCategoria']);
            $fechaLanzamiento = htmlspecialchars($_POST['fecha_lanzamiento']);
            $trailer = htmlspecialchars($_POST['trailer']); // Permitimos iframe, así que usamos htmlspecialchars para evitar XSS

            // Aquí manejamos la foto
            $foto_nombre = $_FILES['foto']['name'];   // Nombre de la foto
            $foto_temporal = $_FILES['foto']['tmp_name'];   // Ubicación temporal de la foto
            $ruta_destino = 'web/images/' . $foto_nombre;    // Ruta donde se guardará la foto
    
    
            // Validamos los datos
            if (empty($titulo) || empty($desarrollador) || empty($descripcion) || empty($idCategoria) || empty($fechaLanzamiento) || empty($trailer) || empty($foto_nombre)) {
            //    $error = "Todos los campos son obligatorios.";
                $_SESSION['mensaje_error'] = "Todos los campos son obligatorios.";
            } else {

                // Creamos el objeto DAO necesario para acceder a los videojuegos en la base de datos
                $videojuegosDAO = new VideojuegosDAO($conn);
    
                // Insertamos el videojuego
                $videojuego = new Videojuego();
                $videojuego->setTitulo($titulo);
                $videojuego->setDesarrollador($desarrollador);
                $videojuego->setDescripcion($descripcion);
                $videojuego->setIdCategoria($idCategoria);
                $videojuego->setFechaLanzamiento($fechaLanzamiento);
                $videojuego->setTrailer($trailer);


                // Movemos la foto al directorio final y guardamos la ruta en el objeto Videojuego
                if (move_uploaded_file($foto_temporal, $ruta_destino)) {
                    $videojuego->setFoto($foto_nombre);
                } else {
                    $_SESSION['mensaje_error'] = "Error al cargar la foto.";
                }
    

                if ($videojuegosDAO->insert($videojuego)) {
                    $_SESSION['mensaje_ok'] = "El videojuego se ha creado correctamente.";
                    header('location: index.php?accion=videojuegos_por_categoria&id=' . $videojuego->getIdCategoria());
                    die();
                } else {
                    $_SESSION['mensaje_error'] = "Error al insertar el videojuego.";
                }
            }
        }
    
        // Cargamos la vista de insertar videojuego
        require 'app/vistas/insertar_videojuego.php';
    }
    

    public function editarVideojuego(){
        // Comprobamos si hay sesión y si el usuario es administrador
        $usuario = Sesion::getUsuario();
        if (!$usuario || $usuario->getRol() !== 'A') {
            $_SESSION['mensaje_error'] = 'Acceso denegado.';
            header('location: index.php');
            exit;
        }

        // Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnexion();
    
        // Obtenemos el ID del videojuego que viene por GET
        $idVideojuego = htmlspecialchars($_GET['id']);
    
        // Obtenemos el videojuego de la base de datos
        $videojuegosDAO = new VideojuegosDAO($conn);
        $videojuego = $videojuegosDAO->getById($idVideojuego);
    
        // Obtenemos las categorías de la base de datos
        $categoriasDAO = new CategoriasDAO($conn);
        $categorias = $categoriasDAO->getAll();
    
        // Cuando se envíe el formulario, actualizamos la pelicula en la base de datos
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Limpiamos los datos que vienen del formulario
            $titulo = htmlspecialchars($_POST['titulo']);
            $desarrollador = htmlspecialchars($_POST['desarrollador']);
            $descripcion = htmlspecialchars($_POST['descripcion']);
            $idCategoria = htmlspecialchars($_POST['idCategoria']);
            $fechaLanzamiento = htmlspecialchars($_POST['fecha_lanzamiento']);
            $trailer = htmlspecialchars($_POST['trailer']);
          //  $trailer = $_POST['trailer'];

    
            // Validamos los datos
            if(empty($titulo) || empty($desarrollador) || empty($descripcion) || empty($idCategoria) || empty($fechaLanzamiento) || empty($trailer)) {
             //   $error = "Todos los campos son obligatorios.";
                $_SESSION['mensaje_error'] = "Todos los campos son obligatorios.";
            }else{
                // Actualizamos los datos del videojuego
                $videojuego->setTitulo($titulo);
                $videojuego->setDesarrollador($desarrollador);
                $videojuego->setDescripcion($descripcion);
                // $videojuego->setFoto($foto); // Aquí manejamos la foto
                $videojuego->setIdCategoria($idCategoria);
                $videojuego->setFechaLanzamiento($fechaLanzamiento);
                $videojuego->setTrailer($trailer);


                // Manejamos la foto si se está subiendo una nueva
                if(isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK){
                    $foto_nombre = $_FILES['foto']['name'];    // Nombre de la foto
                    $foto_temporal = $_FILES['foto']['tmp_name'];   // Ubicación temporal de la foto
                    $ruta_destino = 'web/images/' . $foto_nombre;    // Ruta donde se guardará la foto
                    
                    // Movemos la imagen a la carpeta de imágenes
                    if(move_uploaded_file($foto_temporal, $ruta_destino)){
                        $videojuego->setFoto($foto_nombre);
                    }else{
                     //   $error = "Error al subir la imagen.";
                        $_SESSION['mensaje_error'] = "Error al subir la imagen.";
                    }
                }
    
                if ($videojuegosDAO->update($videojuego)) {
                 //   echo "El videojuego se ha actualizado correctamente.";
                    $_SESSION['mensaje_ok'] = "El videojuego se ha actualizado correctamente.";
                    header('location: index.php?accion=ver_videojuego&id=' . $videojuego->getId());
                    die();
                } else {
                 //   echo "Error al actualizar el videojuego.";
                    $_SESSION['mensaje_error'] = "Error al actualizar el videojuego.";
                }
    
            /*     // Redireccionamos a la vista del Videojuego
                header('location: index.php?accion=ver_videojuego&id=' . $videojuego->getId());
                die(); */
            }
        }
    
        // Cargamos la vista de editar videojuego
        require 'app/vistas/editar_videojuego.php';
    }


    public function eliminarVideojuego(){
        // Comprobamos si hay sesión y si el usuario es administrador
        $usuario = Sesion::getUsuario();
        if (!$usuario || $usuario->getRol() !== 'A') {
            $_SESSION['mensaje_error'] = 'Acceso denegado.';
            header('location: index.php');
            exit;
        }

        // Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnexion();

        //Creamos el objeto VideojuegosDAO para acceder a BBDD a través de este objeto
        $videojuegosDAO = new VideojuegosDAO($conn);

        //Obtener el videojuego que se quiere eliminar
        $idVideojuego = htmlspecialchars($_GET['id']);
        $videojuego = $videojuegosDAO->getById($idVideojuego);

        // Verificamos si existe el videojuego antes de eliminar
        $videojuego = $videojuegosDAO->getById($idVideojuego);
        if (!$videojuego) {
            $_SESSION['mensaje_error'] = 'El videojuego no existe.';
            header('location: index.php?accion=configuraciones_videojuegos');
            exit;
        }

        // Intentamos eliminar el videojuego
        if ($videojuegosDAO->delete($idVideojuego)) {
            $_SESSION['mensaje_ok'] = 'Videojuego eliminado correctamente.';
        } else {
            $_SESSION['mensaje_error'] = 'Error al eliminar el videojuego.';
        }

        // Redirigimos de nuevo a configuraciones
        header('location: index.php?accion=configuraciones_videojuegos');
        exit;
        
    }


    public function configuracionesVideojuegos() {
        // Comprobamos si hay sesión y si el usuario es administrador
        $usuario = Sesion::getUsuario();
        if (!$usuario || $usuario->getRol() !== 'A') {
            $_SESSION['mensaje_error'] = 'Acceso denegado.';
            header('location: index.php');
            exit;
        }

        // Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnexion();

        // Creamos el objeto VideojuegosDAO para acceder a BBDD a través de este objeto
        $videojuegosDAO = new VideojuegosDAO($conn);
        $usuariosDAO = new UsuariosDAO($conn);
        $categoriasDAO = new CategoriasDAO($conn);
        $reservasDAO = new ReservasDAO($conn);
        $prestamosDAO = new PrestamosDAO($conn);

        // Obtenemos todos los videojuegos
        $videojuegos = $videojuegosDAO->getAll();
        // Obtenemos todos los usuarios
        $usuarios = $usuariosDAO->getAll();
        // Obtenemos todas las reservas
        $reservas = $reservasDAO->getAll();
        // Obtenemos todos los préstamos
        $prestamos = $prestamosDAO->getAll();

        // Obtener el videojuego
    /*     $idVideojuego = htmlspecialchars($_GET['id']);
        $videojuego = $videojuegosDAO->getById($idVideojuego); */

        // Obtener la categoría del videojuego
        /* $idCategoria = $_GET['id'];
        $idCategoria = htmlspecialchars($_GET['id']);
        $categoria = $categoriasDAO->getById($idCategoria); */

        // Obtener la categoría del videojuego para poder obtener el nombre de la categoría
        /* $categoriaId = $videojuego->getIdCategoria();
        $categoria = $categoriasDAO->getById($categoriaId); */

        // Inicializar variables comunes
    /*     $videojuegoReservado = $reservasDAO->countByIdVideojuego($idVideojuego); // Solo 1 o 0
        $videojuegoPrestado = $prestamosDAO->countByIdVideojuego($idVideojuego); */
        $existeReserva = false;
        $usuarioReservado = null;
        $usuarioPrestamo = null;
        $prestamoActivo = false;

        // Solo si hay sesión
        if (Sesion::existeSesion()) {
            $usuario = Sesion::getUsuario();

            if ($usuario->getRol() === 'A') {
                // Lógica para administradores
       /*          $existeReserva = $reservasDAO->existByIdUsuarioIdVideojuego($usuario->getId(), $idVideojuego);
                $usuarioReservado = $videojuegoReservado ? $reservasDAO->getUsuarioReservaPorVideojuegoId($idVideojuego) : null;
                $usuarioPrestamo = $prestamosDAO->getUsuarioPrestamoPorVideojuegoId($idVideojuego); */
            }
        }

        require 'app/vistas/configuraciones.php';
    }


    public function buscarVideojuegosAjax() {
        if (!Sesion::getUsuario()) {
            echo json_encode([]);
            return;
        }
    
        // Crear conexión a la base de datos
    //    require_once 'app/core/ConnexionDB.php'; // Asegúrate de incluirlo si no está incluido
        $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnexion();
    
        $query = isset($_GET['query']) ? trim($_GET['query']) : '';
        require_once 'app/modelos/VideojuegosDAO.php';
        $videojuegosDAO = new VideojuegosDAO($conn);
        $resultados = $videojuegosDAO->buscarPorTitulo($query);
    
        $respuesta = array_map(function($videojuego) {
            return [
                'id' => $videojuego->getId(),
                'titulo' => $videojuego->getTitulo()
            ];
        }, $resultados);
    
        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }
    
    
    


}
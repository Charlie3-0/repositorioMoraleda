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


    // FUNCIÓN PARA VER CADA VIDEOJUEGO
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
        $comentariosDAO = new ComentariosDAO($conn);
        $puntuacionesDAO = new PuntuacionesDAO($conn);
        $usuariosDAO = new UsuariosDAO($conn);

        // Obtener el videojuego
        $idVideojuego = htmlspecialchars($_GET['id']);
        $videojuego = $videojuegosDAO->getById($idVideojuego);

        // Obtener la categoría del videojuego para poder obtener el nombre de la categoría
        $categoriaId = $videojuego->getIdCategoria();
        $categoria = $categoriasDAO->getById($categoriaId);

        // Inicializar variables comunes
        $videojuegoReservado = $reservasDAO->countByIdVideojuego($idVideojuego);
        $videojuegoPrestado = $prestamosDAO->countByIdVideojuego($idVideojuego);
        $videojuegoProbado = $videojuegosProbadosDAO->countByIdVideojuego($idVideojuego);
        $marcadoProbado = false;
        $existeReserva = false;
        $usuarioReservado = null;
        $usuarioPrestamo = null;

        // Obtener el total de votos del videojuego
        $totalVotos = $puntuacionesDAO->contarVotosVideojuego($videojuego->getId());

        // Obtener comentarios de este videojuego
        $comentarios = $comentariosDAO->getComentariosPorVideojuego($idVideojuego);


        // Solo si hay sesión
        if (Sesion::existeSesion()) {
            $usuario = Sesion::getUsuario();

            $usuarioPrestamo = $prestamosDAO->getUsuarioPrestamoPorVideojuegoId($idVideojuego);

            if ($usuario->getRol() === 'U') {
                // Lógica para usuarios normales
                $existeReserva = $reservasDAO->existByIdUsuarioIdVideojuego($usuario->getId(), $idVideojuego);
                $marcadoProbado = $videojuegosProbadosDAO->estaMarcadoComoProbado($usuario->getId(), $idVideojuego);

            } elseif ($usuario->getRol() === 'A') {
                // Lógica para administradores
                $usuarioReservado = $videojuegoReservado ? $reservasDAO->getUsuarioReservaPorVideojuegoId($idVideojuego) : null;
            }
        }

        require 'app/vistas/ver_videojuego.php';
    }


    // FUNCIÓN PARA VER LOS VIDEOJUEGOS POR CATEGORÍA
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

        $totalVotos = $puntuacionesDAO->contarVotosVideojuego($videojuego->getId());

        // Incluir la vista de videojuegos por categoría
        require 'app/vistas/videojuegos_por_categoria.php';
    }
    

    // Función para insertar un nuevo videojuego
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
            $trailer = htmlspecialchars($_POST['trailer']);

            // Aquí manejamos la foto
            $foto_nombre = $_FILES['foto']['name'];   // Nombre de la foto
            $foto_temporal = $_FILES['foto']['tmp_name'];   // Ubicación temporal de la foto
            $ruta_destino = 'web/images/' . $foto_nombre;    // Ruta donde se guardará la foto
    
    
            // Validamos los datos
            if (empty($titulo) || empty($desarrollador) || empty($descripcion) || empty($idCategoria) || empty($fechaLanzamiento) || empty($trailer) || empty($foto_nombre)) {
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
    
                // Insertamos el videojuego en la base de datos
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
    

    // Función para editar un videojuego
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


            // Validamos los datos
            if(empty($titulo) || empty($desarrollador) || empty($descripcion) || empty($idCategoria) || empty($fechaLanzamiento) || empty($trailer)) {
                $_SESSION['mensaje_error'] = "Todos los campos son obligatorios.";
            }else{
                // Actualizamos los datos del videojuego
                $videojuego->setTitulo($titulo);
                $videojuego->setDesarrollador($desarrollador);
                $videojuego->setDescripcion($descripcion);
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
                        $_SESSION['mensaje_error'] = "Error al subir la imagen.";
                    }
                }
    
                if ($videojuegosDAO->update($videojuego)) {
                    $_SESSION['mensaje_ok'] = "El videojuego se ha actualizado correctamente.";
                    header('location: index.php?accion=ver_videojuego&id=' . $videojuego->getId());
                    die();
                } else {
                    $_SESSION['mensaje_error'] = "Error al actualizar el videojuego.";
                }
    
            }
        }
    
        // Cargamos la vista de editar videojuego
        require 'app/vistas/editar_videojuego.php';
    }


    // Función para eliminar un videojuego
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

        // Tratamos de eliminar el videojuego
        if ($videojuegosDAO->delete($idVideojuego)) {
            $_SESSION['mensaje_ok'] = 'Videojuego eliminado correctamente.';
        } else {
            $_SESSION['mensaje_error'] = 'Error al eliminar el videojuego.';
        }

        // Redirigimos de nuevo a configuraciones
        header('location: index.php?accion=configuraciones_videojuegos');
        exit;
        
    }


    // Función para mostrar la página de configuraciones de videojuegos
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

        // Inicializar variables comunes
        $existeReserva = false;
        $usuarioReservado = null;
        $usuarioPrestamo = null;
        $prestamoActivo = false;


        require 'app/vistas/configuraciones.php';
    }


    // Función para buscar videojuegos mediante AJAX
    public function buscarVideojuegosAjax() {
        if (!Sesion::getUsuario()) {
            echo json_encode([]);
            return;
        }
    
        // Crear conexión a la base de datos
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
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
        $idCategoria = $_GET['id'];
        $idCategoria = htmlspecialchars($_GET['id']);
        $categoria = $categoriasDAO->getById($idCategoria);

        // Obtener la categoría del videojuego para poder obtener el nombre de la categoría
        $categoriaId = $videojuego->getIdCategoria();
        $categoria = $categoriasDAO->getById($categoriaId);


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


        // Solo si hay sesión
        if (Sesion::existeSesion()) {
            $usuario = Sesion::getUsuario();

            //$mediaVideojuego = $puntuacionesDAO->obtenerPuntuacionMedia($videojuego->getId());
            $totalVotos = $puntuacionesDAO->contarVotosVideojuego($videojuego->getId());

            // Obtener comentarios de este videojuego
            $comentarios = $comentariosDAO->getComentariosPorVideojuego($idVideojuego);
            $comentarioUsuarioActual = $comentariosDAO->getComentarioPorUsuario($idVideojuego, $usuario->getId());

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

        require 'app/vistas/ver_videojuego.php';
    }


    // FUNCIÓN PARA VER CADA PELICULA PARA ADMINISTRADOR
    public function verPeliculaAdmin(){
        // Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
        $conn = $connexionDB->getConnexion();

        // Creamos los objetos DAO necesarios para acceder a BBDD a través de estos objetos
        $peliculasDAO = new VideojuegosDAO($conn);
        $reservasDAO = new ReservasDAO($conn);
        $categoriasDAO = new CategoriasDAO($conn);
        $prestamosDAO = new PrestamosDAO($conn);
        $usuariosDAO = new UsuariosDAO($conn);
        $peliculasVistasDAO = new Videojuegos_probadosDAO($conn);
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


/*         // Obtener el número de reservas para la pelicula(en nuestro caso será solo 1)
        $videojuegoReservado = $reservasDAO->countByIdVideojuego($idVideojuego);

        // Obtener el usuario que ha reservado la pelicula
        $usuarioReservado = $videojuegoReservado ? $reservasDAO->getUsuarioReservaPorVideojuegoId($idVideojuego) : null;
 */

    /*     // Obtener el número de préstamos para la pelicula(en nuestro caso será solo 1)
        $peliculaPrestada = $prestamosDAO->countByIdPelicula($idPelicula);

        // Obtener el usuario que ha tomado prestada la pelicula (si no ha sido devuelto)
        $usuarioPrestado = $peliculaPrestada ? $prestamosDAO->getUsuarioPrestamoPorPeliculaId($idPelicula) : null; */


    /*     // Obtener el usuario que ha reservado la pelicula
        $usuarioReserva = $reservasDAO->getUsuarioReservaPorPeliculaId($idPelicula);

        // Obtener el número de reservas para la pelicula (en nuestro caso será solo 1)
        $peliculaReservada = $reservasDAO->countByIdPelicula($idPelicula);
 */

/*         // Obtener el usuario que tiene la pelicula prestada o el estado de disponibilidad
        $usuarioPrestamo = $prestamosDAO->getUsuarioPrestamoPorVideojuegoId($idVideojuego);

        // Obtener el número de préstamos para la pelicula (en nuestro caso será solo 1)
        $videojuegoPrestado = $prestamosDAO->countByIdVideojuego($idVideojuego);
 */
        // var_dump($categoria);die();

        require '../app/vistas/ver_pelicula_admin.php';
    }


    // FUNCIÓN PARA VER LOS VIDEOJUEGOS POR CATEGORÍA PARA USUARIOS
    public function verVideojuegosPorCategoria() {
        //Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
        $conn = $connexionDB->getConnexion();

        $idCategoria = $_GET['id'];

        //Creamos el objeto VideojuegosDAO para acceder a BBDD a través de este objeto
        $videojuegosDAO = new VideojuegosDAO($conn);

        $categoriasDAO = new CategoriasDAO($conn);


        // Obtener los videojuegos por categoría
        $videojuegos = $videojuegosDAO->obtenerVideojuegosPorCategoria($idCategoria);

        $idCategoria = htmlspecialchars($_GET['id']);
        $categoria = $categoriasDAO->getById($idCategoria);

        // Incluir la vista de videojuegos por categoría
        require 'app/vistas/videojuegos_por_categoria.php';
    }
    

    public function insertarVideojuego() {
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
            $desarrollador = htmlspecialchars($_POST['desarrollador']);
            $descripcion = htmlspecialchars($_POST['descripcion']);
            $idCategoria = htmlspecialchars($_POST['idCategoria']);
            $fechaLanzamiento = htmlspecialchars($_POST['fecha_lanzamiento']);
            //$trailer = htmlspecialchars($_POST['trailer']); // Permitimos iframe, así que no lo escapamos
            $trailer = $_POST['trailer']; // Permitimos iframe, así que no lo escapamos

            // Aquí manejamos la foto
            $foto_nombre = $_FILES['foto']['name'];   // Nombre de la foto
            $foto_temporal = $_FILES['foto']['tmp_name'];   // Ubicación temporal de la foto
            $ruta_destino = 'web/images/' . $foto_nombre;    // Ruta donde se guardará la foto
    
    
            // Validamos los datos
            if (empty($titulo) || empty($desarrollador) || empty($descripcion) || empty($idCategoria)) {
                $error = "Todos los campos son obligatorios.";
            } else {

                // Creamos el objeto DAO necesario para acceder a los videojuegos en la base de datos
                $videojuegosDAO = new VideojuegosDAO($conn);
    
                // Insertamos el videojuego
                $videojuego = new Videojuego();
                $videojuego->setTitulo($titulo);
                $videojuego->setDesarrollador($desarrollador);
                $videojuego->setDescripcion($descripcion);
                // $videojuego>setFoto("");
                $videojuego->setIdCategoria($idCategoria);
                $videojuego->setFechaLanzamiento($fechaLanzamiento);
                $videojuego->setTrailer($trailer);


                // Movemos la foto al directorio final y guardamos la ruta en el objeto Videojuego
                if (move_uploaded_file($foto_temporal, $ruta_destino)) {
                    $videojuego->setFoto($foto_nombre);
                } else {
                    $error = "Error al cargar la foto.";
                }
    
                if ($videojuegosDAO->insert($videojuego)) {
                    echo "El videojuego se ha insertado correctamente.";
                } else {
                    echo "Error al insertar el videojuego.";
                }
    
                // Redireccionamos a las categorías
                header('location: index.php?accion=videojuegos_por_categoria&id=' . $videojuego->getIdCategoria());
                die();
            }
        }
    
        // Cargamos la vista de insertar videojuego
        require 'app/vistas/insertar_videojuego.php';
    }
    

    public function editarVideojuego(){
        $error ='';
    
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
            //$trailer = htmlspecialchars($_POST['trailer']);
            $trailer = $_POST['trailer'];

    
            // Validamos los datos
            if(empty($titulo) || empty($desarrollador) || empty($descripcion) || empty($idCategoria) || empty($fechaLanzamiento)){
                $error = "Todos los campos son obligatorios.";
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
                        $error = "Error al subir la imagen.";
                    }
                }
    
                if ($videojuegosDAO->update($videojuego)) {
                    echo "El videojuego se ha actualizado correctamente.";
                } else {
                    echo "Error al actualizar el videojuego.";
                }
    
                // Redireccionamos a la vista del Videojuego
                header('location: index.php?accion=ver_videojuego&id=' . $videojuego->getId());
                die();
            }
        }
    
        // Cargamos la vista de editar videojuego
        require 'app/vistas/editar_videojuego.php';
    }


    public function eliminarVideojuego(){
        $error ='';

        // Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnexion();

    }

}
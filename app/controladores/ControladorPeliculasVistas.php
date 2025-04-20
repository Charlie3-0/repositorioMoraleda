<?php 

class ControladorPeliculasVistas {

    /**
     * Ver las películas vistas por un usuario específico
     */
    public function verPeliculasVistas() {
        // Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnexion();

        // Creamos los objetos DAO necesarios para acceder a BBDD a través de estos objetos
        $peliculasDAO = new PeliculasDAO($conn);
        $usuariosDAO = new UsuariosDAO($conn);
        $peliculasUsuariosDAO = new Peliculas_usuariosDAO($conn);

        $idUsuario = htmlspecialchars($_GET['id']);
        $usuario = $usuariosDAO->getById($idUsuario);

        // Obtener las peliculas vistas
        $peliculasVistas = $peliculasUsuariosDAO->obtenerPeliculasVistasMarcadasByIdUsuario($idUsuario);

        // Asignar la pelicula a cada pelicula vista
        foreach ($peliculasVistas as $peliculaVista) {
            $peliculaVista->pelicula = $peliculasDAO->getById($peliculaVista->getIdPelicula());
        }

        require 'app/vistas/ver_peliculas_vistas.php';
    }

    /**
     * Ver todas las películas marcadas como vistas en la base de datos y agrupadas por usuario
     */
    /* public function verTodasPeliculasVistas() {
        // Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnexion();
        
        // Creamos los objetos DAO necesarios para acceder a BBDD a través de estos objetos
        $peliculasDAO = new PeliculasDAO($conn);
        $usuariosDAO = new UsuariosDAO($conn);
        $peliculasVistasDAO = new Peliculas_vistasDAO($conn);

        // Obtener todas las peliculas vistas
        $todasPeliculasVistas = $peliculasVistasDAO->getAllVistasMarcadas();

        // Agrupar películas vistas por usuario
        $peliculasVistasAgrupadas = [];
        

        foreach ($todasPeliculasVistas as $peliculaVista) {
            $pelicula = $peliculasDAO->getById($peliculaVista->getIdPelicula()); // Asignar la pelicula a cada pelicula vista
            $usuario = $usuariosDAO->getById($peliculaVista->getIdUsuario()); // Asignar el usuario a la pelicula vista


            // Agrupar por ID de usuario
            $idUsuario = $usuario->getId();
            if (!isset($peliculasVistasAgrupadas[$idUsuario])) {
                $peliculasVistasAgrupadas[$idUsuario] = [
                    'usuario' => $usuario,
                    'peliculas' => []
                ];
            }

            $peliculasVistasAgrupadas[$idUsuario]['peliculas'][] = [
                'pelicula' => $pelicula,
                'fecha' => $peliculaVista->getFechaVista()
            ];
        }

        // Pasar las peliculas vistas a la vista(ver_todas_peliculas_vistas.php)
        //$peliculasVistas = $todasPeliculasVistas;

        // Enviamos la estructura agrupada a la vista
        $peliculasVistasAgrupadasPorUsuario = $peliculasVistasAgrupadas;

        require '../app/vistas/ver_todas_peliculas_vistas.php';
    } */

    /**
     * Ver todas las películas marcadas como vistas en la base de datos
     */
    /* public function verTodasPeliculasVistas() {
        // Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnexion();
        
        // Creamos los objetos DAO necesarios para acceder a BBDD a través de estos objetos
        $peliculasDAO = new PeliculasDAO($conn);
        $usuariosDAO = new UsuariosDAO($conn);
        $peliculasVistasDAO = new Peliculas_vistasDAO($conn);

        // Obtener todas las peliculas vistas
        $todasPeliculasVistas = $peliculasVistasDAO->getAllVistasMarcadas();

        foreach ($todasPeliculasVistas as $peliculaVista) {
            $peliculaVista->pelicula = $peliculasDAO->getById($peliculaVista->getIdPelicula()); // Asignar la pelicula a cada pelicula vista
            $peliculaVista->usuario = $usuariosDAO->getById($peliculaVista->getIdUsuario()); // Asignar el usuario a la pelicula vista
        }

        // Pasar las peliculas vistas a la vista(ver_todas_peliculas_vistas.php)
        $peliculasVistas = $todasPeliculasVistas;

        require '../app/vistas/ver_todas_peliculas_vistas.php';
    } */

    /**
     * Ver todas las películas marcadas como vistas en la base de datos
     */
    public function verTodasPeliculasVistas() {
        $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnexion();
    
        $peliculasUsuariosDAO = new Peliculas_usuariosDAO($conn);
    
        // Obtenemos las películas agrupadas por usuario
        $peliculasVistasAgrupadasPorUsuario = $peliculasUsuariosDAO->getPeliculasVistasAgrupadasPorUsuario();
    
        // Pasamos los datos a la vista
        require 'app/vistas/ver_todas_peliculas_vistas.php';
    }
    

    /**
     * Marcar una película como vista por un usuario
     */
    function ponerPeliculaVista(){
        $conn = (new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB))->getConnexion();
        $peliculas_usuariosDAO = new Peliculas_usuariosDAO($conn);

        $idUsuario = Sesion::getUsuario()->getId();
        $idPelicula = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

        if($peliculas_usuariosDAO->marcarComoVista($idUsuario, $idPelicula)){
            print json_encode(['respuesta' => 'ok']);
        } else {
            print json_encode(['respuesta' => 'error']);
        }
    }

    /**
     * Desmarcar una película como vista (cambiar estado en vez de eliminar)
     */
    function quitarPeliculaVista(){
        $conn = (new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB))->getConnexion();
        $peliculas_usuariosDAO = new Peliculas_usuariosDAO($conn);
    
        $idUsuario = Sesion::getUsuario()->getId();
        $idPelicula = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    
        if($peliculas_usuariosDAO->quitarVista($idUsuario, $idPelicula)){
            print json_encode(['respuesta' => 'ok']);
        } else {
            print json_encode(['respuesta' => 'error']);
        }
    }




}
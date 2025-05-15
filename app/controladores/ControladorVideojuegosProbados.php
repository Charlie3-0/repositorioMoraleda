<?php 

class ControladorVideojuegosProbados {

    /**
     * Ver los videojuegos probados por un usuario específico
     */
    public function verVideojuegosProbados() {
        // Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnexion();

        // Creamos los objetos DAO necesarios para acceder a BBDD a través de estos objetos
        $videojuegosDAO = new VideojuegosDAO($conn);
        $usuariosDAO = new UsuariosDAO($conn);
        $videojuegosProbadosDAO = new Videojuegos_probadosDAO($conn);

        $idUsuario = htmlspecialchars($_GET['id']);
        $usuario = $usuariosDAO->getById($idUsuario);

        // Obtener los videojuegos probados
        $videojuegosProbados = $videojuegosProbadosDAO->obtenerVideojuegosProbadosMarcadosByIdUsuario($idUsuario);

        // Asignar el videojuego a cada videojuego probado
        foreach ($videojuegosProbados as $videojuegoProbado) {
            $videojuegoProbado->videojuego = $videojuegosDAO->getById($videojuegoProbado->getIdVideojuego());
        }

        require 'app/vistas/ver_videojuegos_probados.php';
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
     * Ver todos los videojuegos probados como probados en la base de datos
     */
    public function verTodosVideojuegosProbados() {
        $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnexion();
    
        $videojuegosProbadosDAO = new Videojuegos_probadosDAO($conn);
    
        // Obtenemos los videojuegos agrupados por usuario
        $videojuegosProbadosAgrupadosPorUsuario = $videojuegosProbadosDAO->getVideojuegosProbadosAgrupadosPorUsuario();
    
        // Pasamos los datos a la vista
        require 'app/vistas/ver_todos_videojuegos_probados.php';
    }
    

    /**
     * Marcar un videojuego como probado por un usuario
     */
    function ponerVideojuegoProbado(){
        $conn = (new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB))->getConnexion();
        $videojuegosProbadosDAO = new Videojuegos_probadosDAO($conn);

        $idUsuario = Sesion::getUsuario()->getId();
        $idVideojuego = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

        if($videojuegosProbadosDAO->marcarComoProbado($idUsuario, $idVideojuego)){
            print json_encode(['respuesta' => 'ok']);
        } else {
            print json_encode(['respuesta' => 'error']);
        }
    }

    /**
     * Desmarcar un videojuego como probado (cambiar estado en vez de eliminar)
     */
    function quitarVideojuegoProbado(){
        $conn = (new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB))->getConnexion();
        $videojuegosProbadosDAO = new Videojuegos_probadosDAO($conn);
    
        $idUsuario = Sesion::getUsuario()->getId();
        $idVideojuego = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    
        if($videojuegosProbadosDAO->quitarProbado($idUsuario, $idVideojuego)){
            print json_encode(['respuesta' => 'ok']);
        } else {
            print json_encode(['respuesta' => 'error']);
        }
    }




}
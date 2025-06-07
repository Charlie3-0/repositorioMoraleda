<?php 

class ControladorVideojuegosProbados {

    /**
     * Ver los videojuegos probados por un usuario específico
     */
    public function verVideojuegosProbados() {
        // Comprobamos si hay sesión y si hay un usuario conectado
        $usuario = Sesion::getUsuario();
        if (!$usuario) {
            $_SESSION['mensaje_error'] = 'Acceso denegado.';
            header('location: index.php');
            exit;
        }

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
        $videojuegosProbados = $videojuegosProbadosDAO->obtenerVideojuegosProbadosByIdUsuario($idUsuario);

        // Asignar el videojuego a cada videojuego probado
        foreach ($videojuegosProbados as $videojuegoProbado) {
            $videojuegoProbado->videojuego = $videojuegosDAO->getById($videojuegoProbado->getIdVideojuego());
        }

        require 'app/vistas/ver_videojuegos_probados.php';
    }


    /**
     * Ver todos los videojuegos probados en la base de datos
     */
    public function verTodosVideojuegosProbados() {
        $usuario = Sesion::getUsuario();
        if (!$usuario || $usuario->getRol() !== 'A') {
            $_SESSION['mensaje_error'] = 'Acceso denegado.';
            header('location: index.php');
            exit;
        }

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
        // Comprobamos si hay sesión y si hay un usuario conectado
        $usuario = Sesion::getUsuario();
        if (!$usuario) {
            $_SESSION['mensaje_error'] = 'Acceso denegado.';
            header('location: index.php');
            exit;
        }

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
        // Comprobamos si hay sesión y si hay un usuario conectado
        $usuario = Sesion::getUsuario();
        if (!$usuario) {
            $_SESSION['mensaje_error'] = 'Acceso denegado.';
            header('location: index.php');
            exit;
        }

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
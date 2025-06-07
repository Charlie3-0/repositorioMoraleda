<?php 

class ControladorReservas {

    function insertarReserva(){
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

        $idVideojuego = filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);
        $reservasDAO = new ReservasDAO($conn);
        $reserva = new Reserva();
        $reserva->setIdVideojuego($idVideojuego);
        $reserva->setIdUsuario(Sesion::getUsuario()->getId());
        $reserva->setFechaReserva(date('Y-m-d H:i:s'));
        if($reservasDAO->insert($reserva)){
            $videojuegoReservado = $reservasDAO->countByIdVideojuego($idVideojuego);
            print json_encode(['respuesta'=>'ok','videojuegoReservado'=>$videojuegoReservado]);
        }else{
            print json_encode(['respuesta'=>'error']);
        }
    }

    function borrarReserva(){
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

        $idVideojuego = filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);
        $reservasDAO = new ReservasDAO($conn);
        if(!$reserva = $reservasDAO->getByIdUsuarioIdVideojuego(Sesion::getUsuario()->getId(),$idVideojuego)){
            print json_encode(['respuesta'=>'error', 'mensaje'=>'la reserva no existe']);
            die();
        }
        
        if($reservasDAO->delete($reserva)){
            $videojuegoReservado = $reservasDAO->countByIdVideojuego($idVideojuego);
            print json_encode(['respuesta'=>'ok','videojuegoReservado'=>$videojuegoReservado]);
        }else{
            print json_encode(['respuesta'=>'error']);
        }
    }


    /**
     * Quitar la reserva de un videojuego por parte de un administrador
     */
    public function quitarReservaAdmin() {
        $usuario = Sesion::getUsuario();
        if (!$usuario || $usuario->getRol() !== 'A') {
            $_SESSION['mensaje_error'] = 'Acceso denegado.';
            header('location: index.php');
            exit;
        }
    
        $idVideojuego = $_GET['idVideojuego'];
    
        $conn = (new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB))->getConnexion();
        $reservasDAO = new ReservasDAO($conn);
    
        if ($reservasDAO->deleteByIdVideojuego($idVideojuego)) {
            $_SESSION['mensaje_ok'] = 'Reserva eliminada correctamente.';
        } else {
            $_SESSION['mensaje_error'] = 'Error al eliminar la reserva.';
        }
    
        header('location: index.php?accion=configuraciones_videojuegos');
    }
    


    public function verReservas(){
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
        $usuariosDAO = new UsuariosDAO($conn);


        $idUsuario =htmlspecialchars($_GET['id']);
        $usuario = $usuariosDAO->getById($idUsuario);

        // Obtener las reservas
        $reservas = $reservasDAO->obtenerReservasByIdUsuario($idUsuario);
        
        // Asignar el videojuego a cada reserva
        foreach ($reservas as $reserva) {
            $reserva->videojuego = $videojuegosDAO->getById($reserva->getIdVideojuego());
        }

        require 'app/vistas/ver_reservas.php';
    }


    public function verTodasReservas(){
        $usuario = Sesion::getUsuario();
        if (!$usuario || $usuario->getRol() !== 'A') {
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
        $usuariosDAO = new UsuariosDAO($conn);

        $reservasDAO = new ReservasDAO($conn);

        // Obtenemos las reservas agrupadas por usuario
        $reservasAgrupadas = $reservasDAO->getReservasAgrupadasPorUsuario();

        require 'app/vistas/ver_todas_reservas.php';
    }

}


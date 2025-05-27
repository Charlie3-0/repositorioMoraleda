<?php 

class ControladorReservas {

    function insertarReserva(){
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


    public function verReservas(){
        // Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
        $conn = $connexionDB->getConnexion();

        // Creamos los objetos DAO necesarios para acceder a BBDD a través de estos objetos
        $videojuegosDAO = new VideojuegosDAO($conn);
        $reservasDAO = new ReservasDAO($conn);
        $usuariosDAO = new UsuariosDAO($conn);


        $idUsuario =htmlspecialchars($_GET['id']);
        $usuario = $usuariosDAO->getById($idUsuario);
        //var_dump($_GET);

        // Obtener las reservas
        $reservas = $reservasDAO->obtenerReservasByIdUsuario($idUsuario);
        
        // Asignar el videojuego a cada reserva
        foreach ($reservas as $reserva) {
            $reserva->videojuego = $videojuegosDAO->getById($reserva->getIdVideojuego());
        }

        require 'app/vistas/ver_reservas.php';
    }


    public function verTodasReservas(){
        // Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
        $conn = $connexionDB->getConnexion();

        // Creamos los objetos DAO necesarios para acceder a BBDD a través de estos objetos
        $videojuegosDAO = new VideojuegosDAO($conn);
        $reservasDAO = new ReservasDAO($conn);
        $usuariosDAO = new UsuariosDAO($conn);

        // Obtener todas las reservas
        $todasLasReservas = $reservasDAO->getAll();
        
        
        foreach ($todasLasReservas as $reserva) {
            $reserva->videojuego = $videojuegosDAO->getById($reserva->getIdVideojuego()); // Asignar el videojuego a cada reserva
            $reserva->usuario = $usuariosDAO->getById($reserva->getIdUsuario()); // Asignar el usuario a la reserva
        }

        // Pasar las reservas a la vista
        $reservas = $todasLasReservas;

        require 'app/vistas/ver_todas_reservas.php';
    }

}


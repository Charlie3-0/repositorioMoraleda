<?php 

class ControladorReservas {

    function insertarReserva(){
        //Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
        $conn = $connexionDB->getConnexion();

        $idPelicula = filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);
        $reservasDAO = new ReservasDAO($conn);
        $reserva = new Reserva();
        $reserva->setIdPelicula($idPelicula);
        $reserva->setIdUsuario(Sesion::getUsuario()->getId());
        if($reservasDAO->insert($reserva)){
            $peliculaReservada = $reservasDAO->countByIdPelicula($idPelicula);
            print json_encode(['respuesta'=>'ok','peliculaReservada'=>$peliculaReservada]);
        }else{
            print json_encode(['respuesta'=>'error']);
        }
    }

    function borrarReserva(){
        //Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
        $conn = $connexionDB->getConnexion();

        $idPelicula = filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);
        $reservasDAO = new ReservasDAO($conn);
        if(!$reserva = $reservasDAO->getByIdUsuarioIdPelicula(Sesion::getUsuario()->getId(),$idPelicula)){
            print json_encode(['respuesta'=>'error', 'mensaje'=>'la reserva no existe']);
            die();
        }
        
        if($reservasDAO->delete($reserva)){
            $peliculaReservada = $reservasDAO->countByIdPelicula($idPelicula);
            print json_encode(['respuesta'=>'ok','peliculaReservada'=>$peliculaReservada]);
        }else{
            print json_encode(['respuesta'=>'error']);
        }
    }


    public function verReservas(){
        // Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
        $conn = $connexionDB->getConnexion();

        // Creamos los objetos DAO necesarios para acceder a BBDD a través de estos objetos
        $peliculasDAO = new PeliculasDAO($conn);
        $reservasDAO = new ReservasDAO($conn);
        $usuariosDAO = new UsuariosDAO($conn);


        $idUsuario =htmlspecialchars($_GET['id']);
        $usuario = $usuariosDAO->getById($idUsuario);
        //var_dump($_GET);

        // Obtener las reservas
        $reservas = $reservasDAO->obtenerReservasByIdUsuario($idUsuario);
        
        // Asignar la pelicula a cada reserva
        foreach ($reservas as $reserva) {
            $reserva->pelicula = $peliculasDAO->getById($reserva->getIdPelicula());
        }

        require 'app/vistas/ver_reservas.php';
    }


    public function verTodasReservas(){
        // Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
        $conn = $connexionDB->getConnexion();

        // Creamos los objetos DAO necesarios para acceder a BBDD a través de estos objetos
        $peliculasDAO = new PeliculasDAO($conn);
        $reservasDAO = new ReservasDAO($conn);
        $usuariosDAO = new UsuariosDAO($conn);

        // Obtener todas las reservas
        $todasLasReservas = $reservasDAO->getAll();
        
        
        foreach ($todasLasReservas as $reserva) {
            $reserva->pelicula = $peliculasDAO->getById($reserva->getIdPelicula()); // Asignar la pelicula a cada reserva
            $reserva->usuario = $usuariosDAO->getById($reserva->getIdUsuario()); // Asignar el usuario a la reserva
        }

        // Pasar las reservas a la vista
        $reservas = $todasLasReservas;

        require 'app/vistas/ver_todas_reservas.php';
    }

}


<?php 

class ControladorPuntuaciones {

    /**
     * Puntuar una película por un usuario
     */
    function guardarPuntuacion() {
        $conn = (new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB))->getConnexion();
        $peliculas_usuariosDAO = new Peliculas_usuariosDAO($conn);

        if (!Sesion::existeSesion()) {
            print json_encode(['respuesta' => 'no_sesion']);
            exit;
        }

        $idUsuario = Sesion::getUsuario()->getId();
        $idPelicula = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        $puntuacion = filter_var($_POST['puntuacion'], FILTER_SANITIZE_NUMBER_INT);

        if ($puntuacion < 1 || $puntuacion > 10) {
            print json_encode(['respuesta' => 'puntuacion_invalida']);
            exit;
        }

        if ($peliculas_usuariosDAO->ponerEditarPuntuacion($idUsuario, $idPelicula, $puntuacion)) {
            $media = $peliculas_usuariosDAO->obtenerPuntuacionMedia($idPelicula);
            echo json_encode([
                'respuesta' => 'ok',
                'nuevaMedia' => $media
            ]);
        } else {
            print json_encode(['respuesta' => 'error']);
        }
    }





    
}
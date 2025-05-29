<?php 

class ControladorPuntuaciones {

    /**
     * Puntuar un videojuego por un usuario
     */
    function guardarPuntuacion() {
        $conn = (new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB))->getConnexion();
        $puntuacionesDAO = new PuntuacionesDAO($conn);

        if (!Sesion::existeSesion()) {
            print json_encode(['respuesta' => 'no_sesion']);
            exit;
        }

        $idUsuario = Sesion::getUsuario()->getId();
        $idVideojuego = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        $puntuacion = filter_var($_POST['puntuacion'], FILTER_SANITIZE_NUMBER_INT);

        if ($puntuacion < 1 || $puntuacion > 10) {
            print json_encode(['respuesta' => 'puntuacion_invalida']);
            exit;
        }

        if ($puntuacionesDAO->ponerEditarPuntuacion($idUsuario, $idVideojuego, $puntuacion)) {
            $media = $puntuacionesDAO->obtenerPuntuacionMedia($idVideojuego);
            $votos = $puntuacionesDAO->contarVotosVideojuego($idVideojuego);
            echo json_encode([
                'respuesta' => 'ok',
                'nuevaMedia' => $media,
                'votos' => $votos
            ]);
        } else {
            print json_encode(['respuesta' => 'error']);
        }
    }

    
}
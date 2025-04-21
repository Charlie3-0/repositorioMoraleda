<?php 

class ControladorComentarios {

    /**
     * Guardar un comentario de una película por un usuario
     */
    function guardarComentario() {
        $conn = (new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB))->getConnexion();
        $peliculas_usuariosDAO = new Peliculas_usuariosDAO($conn);
    
        if (!Sesion::existeSesion()) {
            echo json_encode(['respuesta' => 'no_sesion']);
            exit;
        }
    
        $idUsuario = Sesion::getUsuario()->getId();
        $idPelicula = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        $comentario = trim(filter_input(INPUT_POST, 'comentario', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    
        if (empty($comentario)) {
            echo json_encode(['respuesta' => 'comentario_vacio']);
            exit;
        }
    
        if ($peliculas_usuariosDAO->ponerComentario($idUsuario, $idPelicula, $comentario)) {
            echo json_encode(['respuesta' => 'ok', 'comentario' => $comentario]);
        } else {
            echo json_encode(['respuesta' => 'error']);
        }
    }
    
    


    
}
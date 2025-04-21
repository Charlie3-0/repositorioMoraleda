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
    
    /* public function guardarComentario() {
        $conn = (new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB))->getConnexion();
        if (isset($_POST['idPelicula']) && isset($_POST['comentario'])) {
            $idPelicula = $_POST['idPelicula'];
            $comentario = $_POST['comentario'];
            $fechaComentario = date('Y-m-d H:i:s');
    
            $usuario = Sesion::getUsuario();
            if (!$usuario) {
                echo json_encode(['success' => false, 'error' => 'No hay sesión activa.']);
                return;
            }
    
            $idUsuario = $usuario->getId();
    
            $peliculas_usuariosDAO = new Peliculas_usuariosDAO($conn);
            $peliculas_usuariosDAO->ponerComentario($idPelicula, $idUsuario, $comentario, $fechaComentario);
    
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Datos incompletos.']);
        }
    } */
    
    


    
}